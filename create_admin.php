<!-- Fichier pour initialiser le compte administrateur dans la base de données nous permettant de se connecter à login.php, à supprimer après création même si la sécurité semble bonne sur ce code --> 

<?php
require_once 'includes/db.php';

// Assignation directe des valeurs
$firstname = 'Vincent';
$lastname = 'Parrot';
$username = 'VincentParrot';
$email = 'vincentparrot@test.fr';
$password = 'admin123';
$job = 'Directeur général et gestionnaire';
$role = 'admin';

// Vérifie d'abord si un compte admin existe déjà
try {
    $checkAdminStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = :role");
    $checkAdminStmt->bindParam(':role', $role);
    $checkAdminStmt->execute();

    if ($checkAdminStmt->fetchColumn() > 0) {
        die("Un compte administrateur existe déjà. La création d'un nouveau compte administrateur est restreinte.");
    }
} catch (PDOException $e) {
    error_log("Erreur lors de la vérification de l'existence d'un compte administrateur : " . $e->getMessage());
    echo "Erreur lors de la vérification de l'existence d'un compte administrateur. Veuillez réessayer.";
    exit;
}

// Hash du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, job, role) VALUES (:firstname, :lastname, :username, :email, :password, :job, :role)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':job', $job);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    echo "Compte administrateur créé avec succès.";
} catch (PDOException $e) {
    error_log("Erreur lors de la création du compte administrateur : " . $e->getMessage());
    echo "Erreur lors de la création du compte administrateur. Veuillez réessayer.";
}
?>
