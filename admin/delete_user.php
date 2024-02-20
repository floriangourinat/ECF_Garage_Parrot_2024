<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}

// Vérifie si l'ID de l'utilisateur à supprimer est passé dans l'URL et s'il est numérique
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupère le rôle de l'utilisateur pour éviter la suppression des comptes administrateurs
        $stmt_role = $conn->prepare("SELECT role FROM users WHERE id = ?");
        $stmt_role->execute([$id]);
        $user_role = $stmt_role->fetch(PDO::FETCH_ASSOC);

        if ($user_role && $user_role['role'] === 'admin') {
            // Ne supprime pas les comptes administrateurs
            $_SESSION['error_message'] = "La suppression des comptes administrateurs n'est pas autorisée.";
        } else {
            // Supprime l'utilisateur de la base de données
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success_message'] = 'Utilisateur supprimé avec succès.';
        }
    } catch (PDOException $e) {
        // Gère les erreurs de suppression d'utilisateur
        $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
    }
}

// Redirige vers la page de gestion des utilisateurs après la suppression
header('Location: manage_users.php');
exit;
?>
