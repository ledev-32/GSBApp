<?php 
// Nommage du répertoire de sessions
session_save_path("../../sessions"); //---CHEMIN A MODIFIER EN PASSAGE SITE
session_start();
?>

<?php 
// ---Requêtage BDD pour récupérer les informations

include("/connexionBase.php");
$userName = $_POST["username"];
$userMdp = $_POST["userMotDePasse"];
//if ($userName contient espace)
//      $userName = null;

// Ecriture de la requête Identifiant
$rSQL = "SELECT collMdp,collStatut,collMatricule FROM collaborateur WHERE collMatricule = '$userName'";

// Envoi de la requête au SGBD
$resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");

// Détermination du nombre de ligne
$ligne = $resultSQL->fetch();

// Récupération du mot de passe
$bddMdp = $ligne[0];
$bddStatus = $ligne[1];
$bddMatricule = $ligne[2];

echo $bddStatus;


// ---Vérification des identifiants
if ($userMdp == $bddMdp) {
    $_SESSION["userStatus"] = $bddStatus;
    $_SESSION["userMatricule"] = $bddMatricule;
    $info = $rSQL."\n".$ligne."\n";
    file_put_contents('riendimportant.log',$info,FILE_APPEND);
    header("Location:../index.php");
}
else {
    $info = $rSQL."\n".$ligne[0].$ligne[1]."\n";
    file_put_contents('riendimportant.log',$info,FILE_APPEND);
    header("Location:authent.html");
}
session_write_close();
?>