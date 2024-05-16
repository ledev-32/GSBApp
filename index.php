<?php // ---Démarrage de la session dans le dossier convenu
session_save_path("sessions"); //!!!!!! A REDEFINIR
session_start();
?>



<?php 
    // ---Vérification de la session
    // Si la session (matricule) est active alors redirection vers la page d'accueil 
    // Sinon redirection vers la page HTML de login+
    if (isset($_SESSION["userMatricule"])) {
        echo $_SESSION["userMatricule"];
        echo $_SESSION["userStatus"];
        if ($_SESSION["userStatus"] == "visiteur") {
            header("Location:pages/visiteur/"); //Disponible
        }
        //else if ($_SESSION["userStatus"] == "délégué") {
        //    header("Location:pages/delegue/index.html"); //Indisponible
        //}
        //else if ($_SESSION["userStatus"] == "responsable") {
        //    header("Location:pages/responsable/index.html"); //Indisponible
        //}
    } 
    else
        header("Location:pages/authent.html");
?>