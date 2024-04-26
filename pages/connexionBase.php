<?php
	// Define the constants to open a connexion with DataBase
	$hote="localhost"; //
	$login="root";
	$mdp="";
	$nombd="gsv-v2"; 

	// Connection au serveur
	try { 
		$connexion = new PDO("mysql:host=$hote;dbname=$nombd",$login,$mdp);
	} catch ( Exception $e ) {
		die("Connexion à '$hote' impossible : ".$e->getMessage());
	}
?>
