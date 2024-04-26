<?php 
    session_save_path("../../sessions")
    session_start();
?>

<?php
    // ---Déclaration des variables qui récupèrent les données du formulaire de saisie des rapports
    $idRapport = $_SESSION["idRapport"] + 1;
    echo "Le rapport dernier était le".$_SESSION["idRapport"]." ème rapport et vous avez saisi le".$idRapport." èmme rapport";
    $collMatricule = "SOSOREN";
    $dateRapport = $_POST["date"];
    $numPraticien = intval($_POST["praticien"]);
    echo $numPraticien;
    $bilanVisite = $_POST["bilan"];
    $coeff = $_POST["coeffConfiance"];
    $motifVisite = $_POST["motif"];

    $medicaments = array_values($_POST["medicaments"]);
    $medicament1 = $medicaments[0];
    $medicament2 = $medicaments[1];



    require("connexionBase.php");

    // ----------------- TEST -----------------
    //require("connexionBase.php");
    //$rSQL = "INSERT INTO rapportvisit(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf) VALUES(32,'TEST45',1,'2024-03-08','Visite correcte rien à dire (test)','systématique','8')";
    //$envoiSQL = $connexion->exec($rSQL) or die($rSQL.print_r($connexion->errorInfo(), true));
    //-----------------------------------------

    if (!isset($_POST["echantillons"])) {

        echo "<br/>LES ECHANTILLONS NE SONT PAS RENSEIGNES";
        echo "<br/>".$medicament1;
        echo "<br/>".$medicament2;
        $rSQL = "INSERT INTO rapportvisite(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2)VALUES($idRapport,\"$collMatricule\",$numPraticien,\"$dateRapport\",\"$bilanVisite\",\"$motifVisite\",\"$coeff\",\"$medicament1\",\"$medicament2\")";
    }
    else {
        $echantillons = array_values($_POST["echantillons"]);
        $tailleEchantillons = count($echantillons);
        switch ($tailleEchantillons) {
            case 1:
                $echantillon1 = $echantillons[0];
                $rSQL = "INSERT INTO rapportvisite(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1)VALUES($idRapport,\"$collMatricule\",$numPraticien,\"$dateRapport\",\"$bilanVisite\",\"$motifVisite\",\"$coeff\",\"$medicament1\",\"$medicament2\",\"$echantillon1\")";
                break;
            case 2:
                $echantillon1 = $echantillons[0];
                $echantillon2 = $echantillons[1];
                $rSQL = "INSERT INTO rapportvisite(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1,echantillonPres2)VALUES($idRapport,\"$collMatricule\",$numPraticien,\"$dateRapport\",\"$bilanVisite\",\"$motifVisite\",\"$coeff\",\"$medicament1\",\"$medicament2\",\"$echantillon1\",\"$echantillon2\")";
                break;
    }
    }

    

    // ---Expression de la requête permettant d' envoyer les informations à la base de données
    
    echo "<br/>";
    $resultSQL = $connexion->exec($rSQL) or die($rSQL.print_r($connexion->errorInfo(), true));
    echo "<br/>La requête donne : ".var_dump($resultSQL)."<br/>";
    
    
    echo "Votre rapport à bien été saisie, merci de votre confiance en notre logiciel";
?>