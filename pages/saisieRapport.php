<?php // ---Script de récupération de l'id du rapport
                require("connexionBase.php");

                $rSQL = "SELECT id FROM rapportvisite";
                $resultSQL = $connexion->query($rSQL) or die("NIQUE TA MERE TETE DE NEUILLLLLEEEEEE ta requête ne passe pas");
                $ligne = $resultSQL->fetch();
                $_SESSION["idRapport"] = end($ligne);
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
        <h1>MaKo - Saisie de Rapport des Visites 
        </h1>
        <div class="menu">
            <a href="#">Consultations des rapports</a>
            <a href="../saisieRapport.html">Rapport de visites</a>
            <a href="#">Déconnexion</a>
            <a href="../index.php">Accueil</a>
        </div>
    </header>
    <main>
        <section class="rapport">
            <h2>Saisie du Rapport</h2>
            
            <form action="envoiRapport.php" method="post" name="saisieRapport">
                <?php 
                    $numRapport = $_SESSION["idRapport"] + 1;
                    echo "Vous êtes au rapport numéro ".$numRapport;
                ?>
                <br/>
                Date du rapport : <input type="date" name="date" id="date" size="20"> <br/>
                Praticien : 
                <?php //Script récupérant la liste des praticiens
                    require("connexionBase.php");

                    $rSQL = "SELECT praNum,praNom,praPrenom FROM praticien";
                    $resultSQL = $connexion->query($rSQL) or die("NIQUE TA MERE TETE DE NEUILLLLLEEEEEE ta requête ne passe pas");
                    $ligne = $resultSQL->fetch();
                    echo "<select name='praticien' size='1'>";
                    while ($ligne!=false) {

                        echo "<option value='".$ligne[0]."'>".$ligne[1]." ".$ligne[2]."</option>";
                        $ligne = $resultSQL->fetch();
                    }
                    echo "</select>";
                ?>
                <br/>
                Bilan : <input type="textarea

                <br/>
                <input type="submit" value="Se connecter">
            </form>
        </section>
    </main>
</body>
</html>