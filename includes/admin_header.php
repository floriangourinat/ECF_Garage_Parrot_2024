<?php
// S'assurer que la session est démarrée sur toutes les pages qui incluront ce header.
if (!isset($_SESSION)) {
    session_start();
}

// Vérification de l'authentification et des autorisations
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Chemin relatif vers la racine du site depuis le dossier 'admin'
$rootPath = '../';
$username = htmlspecialchars($_SESSION['username']);
$pageTitle = $_SESSION['role'] === 'admin' ? 'Administrateur' : 'Employé';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/global.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/admin.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <header class="admin-header">
        <div class="admin-header-content">
            <h1><?php echo $pageTitle; ?></h1>
            <p>Bienvenue, <?php echo $username; ?>!</p>
        </div>
        <nav class="admin-header-nav">
            <ul>
                <li><a href="<?php echo $rootPath; ?>index.php">Page d'Accueil du site</a></li>
                <li><a href="<?php echo $rootPath; ?>admin.php">Tableau de Bord</a></li>
                <li><a href="<?php echo $rootPath; ?>admin/manage_cars.php">Véhicules</a></li>
                <li><a href="<?php echo $rootPath; ?>admin/manage_comments.php">Commentaires</a></li>
                <li><a href="<?php echo $rootPath; ?>admin/manage_contact_forms.php">Formulaires de contact</a></li>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_services.php">Services</a></li>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_users.php">Utilisateurs</a></li>
                    <li><a href="<?php echo $rootPath; ?>admin/manage_hours.php">Horaires</a></li>
                <?php endif; ?>
                <li><a href="<?php echo $rootPath; ?>user/logout.php" class="logout-button">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
</body>