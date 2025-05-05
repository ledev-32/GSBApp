<?php 
session_save_path("/var/www/GSB/sessions");
session_start();

// Détruire toutes les sessions
$_SESSION = array();
session_destroy();

// Rediriger vers la page d'accueil
header("Location: ../index.php");
exit();
?>