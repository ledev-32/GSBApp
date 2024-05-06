<?php 
    session_save_path("../../../sessions");
    session_start();
?>

<?php 
    //On vérifie si l'utilisateur est authorisé à y rentrer
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../../index.php");
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
        <h1>MaKo</h1>
        <div class="menu">
            <a href="../consultationRapport.php">Consultations des rapports</a>
            <a href="../saisieRapport.php">Saisie des rapports</a>
            <a href="../modificationRapport.php">Modification des rapports</a>
            <a href="#">Déconnexion</a>
        </div>
    </header>
    <main>
        <section class="rapport">
            <h2>Rapport</h2>
            <p>Ceci est un exemple de rapport.</p>
        </section>
    </main>
</body>
</html>