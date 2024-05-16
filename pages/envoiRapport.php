<?php 
    require("../includes/verifSecure.php")
?>

<?php // ---Vérification d'authentification (par rapport au statut [visiteur,délégué,responsable])
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../index.php"); // Si le statut de session est pas bon alors redirection vers index principal
    }
?>

<?php
    // ---Récupération du PDO de connexion (permettant la connexion à la base de donnée)
    require("../includes/connexionBase.php");

    // ---Déclaration des variables qui récupèrent les données du formulaire saisieRapport.php
    $idRapport = $_SESSION["idRapport"] + 1;            // ---Id du rapport (qui est l'Id du rapport dernièrement enregistré auquel on ajoute 1 (stocké dans la session))
    $collMatricule = $_SESSION["userMatricule"];        // ---Matricule du collaborateur (qui est stocké dans la session)
    $dateRapport = $_POST["date"];                      // ---Date du rapport
    $numPraticien = $_POST["praticien"];                // ---Numéro du praticien
    $bilanVisite = $_POST["bilan"];                     // ---Bilan du rapport
    $motifVisite = $_POST["motif"];                     // ---Motif du rapport
    $coeff = $_POST["coeffConfiance"];                  // ---Coefficient de confiance du praticien
    
    $medicaments = array_values($_POST["medicaments"]); // ---Création variable liste qui contient les 2 médicaments présentés
    $medicament1 = $medicaments[0];                     // ---Médicament 1
    $medicament2 = $medicaments[1];                     // ---Médicament 2


    // ---On vérifie à l'aide de test si les échantillons sont sélectionnés
    // ---Puis on exprime la requête en fonction de la présence ou non des échantillons
    if (!isset($_POST["echantillons"])) {                       // ---Si aucun des échantillon n'est sélectionné :
                                                                // ---Alors requête sans les échantillons
        $rSQL = "INSERT INTO rapportvisite(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2)VALUES($idRapport,\"$collMatricule\",$numPraticien,\"$dateRapport\",\"$bilanVisite\",\"$motifVisite\",\"$coeff\",\"$medicament1\",\"$medicament2\")";
    }
    else {                                                      // ---Sinon
        $echantillons = array_values($_POST["echantillons"]);   // ---Création variable liste qui contient 1 ou 2 échantillon(s)
        $tailleEchantillons = count($echantillons);             // ---Compte la taille de la variable liste
        switch ($tailleEchantillons) {
            case 1:                                                     // ---Si la taille est de 1 :
                $echantillon1 = $echantillons[0];                       // ---Alors requête avec 1 échantillon
                $rSQL = "INSERT INTO rapportvisite(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1)VALUES($idRapport,\"$collMatricule\",$numPraticien,\"$dateRapport\",\"$bilanVisite\",\"$motifVisite\",\"$coeff\",\"$medicament1\",\"$medicament2\",\"$echantillon1\")";
                break;
            case 2:                                                     // ---Si la taille est de 2 : 
                $echantillon1 = $echantillons[0];                       // ---Alors requête avec 2 échantillons
                $echantillon2 = $echantillons[1];
                $rSQL = "INSERT INTO rapportvisite(id,collMatricule,praNum,rapDate,rapBilan,rapMotif,coefConf,medicamentPres1,medicamentPres2,echantillonPres1,echantillonPres2)VALUES($idRapport,\"$collMatricule\",$numPraticien,\"$dateRapport\",\"$bilanVisite\",\"$motifVisite\",\"$coeff\",\"$medicament1\",\"$medicament2\",\"$echantillon1\",\"$echantillon2\")";
                break;
    }
    }
    
    echo "<br/>"; // ---Retour à la ligne
    $resultSQL = $connexion->exec($rSQL) or die($rSQL.print_r($connexion->errorInfo(), true));  // ---Envoi de la requête à la base de donnée
                                                                                                // ---Si la requête ne passe pas alors arrêt du script
    echo "Votre rapport à bien été saisi, merci de votre confiance en notre application";
    echo "<br/><a href='../index.php'>Retour vers l'accueil</a>"; // ---Lien pour le retour vers l'index.php principal
?>

