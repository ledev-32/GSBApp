<?php 
    session_save_path("../../sessions");
    session_start();
?>

<?php 
    //On vérifie si l'utilisateur est authorisé à y rentrer
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../index.php");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma page Web</title>
    <!--<link rel="stylesheet" href="style.css">-->
</head>
<body>
    <header>
        <h1>MaKo - Consultation des Rapports</h1>
        <div class="menu">
            <a href="#">Consultations des rapports</a>
            <a href="saisieRapport.php">Saisie des rapports</a>
            <a href="modificationRapport.php">Modification des rapports</a>
            <a href="../index.php">Accueil</a>
            <a href="#">Déconnexion</a>
        </div>
    </header>
    <main>
        <section id="consultation">
            <?php 
                require("connexionBase.php");
                $rSQL = "SELECT rapportvisite.id,praticien.praNom,praticien.praPrenom,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1,echantillonPres2 FROM rapportvisite,praticien WHERE rapportvisite.praNum = praticien.praNum AND collMatricule = '".$_SESSION['userMatricule']."'";
                $resultSQL = $connexion->query($rSQL) or die($rSQL.print_r($connexion->errorInfo(), true));
                $ligne = $resultSQL->fetch();
                echo "<table border='1'>";
                echo "<tr><th>Id</th><th>Nom du Praticien</th><th>Prénom du Praticien</th><th>Date du rapport</th><th>Bilan du rapport</th><th>Motif du rapport</th><th>Coefficient de confiance</th><th>Médicament 1</th><th>Médicament 2</th><th>Echantillon 1</th><th>Echantillon 2</th></tr>";
                while($ligne!=false) {
		            // On stocke le contenu des cellules du
                    // tableau associatif dans des  variables
		            $idRapport=$ligne[0];
                    $praNom=$ligne[1];
                    $praPrenom=$ligne[2];
                    $rapDate=$ligne[3];
                    $rapBilan=$ligne[4];
                    $rapMotif=$ligne[5];
                    $coeffConfiance=$ligne[6];
                    $medicament1=$ligne[7];
                    $medicament2=$ligne[8];
                    $echantillon1=$ligne[9];
                    $echantillon2=$ligne[10];



                    // Affichage des informations sous forme de tableau
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
                    echo "</tr>";

		            // Lecture de la ligne suivante du jeu d'enregistrementse
		            $ligne=$resultSQL->fetch();
	            }
                echo "</table>";
            ?>
        </section>
    </main>
</body>
</html>