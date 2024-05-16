<?php 
    require("../includes/verifSecure.php"); 
?>

<?php 
    // ---On vérifie si le rapport envoyé en paramètre appartient bien à l'utilisateur

    // ---Récupération du rapport envoyé en url
    $idRapportSaisi = $_GET["idrapport"];
    $_SESSION["idRapportAModifier"] = $idRapportSaisi;

    // ---Récupération du PDO de connexion (permettant la connexion à la base de donnée)
    require("../includes/connexionBase.php");

    // ---Récupération des valeurs du rapport à modifier ::::
    $rSQL = "SELECT collMatricule,praticien.praNom,praticien.praPrenom,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1,echantillonPres2 FROM praticien,rapportvisite WHERE praticien.praNum = rapportvisite.praNum AND rapportvisite.id = ".$idRapportSaisi;
    $resultSQL = $connexion->query($rSQL) or die ($rSQL.print_r($connexion->errorInfo(), true));
    $ligne = $resultSQL->fetch();


    // ---Stockage des valeurs dans les variables de réutilisation
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
    <title>GSB - Modification Rapport</title>
    <!--<link rel="stylesheet" href="style.css">-->
</head>
<body>
    <header>
        <h1>GSB - Modification de rapport des visites
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
            
            <form action="envoiModification.php" method="post" name="saisieRapport">
                <?php 
                    // ---Stockage et affichage du numéro de rapport à modifier
                    $numRapport = $idRapportSaisi;
                    echo "<h1>Vous modifiez le rapport numéro ".$numRapport."</h1>";
                ?>
                <br/>
                Date du rapport : <input type="date" name="date" id="date" size="20" value="<?php echo $dateRapport;?>"> <br/>
                Praticien : 
                <?php 
                    // ---Expression et envoi de la requête complète récupéran le numéro, nom, prénom de tout praticien
                    $rSQL = "SELECT praNum,praNom,praPrenom FROM praticien";
                    $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");

                    // ---Réception et stockage dans un tableau du résultat de la requête
                    $ligne = $resultSQL->fetch();

                    // ---Affichage de la liste pour les praticiens
                    echo "<select name='praticien' size='1'>";
                    while ($ligne!=false) {
                        // ---Création de l'option pour la liste des praticiens
                        echo "<option value='".$ligne[0]."'>".$ligne[1]." ".$ligne[2]."</option>";

                        // ---Passage à la ligne suivante
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
                <?php 
                    // ---Affichage de la liste pour le coefficient de confiance
                    echo "<select name='coeffConfiance' size='1'>";

                    // ---Boucle créant les options de la liste allant de 0 à 10
                    for($i=0;$i<=10;$i++) {
                        if ($coeffConf==$i) {
                            $check = "selected='selected'";
                        }
                        echo "<option value='".$i."'".$check.">".$i."</option>";
                    }
                    echo "</select>";
                ?>
                <br/>
                Motif : 
                <select name="motif" size=1>
                    <option value="Périodicité" <?php if ($motifVisite=="Périodicité") {echo "selected='selected'" ;} ?>>Périodicité</option>
                    <option value="Les nouvelles ou actualisation" <?php if ($motifVisite=="Les nouvelles ou actualisation") {echo "selected='selected'" ;} ?>>Les nouvelles ou actualisation</option>
                    <option value="Remontage" <?php if ($motifVisite=="Remontage") {echo "selected='selected'" ;} ?>>Remontage</option>
                    <option value="Sollicitation" <?php if ($motifVisite=="Sollicitation") {echo "selected='selected'" ;} ?>>Sollicitation</option>
                </select>
                <br/>
                Médicaments Présentés (obligatoirement 2) :
                <br/> 
                <?php 
                    // ---Expression et envoi de la requête complète récupérant le dépot légal et le nom commercial de tout les médicaments
                    $rSQL = "SELECT medDepotlegal,medNomcommercial FROM medicament";
                    $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");
                    
                    // ---Réception et stockage dans un tableau du résultat de la requête
                    $ligne = $resultSQL->fetch();

                    // ---Affichage de la liste des médicaments présentés
                    echo "<select name='medicaments[]' size='4' multiple>";
                    while ($ligne!=false) {
                        $check = ""; // ---Variable pour stocker le selected en cas (initialisé en chaine vide)
                        if ($medicament1 == $ligne[0]) {        // ---Si médicament 1 est dans l'ancien rapport
                            $check = "selected='selected'";     // ---Alors check prend la chaine selected='selected'
                        }
                        if ($medicament2 == $ligne[0]) {        // ---Si médicament 2 est dans l'ancien rapport
                            $check = "selected='selected'";     // ---Alors check prend la chaine selected='selected'
                        }

                        // ---Création de l'option pour la liste des médicaments
                        echo "<option value='".$ligne[0]."'".$check.">".$ligne[1]."</option>";

                        // ---Passage à la ligne suivante
                        $ligne = $resultSQL->fetch();
                    }
                    echo "</select>";
                ?>
                <br/>
                <div id="caseEchant"> 
                    Echantillons (maximum 2) : 
                    <br/>
                    <?php
                        // ---Expression et envoi de la requête complète récupérant le dépot légal et le nom commercial de tout les médicaments
                        $rSQL = "SELECT medDepotlegal,medNomcommercial FROM medicament";
                        $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");
                        
                        // ---Réception et stockage dans un tableau du résultat de la requête
                        $ligne = $resultSQL->fetch();

                        // ---Affichage de la liste des échantillons donnés
                        echo "<select name='echantillons[]' size='4' multiple>";
                        while ($ligne!=false) {
                            $check = ""; // ---Variable pour stocker le selected en cas (initialisé en chaine vide)
                            if ($echantillon1 == $ligne[0]) {        // ---Si médicament 1 est dans l'ancien rapport
                                $check = "selected='selected'";     // ---Alors check prend la chaine selected='selected'
                            }
                            if ($echantillon2 == $ligne[0]) {        // ---Si médicament 2 est dans l'ancien rapport
                                $check = "selected='selected'";     // ---Alors check prend la chaine selected='selected'
                            }

                            // ---Création de l'option pour la liste des médicaments
                            echo "<option value='".$ligne[0]."'".$check.">".$ligne[1]."</option>";
                            
                            // ---Passage à la ligne suivante
                            $ligne = $resultSQL->fetch();
                        }
                        echo "</select>";
                ?>
                </div>                
                <br/>
                <input type="reset" value="Annuler">
                <input type="submit" value="Envoyer">
            </form>
        </section>
    </main>
</body>
</html>