<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'admin' ou 'employee' 
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Vérifie si l'ID du véhicule à supprimer est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_cars.php');
    exit;
}

// Récupère et valide l'ID du véhicule à supprimer
$vehicle_id = intval($_GET['id']);

// Supprime le véhicule de la base de données
try {
    $stmt = $conn->prepare("DELETE FROM vehicles WHERE id = ?");
    $stmt->execute([$vehicle_id]);
    header("Location: manage_cars.php");
    exit;
} catch (PDOException $e) {
    // Gère les erreurs de base de données de manière sécurisée sans afficher de détails sensibles
    echo "Une erreur s'est produite lors de la suppression du véhicule.";
    exit;
}
?>
