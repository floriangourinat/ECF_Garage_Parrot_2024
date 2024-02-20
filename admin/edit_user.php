<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}

$error_message = '';
$success_message = '';
$user = null;

// Récupère l'utilisateur à modifier
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error_message = "L'utilisateur demandé n'existe pas.";
    }
}

// Mets à jour l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email'])); // Ajoutez cette ligne
    $password = htmlspecialchars(trim($_POST['password']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $job = htmlspecialchars(trim($_POST['job']));

    if (empty($username) || empty($email) || empty($lastname) || empty($firstname) || empty($job)) { // Assurez-vous d'inclure l'email dans cette vérification
        $error_message = 'Tous les champs sont requis.';
    } else {
        try {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, lastname = ?, firstname = ?, job = ? WHERE id = ?");
                $stmt->execute([$username, $email, $hashedPassword, $lastname, $firstname, $job, $id]);
            } else {
                // Ne mets pas à jour le mot de passe si le champ est laissé vide
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, lastname = ?, firstname = ?, job = ? WHERE id = ?");
                $stmt->execute([$username, $email, $lastname, $firstname, $job, $id]);
            }

            $success_message = 'Utilisateur mis à jour avec succès.';
            header('Location: manage_users.php?success='.urlencode($success_message));
            exit;
        } catch (PDOException $e) {
            $error_message = "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
        }
    }
}

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Modifier l'Utilisateur</title>

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

    <div class="admin-user-management">
        <h2>Modifier l'Utilisateur</h2>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($user): ?>
            <form action="edit_user.php" method="post">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

                <label for="email">Email :</label> <!-- Ajout du champ email -->
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

                <label for="password">Mot de passe (laisser vide pour ne pas changer) :</label>
                <input type="password" name="password" id="password"><br>

                <label for="lastname">Nom :</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required><br>

                <label for="firstname">Prénom :</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required><br>

                <label for="job">Poste :</label>
                <input type="text" name="job" id="job" value="<?php echo htmlspecialchars($user['job']); ?>" required><br>

                <button type="submit">Mettre à jour</button>
            </form>
        <?php else: ?>
            <?php echo $error_message; ?>
        <?php endif; ?>
    </div>

</body>
</html>
