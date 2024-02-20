<?php
session_start();
require_once '../includes/db.php'; 

// Vérifie si l'utilisateur est connecté et a le rôle 'admin' ou 'employee' 
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté ou n'a pas le bon rôle 
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_comments.php'); // Redirige vers la page de gestion des commentaires si l'identifiant du commentaire n'est pas spécifié ou n'est pas numérique
    exit;
}

$comment_id = $_GET['id']; // Récupère l'identifiant du commentaire depuis l'URL

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_comment'])) {
    // Prépare et exécute une requête pour mettre à jour le statut du commentaire à approuver
    $stmt = $conn->prepare("UPDATE comments SET is_approved = 1 WHERE id = ?");
    $stmt->execute([$comment_id]);

    header('Location: manage_comments.php'); // Redirige vers la page de gestion des commentaires après avoir approuvé le commentaire
    exit;
}

// Récupère les informations du commentaire ainsi que le prénom et le nom du visiteur
$stmt = $conn->prepare("SELECT comments.*, visitors.firstname, visitors.lastname, visitors.email FROM comments JOIN visitors ON comments.visitor_id = visitors.id WHERE comments.id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

if (!$comment) {
    header('Location: manage_comments.php'); // Redirige vers la page de gestion des commentaires si le commentaire n'existe pas
    exit;
}

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Approuver Commentaire - Administration</title>
    
    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/admin.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <div class="admin-comments-management">
        <h1>Êtes-vous sûr d'approuver ce commentaire ? (Il apparaîtra sur la page d'accueil de votre site internet)</h1>
        
        <div class="comment">
            <p><?php echo htmlspecialchars($comment['content']); ?></p>
            <p>Posté par : <?php echo htmlspecialchars($comment['firstname']) . ' ' . htmlspecialchars($comment['lastname']); ?> (<?php echo htmlspecialchars($comment['email']); ?>)</p>
            <p>Note : <?php echo $comment['rating']; ?>/5</p>
            <p>Posté le : <?php echo $comment['submitted_at']; ?></p>
            <p>Status : <?php echo $comment['is_approved'] ? 'Approuvé' : 'En attente'; ?></p>
        </div>

        <form action="approve_comment.php?id=<?php echo $comment_id; ?>" method="post">
            <button type="submit" name="approve_comment" class="btn btn-primary">Approuver le Commentaire</button>
        </form>
    </div>

</body>
</html>
