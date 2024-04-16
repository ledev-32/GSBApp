<?php
	// Define the constants to open a connexion with DataBase
	$hote="localhost"; //
	$login="root";
	$mdp="";
	$nombd="gsb-v1"; 

	// Connection au serveur
	try { 
		$connexion = new PDO("mysql:host=$hote;dbname=$nombd",$login,$mdp);
	} catch ( Exception $e ) {
		die("Connexion à '$hote' impossible : ".$e->getMessage());
	}
?>
