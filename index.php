<?php 
// Nommage du répertoire de sessions
session_save_path("../sessions"); //---CHEMIN A MODIFIER EN PASSAGE SITE

// Démarrage de la session
session_start();
?>



<?php 
    // Démarrage du script pour instancier une connexion avec la base de données
    require("pages/connexionBase.php");

    // Vérification de la session
    // Si la session est active alors redirection vers la page d'accueil
    // Sinon redirection vers la page HTML de login
    if (isset($_SESSION["userMatricule"])) {
        if ($_SESSION["userStatus"] == "visiteur") {
            header("Location:pages/visiteur/index.php"); //Disponible
        }
        else if ($_SESSION["userStatus"] == "délégué") {
            header("Location:pages/delegue/index.html"); //Indisponible
        }
        else if ($_SESSION["userStatus"] == "responsable") {
            header("Location:pages/responsable/index.html"); //Indisponible
        }
    } 
    else
        header("Location:pages/authent.html");
?>