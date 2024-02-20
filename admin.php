<?php
session_start();
require_once 'includes/db.php';


// Vérifie si l'utilisateur est connecté 
if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php'); // Redirige vers la page de connexion
    exit;
}

// Détermine le rôle de l'utilisateur pour adapter l'affichage
$role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Tableau de Bord - <?php echo $role === 'admin' ? 'Administrateur' : 'Employé'; ?></title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/admin.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">

</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Tableau de Bord - <?php echo $role === 'admin' ? 'Administrateur' : 'Employé'; ?></h1>
            <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="user/logout.php" class="logout-button">Déconnexion</a> <!-- Assurez-vous que le chemin est correct -->
        </header>
        
        <aside class="admin-sidebar">
            <nav class="admin-menu">
                <ul>
                    <li><a href="index.php">Revenir à la page d'accueil</a></li>
                    <?php if ($role === 'admin'): ?>
                        <li><a href="admin/manage_users.php">Gérer les utilisateurs</a></li>
                    <?php endif; ?>
                    <li><a href="admin/manage_cars.php">Gérer les véhicules</a></li>
                    <li><a href="admin/manage_comments.php">Gérer les commentaires</a></li>
                    <li><a href="admin/manage_contact_forms.php">Gérer les formulaires de contact</a></li>
                    <?php if ($role === 'admin'): ?>
                        <li><a href="admin/manage_services.php">Gérer les services proposés</a></li>
                        <li><a href="admin/manage_hours.php">Gérer les horaires</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <!-- Contenu spécifique à chaque page de gestion peut être chargé ici -->
            <?php if ($role === 'admin'): ?>
                <p>Bienvenue dans votre espace administrateur. Vous avez la possibilité de gérer les utilisateurs, les véhicules, les services proposés, les commentaires et les formulaires de contact. Utilisez les liens du menu pour naviguer et gérer votre site.</p>
                <p>Pour modifier les utilisateurs, <a href="admin/manage_users.php">cliquez ici</a>.</p>
                <p>Pour modifier les véhicules, <a href="admin/manage_cars.php">cliquez ici</a>.</p>
                <p>Pour modifier les commentaires, <a href="admin/manage_comments.php">cliquez ici</a>.</p>
                <p>Pour modifier les formulaires de contact, <a href="admin/manage_contact_forms.php">cliquez ici</a>.</p>
                <p>Pour modifier les services proposés, <a href="admin/manage_services.php">cliquez ici</a>.</p>
                <p>Pour modifier les horaires, <a href="admin/manage_hours.php">cliquez ici</a>.</p>
            <?php elseif ($role === 'employee'): ?>
                <p>Bienvenue dans votre espace employé. Vous avez accès à la gestion des véhicules, des commentaires et des formulaires de contact. Vos autorisations sont limitées à ces domaines spécifiques. Utilisez les liens du menu pour effectuer vos tâches.</p>
                <p>Pour modifier les véhicules, <a href="admin/manage_cars.php">cliquez ici</a>.</p>
                <p>Pour modifier les commentaires, <a href="admin/manage_comments.php">cliquez ici</a>.</p>
                <p>Pour modifier les formulaires de contact, <a href="admin/manage_contact_forms.php">cliquez ici</a>.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
