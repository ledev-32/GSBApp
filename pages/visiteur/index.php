<?php // ---Démarrage de la session dans le dossier convenu
    session_save_path("../../sessions"); //!!!!!! A REDEFINIR
    session_start();
?>

<?php // ---Vérification d'authentification (par rapport au statut [visiteur,délégué,responsable])
    if ($_SESSION["userStatus"] != "visiteur") {
        header("Location:../../index.php"); // Si le statut de session est pas bon alors redirection vers index principal
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB - Visiteur - Accueil</title>
    <!--<link rel="stylesheet" href="style.css">-->
</head>
<body>
    <header>
        <h1>GSB - Accueil</h1>
        <div class="menu">
            <a href="../consultationRapport.php">Consultations des rapports</a>
            <a href="../saisieRapport.php">Saisie des rapports de visite</a>
            <a href="#">Déconnexion</a>
        </div>
    </header>
    <main>
        <section>
            <h1>Bienvenue sur votre application GSB</h1>
            <p>Vous êtes identifiés en tant que <?php echo $_SESSION["userStatus"];?> avec le pseudo <?php echo $_SESSION["userMatricule"];?> </p>
            <p>Vous pouvez saisir dees rapports de visite, mais aussi consulter et modifier uniquement les rapports que vous avez remplis</p>
        </section>
    </main>
</body>
</html>