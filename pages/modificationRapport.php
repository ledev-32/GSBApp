<?php 
    session_save_path("../../sessions");
    session_start();
    require("connexionBase.php");
?>

<?php 
    //On vérifie si l'utilisateur est authorisé à y rentrer
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../index.php");
    }
?>

<?php // ---Script de récupération de l'id du rapport
                $ligne = 5;
                $_SESSION["idRapportAModifier"] = $ligne;
                echo $_SESSION["idRapportAModifier"];
?>

<?php 

    // ---Récupération des valeurs du rapport à modifier
    // ---Initialisation des variables nécessaires ::::
    $idRapport = $_SESSION["idRapportAModifier"];

    // ---Récupération des valeurs du rapport à modifier ::::
    $rSQL = "SELECT collMatricule,praticien.praNom,praticien.praPrenom,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1,echantillonPres2 FROM praticien,rapportvisite WHERE praticien.praNum = rapportvisite.praNum AND rapportvisite.id = 5";
    $resultSQL = $connexion->query($rSQL) or die ($rSQL.print_r($connexion->errorInfo(), true));
    $ligne = $resultSQL->fetch();


    // ---Stockage des valeurs dans les variables de réutilisation ::::
    $collMatricule = $ligne[0];
    $praticien = $ligne[1].$ligne[2];
    $dateRapport = $ligne[3];
    $bilanVisite = $ligne[4];
    $motifVisite = $ligne[5];
    $coefConf = $ligne[6];
    $medicament1 = $ligne[7];
    $medicament2 = $ligne[8];
    $echantillon1 = $ligne[9];
    $echantillon2 = $ligne[10];
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
        <h1>MaKo - Modification des rapports de visite
        </h1>
        <div class="menu">
            <a href="consultationRapport.php">Consultations des rapports</a>
            <a href="saisieRapport.html">Rapport de visites</a>
            <a href="#">Déconnexion</a>
            <a href="../index.php">Accueil</a>
        </div>
    </header>
    <main>
        <section class="rapport">
            <h2>Modification du rapport</h2>
            
            <form action="modificationRapport.php" method="post" name="saisieRapport">
                <?php 
                    $numRapport = $_SESSION["idRapportAModifier"];
                    echo "<h1>Vous êtes au rapport numéro ".$numRapport."</h1>";
                ?>
                <br/>
                Date du rapport : <input type="date" name="date" id="date" size="20" value="<?php echo $dateRapport;?>"> <br/>
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
                <textarea id="bilan" name="bilan" rows="5" cols="33"><?php echo $bilanVisite;?>
                </textarea>
                <br/>
                Coefficient de Confiance : 
                <select name="coeffConfiance" size="1">
                    <option value="0" <?php if ($coefConf=="0") {echo "selected='selected'" ;} ?>>0</option>
                    <option value="1" <?php if ($coefConf=="1") {echo "selected='selected'" ;} ?>>1</option>
                    <option value="2" <?php if ($coefConf=="2") {echo "selected='selected'" ;} ?>>2</option>
                    <option value="3" <?php if ($coefConf=="3") {echo "selected='selected'" ;} ?>>3</option>
                    <option value="4" <?php if ($coefConf=="4") {echo "selected='selected'" ;} ?>>4</option>
                    <option value="5" <?php if ($coefConf=="5") {echo "selected='selected'" ;} ?>>5</option>
                    <option value="6" <?php if ($coefConf=="6") {echo "selected='selected'" ;} ?>>6</option>
                    <option value="7" <?php if ($coefConf=="7") {echo "selected='selected'" ;} ?>>7</option>
                    <option value="8" <?php if ($coefConf=="8") {echo "selected='selected'" ;} ?>>8</option>
                    <option value="9" <?php if ($coefConf=="9") {echo "selected='selected'" ;} ?>>9<choice/></option>
                    <option value="10" <?php if ($coefConf=="10") {echo "selected='selected'" ;} ?>>10</option>
                </select>
                <br/>
                Motif : 
                <select name="motif" size=1>
                    <option value="A" <?php if ($motifVisite=="A") {echo "selected='selected'" ;} ?>>A</option>
                    <option value="B" <?php if ($motifVisite=="B") {echo "selected='selected'" ;} ?>>B</option>
                    <option value="C" <?php if ($motifVisite=="C") {echo "selected='selected'" ;} ?>>C</option>
                    <option value="D" <?php if ($motifVisite=="D") {echo "selected='selected'" ;} ?>>D</option>
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
                        $check = "";
                        if ($medicament1 == $ligne[0]) {
                            $check = "selected='selected'";
                        }
                        if ($medicament2 == $ligne[0]) {
                            $check = "selected='selected'";
                        }

                        echo "<option value='".$ligne[0]."'".$check.">".$ligne[1]."</option>";
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
                            $check = "";
                            if ($echantillon1 == $ligne[0]) {
                                $check = "selected='selected'";
                            }
                            if ($echantillon2 == $ligne[0]) {
                                $check = "selected='selected'";
                            }
                            echo "<option value='".$ligne[0]."'".$check.">".$ligne[1]."</option>";
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