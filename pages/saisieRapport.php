<?php // ---Script de récupération de l'id du rapport
                require("connexionBase.php");

                $rSQL = "SELECT id FROM rapportvisite";
                $resultSQL = $connexion->query($rSQL) or die("Votre requête ne passe pas");
                $ligne = $resultSQL->fetch();
                $_SESSION["idRapport"] = end($ligne);
                echo $_SESSION["idRapport"];
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
                    echo "<h1>Vous êtes au rapport numéro ".$numRapport."</h1>";
                ?>
                <br/>
                Date du rapport : <input type="date" name="date" id="date" size="20"> <br/>
                Praticien : 
                <?php //Script récupérant la liste des praticiens
                    require("connexionBase.php");
                    $rSQL = "SELECT praNum,praNom,praPrenom FROM praticien";
                    $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");
                    $ligne = $resultSQL->fetch();
                    echo "<select name='praticien' size='1'>";
                    while ($ligne!=false) {

                        echo "<option value='".$ligne[0]."'>".$ligne[1]." ".$ligne[2]."</option>";
                        $ligne = $resultSQL->fetch();
                    }
                    echo "</select>";
                ?>
                <br/>
                Bilan : 
                <textarea id="bilan" name="bilan" rows="5" cols="33">Bilan de la séance
                </textarea>
                <br/>
                Coefficient de Confiance : 
                <select name="coeffConfiance" size="1">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <br/>
                Motif : 
                <select name="motif" size=1>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
                <br/>
                Médicaments Présentés (obligatoirement 2) :
                <br/> 
                <?php //Script récupérant la liste des médicaments
                    require("connexionBase.php");

                    $rSQL = "SELECT medDepotlegal,medNomcommercial FROM medicament";
                    $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");
                    $ligne = $resultSQL->fetch();
                    echo "<select name='medicaments[]' size='4' multiple>";
                    while ($ligne!=false) {

                        echo "<option value='".$ligne[0]."'>".$ligne[1]."</option>";
                        $ligne = $resultSQL->fetch();
                    }
                    echo "</select>";
                ?>
                <br/>
                <div id="caseEchant"> 
                    Echantillons (maximum 2) : 
                    <br/>
                    <?php //Script récupérant la liste des médicaments
                        require("connexionBase.php");

                        $rSQL = "SELECT medDepotlegal,medNomcommercial FROM medicament";
                        $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");
                        $ligne = $resultSQL->fetch();
                        echo "<select name='echantillons[]' size='4' multiple>";
                        while ($ligne!=false) {
                            echo "<option value='".$ligne[0]."'>".$ligne[1]."</option>";
                            $ligne = $resultSQL->fetch();
                        }
                        echo "</select>";
                ?>
                </div>
                
                
                <br/>
                <input type="reset" value="Annuler">
                <input type="submit" value="Se connecter">
            </form>
        </section>
    </main>
</body>
</html>