<?php // ---Démarrage de la session dans le dossier convenu
    session_save_path("../../sessions"); //!!!!!! A REDEFINIR
    session_start();
?>

<?php 
    // ---Récupération du PDO de connexion (permettant la connexion à la base de donnée)
    require("connexionBase.php");

    // ---Récupération du nom d'utilisateur et du mot de passe saisi dans authent.html
    $userName = $_POST["username"];
    $userMdp = $_POST["userMotDePasse"];

    // ---Expression et envoie de la requête récupérant le Mot de passe, le statut et le matricule de l'utilisateur
    // ---Correspondant au matricule de l'utilisateur qui veut se connecter
    $rSQL = "SELECT collMdp,collStatut,collMatricule FROM collaborateur WHERE collMatricule = '$userName'";
    $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");

    // ---Réception et stockage dans un tableau du résultat de la requête
    $ligne = $resultSQL->fetch();

    // ---Récupération des résultats de la requête dans des variables (pour plus de simplicité)
    $bddMdp = $ligne[0];        // ---Mot de passe du collaborateur
    $bddStatus = $ligne[1];     // ---Statut du collaborateur
    $bddMatricule = $ligne[2];  // ---Matricule du collaborateur

    // ---Vérification des identifiants
    if ($userMdp == $bddMdp) {                      // ---Si le mot de passe du formulaire est le même que celui de la base de donnée :
                                                    // ---Alors on stocke le statut et le matricule de l'utilisateur dans la session
        $_SESSION["userStatus"] = $bddStatus;       
        $_SESSION["userMatricule"] = $bddMatricule;
        header("Location:../index.php");            // ---Puis on redirige vers la page index.php principale
    }
    else {                                          // ---Sinon
                                                    // ---On redirige vers le formulaire authent.html
        header("Location:authent.html");
    }
    session_write_close(); // ---Fermmeture de la session
?>