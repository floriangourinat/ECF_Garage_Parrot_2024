<?php
session_start();
require_once '../includes/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Récupère et filtre les données du formulaire
    $email = trim($_POST['email']); // Utilise trim pour enlever les espaces blancs au début et à la fin
    $password = trim($_POST['password']);

    // Recherche l'utilisateur dans la base de données par email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérifie le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Crée une session pour l'utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirige vers une page d'accueil ou tableau de bord selon le rôle
        header('Location: ../admin.php');
        exit;
    } else {
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Connexion - Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/login.css">

</head>
<body>

    <div class="login-container">
        <h2>Connexion</h2>
        <h3>Connectez-vous à votre espace administrateur du garage Vincent Parrot :</h3>
        <?php if ($error_message != ''): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login">Se connecter</button>
        </form>
    </div>

</body>
</html>
