<?php 
    require("../includes/verifSecure.php")
?>

<?php // ---Vérification d'authentification (par rapport au statut [visiteur,délégué,responsable])
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../index.php"); // Si le statut de session est pas bon alors redirection vers index principal
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB - Consultation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>GSB - Consultation de rapports des visites</h1>
        <div class="menu">
            <a href="#">Consultations des rapports</a>
            <a href="saisieRapport.php">Saisie des rapports de visite</a>
            <a href="rechercheMedicament.php">Recherche de médicaments</a>
            <a href="../index.php">Accueil</a>
            <a href="deconnexion.php">Déconnexion</a>
        </div>
        <p>Vous pouvez consulter vos rapports : </p>
    </header>
    <main>
        <section id="consultation">
            <?php 
                // ---Récupération du PDO de connexion (permettant la connexion à la base de donnée)
                require("../includes/connexionBase.php");

                // ---Expression et envoi de la requête complète récupérant toutes les informations d'un rapport donnée (par son Id)
                $rSQL = "SELECT rapportvisite.id,praticien.praNom,praticien.praPrenom,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1,echantillonPres2 FROM rapportvisite,praticien WHERE rapportvisite.praNum = praticien.praNum AND collMatricule = '".$_SESSION['userMatricule']."'";
                $resultSQL = $connexion->query($rSQL) or die($rSQL.print_r($connexion->errorInfo(), true));

                // ---Réception et stockage dans un tableau du résultat de la requête
                $ligne = $resultSQL->fetch();

                // ---Création d'un tableau pour l'affichage
                echo "<table border='1'>";
                echo "<tr><th>Id</th><th>Nom du Praticien</th><th>Prénom du Praticien</th><th>Date du rapport</th><th>Bilan du rapport</th><th>Motif du rapport</th><th>Coefficient de confiance</th><th>Médicament 1</th><th>Médicament 2</th><th>Echantillon 1</th><th>Echantillon 2</th><th>Modification</th></tr>";

                // ---Boucle pour parcourir le tableau des valeurs résultats de la requête
                while($ligne!=false) {
		            // ---Récupération des résultats de la requête dans des variables (pour plus de simplicité)
		            $idRapport=$ligne[0];       // ---Id du rapport
                    $praNom=$ligne[1];          // ---Nom du praticien
                    $praPrenom=$ligne[2];       // ---Prénom du praticien
                    $rapDate=$ligne[3];         // ---Date du rapport
                    $rapBilan=$ligne[4];        // ---Bilan du rapport
                    $rapMotif=$ligne[5];        // ---Motif du rapport
                    $coeffConfiance=$ligne[6];  // ---Coefficient de confiance du praticien
                    $medicament1=$ligne[7];     // ---Médicament présenté 1
                    $medicament2=$ligne[8];     // ---Médicament présenté 2
                    $echantillon1=$ligne[9];    // ---Echantillon 1 (peut être NULL)
                    $echantillon2=$ligne[10];   // ---Echantillon 2 (peut être NULL)



                    // ---Affichage des variables dans une ligne du tableau
                    echo "<tr>";
                    echo "<td>".$idRapport."</td>";
                    echo "<td>".$praNom."</td>";
                    echo "<td>".$praPrenom."</td>";
                    echo "<td>".$rapDate."</td>";
                    echo "<td>".$rapBilan."</td>";
                    echo "<td>".$rapMotif."</td>";
                    echo "<td>".$coeffConfiance."</td>";
                    echo "<td>".$medicament1."</td>";
                    echo "<td>".$medicament2."</td>";
                    echo "<td>".$echantillon1."</td>";
                    echo "<td>".$echantillon2."</td>";
                    echo "<td>"."<a href='modificationRapport.php?idrapport=".$idRapport."'>"."Modifier</a>"."</td>";
                    echo "</tr>";

		            // ---Passage à la ligne suivante
		            $ligne=$resultSQL->fetch();
	            }
                // ---Fermeture du tableau
                echo "</table>";
            ?>
        </section>
    </main>
</body>
</html>