<?php // ---Démarrage de la session dans le dossier convenué 
    session_save_path("../../sessions"); //!!!!!! A REDEFINIR
    session_start();
?>

<?php // ---Vérification d'authentification (par rapport au statut [visiteur,délégué,responsable])
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../index.php");
    }
?>

<?php // ---Script de récupération de l'id du rapport
    // ---Récupération du PDO de connexion (permettant la connexion à la base de donnée)
    require("connexionBase.php");

    // ---Expression et envoi de la requête complète récupérant le dernier id de rapport saisi
    $rSQL = "SELECT MAX(id) FROM rapportvisite";
    $resultSQL = $connexion->query($rSQL) or die("Votre requête ne passe pas");
    
    // ---Réception et stockage dans un tableau du résultat de la requête
    $ligne = $resultSQL->fetch();

    // ---Stockage de l'Id du dernier rapport saisi de la base de donnée, dans la session
    $_SESSION["idRapport"] = $ligne[0];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB - Saisie Rapport</title>
    <!--<link rel="stylesheet" href="style.css">-->
</head>
<body>
    <header>
        <h1>GSB - Saisie de rapport des visites 
        </h1>
        <div class="menu">
            <a href="#">Consultations des rapports</a>
            <a href="../saisieRapport.html">Saisie des rapports de visites</a>
            <a href="#">Déconnexion</a>
            <a href="../index.php">Accueil</a>
        </div>
    </header>
    <main>
        <section class="rapport">
            <h2>Saisie du Rapport</h2>
            
            <form action="envoiRapport.php" method="post" name="saisieRapport">
                <?php 
                    // ---Stockage et affichage du numéro de rapport +1
                    $numRapport = $_SESSION["idRapport"] + 1;
                    echo "<h1>Vous êtes au rapport numéro ".$numRapport."</h1>";
                ?>
                <br/>
                Date du rapport : <input type="date" name="date" id="date" size="20"> <br/>
                Praticien : 
                <?php
                    // ---Expression et envoi de la requête complète récupérant le numéro, nom, prénom de tout praticien
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
                <textarea id="bilan" name="bilan" rows="5" cols="33">Bilan de la séance
                </textarea>
                <br/>
                Coefficient de Confiance : 
                <?php 
                    // ---Affichage de la liste pour le coefficient de confiance
                    echo "<select name='coeffConfiance' size='1'>";

                    // ---Boucle créant les options de la liste allant de 0 à 10
                    for($i=0;$i<=10;$i++) {
                        echo "<option value='".$i."'>".$i."</option>";
                    }
                    echo "</select>";
                ?>
                <br/>
                Motif : 
                <select name="motif" size=1>
                    <option value="Périodicité">Périodicité</option>
                    <option value="Les nouveautés ou actualisation">Les nouveautés ou actualisation</option>
                    <option value="Remontage">Remontage</option>
                    <option value="Sollicitation">Sollicitation</option>
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
                        // ---Création de l'option pour la liste des médicaments
                        echo "<option value='".$ligne[0]."'>".$ligne[1]."</option>";

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
                            // ---Création de l'option pour la liste des échantillons
                            echo "<option value='".$ligne[0]."'>".$ligne[1]."</option>";

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