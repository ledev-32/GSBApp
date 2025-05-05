<?php
	// ---Définition des variables pour le PDO
	$hote="localhost"; // ---A remplacer par l'adresse IP du serveur
	$login="admin"; // ---A remplacer par le nom du compte
	$mdp="Azerty31"; // ---A remplacer par le mot de passe du compte utilisant la base de donnée
	$nombd="gsb"; // ---A remplacer par le nom de la base de donnée voulue

	// Connection au serveur
	try { 
		$connexion = new PDO("mysql:host=$hote;dbname=$nombd",$login,$mdp); // ---Connexion grâce à l'objet de type PDO dans la variable $connexion
	} catch ( Exception $e ) {
		die("Connexion à '$hote' impossible : ".$e->getMessage()); // ---En cas d'erreur, affiche le message renvoyé par l'hôte de la base de donnée
	}
?>
