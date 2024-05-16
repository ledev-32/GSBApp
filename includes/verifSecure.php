<?php // ---Démarrage de la session dans le dossier convenu
    session_save_path("../sessions"); //!!!!!! A REDEFINIR
    session_start();
?>

<?php // ---Vérification d'authentification (par rapport au statut [visiteur,délégué,responsable])
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../index.php"); // Si le statut de session est pas bon alors redirection vers index principal
    }
?>