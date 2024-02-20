<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'admin' ou 'employee' 
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Vérifie si l'ID du commentaire à supprimer est passé dans l'URL et est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_comments.php');
    exit;
}

// Récupère et valide l'ID du commentaire à supprimer
$comment_id = intval($_GET['id']);

// Supprime le commentaire de la base de données
try {
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    header("Location: manage_comments.php");
    exit;
} catch (PDOException $e) {
    // Gère les erreurs de base de données de manière sécurisée sans afficher de détails sensibles
    echo "Une erreur s'est produite lors de la suppression du commentaire.";
    exit;
}
?>
