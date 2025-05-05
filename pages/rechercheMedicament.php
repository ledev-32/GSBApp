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
    <title>GSB - Recherche de médicaments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>GSB - Recherche de médicament</h1>
        <div class="menu">
            <a href="consultationRapport.php">Consultations des rapports</a>
            <a href="saisieRapport.php">Saisie des rapports de visite</a>
            <a href="#">Recherche de médicaments</a>
            <a href="../index.php">Accueil</a>
            <a href="deconnexion.php">Déconnexion</a>
        </div>
        <p>Vous pouvez rechercher un médicament et regarder en détail ce qu'il est </p>
    </header>
    <main>
        <section id="rechercheMedicament">
            <form action="rechercheMedicament.php" method="post" name="rechercheMedicament">
                Dépôt légal du médicament : 
                <?php 
                    // ---Récupération du PDO de connexion (permettant la connexion à la base de donnée)
                    require("../includes/connexionBase.php");

                    // ---Expression et envoi de la requête complète récupérant le dépot légal et le nom commercial de tout les médicaments
                    $rSQL = "SELECT medDepotlegal,medNomcommercial FROM medicament";
                    $resultSQL = $connexion->query($rSQL) or die("Votre requête n'est pas passée");

                    // ---Réception et stockage dans un tableau du résultat de la requête
                    $ligne = $resultSQL->fetch();

                    // ---Affichage de la liste des médicaments présentés
                    echo "<select name='medicament' size='5'>";
                    while ($ligne!=false) {
                        // ---Création de l'option pour la liste des médicaments
                        echo "<option value='".$ligne[0]."'>".$ligne[1]."</option>";

                        // ---Passage à la ligne suivante
                        $ligne = $resultSQL->fetch();
                    }
                    echo "</select>";
                ?>
                <br/><br/>
                <input type="submit" value="Rechercher">
            </form>
        </section>
    </main>
</body>
</html>

<?php 
    if (isset($_POST["medicament"])) {
        $medicamentChoisi = $_POST["medicament"];
        echo "Le dépot légal du médicament choisi est : ".$medicamentChoisi;
    
              
    // ---Expression et envoi de la requête complète récupérant toutes les informations d'un rapport donnée (par son Id)
    $rSQL = "SELECT * FROM medicament WHERE medDepotLegal = '".$medicamentChoisi."'";
    $resultSQL = $connexion->query($rSQL) or die($rSQL.print_r($connexion->errorInfo(), true));

    // ---Réception et stockage dans un tableau du résultat de la requête
    $ligne = $resultSQL->fetch();

    // ---Création d'un tableau pour l'affichage
    echo "<table border='1'>";
    echo "<tr><th>Dépôt légal</th><th>Nom commercial</th><th>Code famille</th><th>Composition</th><th>Effets</th><th>Contre indication</th><th>Prix échantillon</th></tr>";

    // ---Boucle pour parcourir le tableau des valeurs résultats de la requête
    while($ligne!=false) {
        // ---Récupération des résultats de la requête dans des variables (pour plus de simplicité)
        $nomCommercial=$ligne[1];           // ---Nom commercial
        $codeFam=$ligne[2];                 // ---Code Famille
        $composition=$ligne[3];             // ---Composition
        $effets=$ligne[4];                  // ---Effets
        $contreIndic=$ligne[5];             // ---Contre Indications
        $prixEchantillon=$ligne[6];         // ---Prix de l'échantillon



        // ---Affichage des variables dans une ligne du tableau
        echo "<tr>";
        echo "<td>".$medicamentChoisi."</td>";
        echo "<td>".$nomCommercial."</td>";
        echo "<td>".$codeFam."</td>";
        echo "<td>".$composition."</td>";
        echo "<td>".$effets."</td>";
        echo "<td>".$contreIndic."</td>";
        echo "<td>".$prixEchantillon."</td>";
        echo "</tr>";

        // ---Passage à la ligne suivante
        $ligne=$resultSQL->fetch();
    }
    // ---Fermeture du tableau
    echo "</table>";
    }
?>