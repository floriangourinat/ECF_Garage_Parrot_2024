<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté ou n'a pas le bon rôle 
    exit;
}

$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $job = htmlspecialchars(trim($_POST['job']));
    $role = 'employee'; // Le rôle est défini sur 'employee' par défaut

    // Vérifie si les champs sont remplis
    if (empty($username) || empty($email) || empty($password) || empty($lastname) || empty($firstname) || empty($job)) {
        $error_message = 'Tous les champs sont requis.';
    } else {
        // Hache le mot de passe avant de le stocker dans la base de données
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prépare la requête d'insertion dans la base de données
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, lastname, firstname, job) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Exécute la requête
        try {
            $stmt->execute([$username, $email, $hashedPassword, $role, $lastname, $firstname, $job]);
            $success_message = 'Utilisateur créé avec succès.';
            header('Location: manage_users.php?success='.urlencode($success_message));
            exit;
        } catch (PDOException $e) {
            // Capture et affiche l'erreur
            $error_message = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            header('Location: manage_users.php?error='.urlencode($error_message));
            exit;
        }
    }
}
?>
