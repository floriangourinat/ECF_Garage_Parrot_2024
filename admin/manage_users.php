<?php
session_start();
require_once '../includes/db.php';

// Vérification de l'authentification et des autorisations
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}

$error_message = '';
$success_message = '';

// Traitement du formulaire d'ajout d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et validation des données
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $job = htmlspecialchars(trim($_POST['job']));
    $role = 'employee';

    // Vérification des champs requis
    if (empty($username) || empty($email) || empty($password) || empty($lastname) || empty($firstname) || empty($job)) {
        $error_message = 'Tous les champs sont requis.';
    } else {
        // Vérification si le nom d'utilisateur ou l'email existe déjà
        $stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE username = ? OR email = ?");
        $stmt_check->execute([$username, $email]);
        $row_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($row_check['count'] > 0) {
            $error_message = 'Le nom d\'utilisateur ou l\'email existe déjà.';
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                // Insertion de l'utilisateur dans la base de données
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, lastname, firstname, job) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $email, $hashedPassword, $role, $lastname, $firstname, $job]);
                $success_message = 'Utilisateur ajouté avec succès.';
            } catch (PDOException $e) {
                // Gestion des erreurs de base de données
                $error_message = "Une erreur s'est produite lors de l'ajout de l'utilisateur.";
            }
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
    <title>Gestion des Utilisateurs - Administration</title>

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

    <main>
        <section class="admin-user-management">
            <h2>Gestion des Utilisateurs</h2>

            <!-- Affichage des messages d'erreur ou de succès -->
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <!-- Formulaire d'ajout d'utilisateur -->
            <h3>Ajouter un Utilisateur</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Prénom :</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Nom :</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur :</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="job" class="form-label">Poste :</label>
                    <input type="text" name="job" id="job" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter Utilisateur</button>
            </form>

            <!-- Liste des utilisateurs existants -->
            <h3>Liste des Utilisateurs</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Poste</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Récupération et affichage des utilisateurs depuis la base de données
                    $stmt = $conn->query("SELECT * FROM users");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['firstname']."</td>";
                        echo "<td>".$row['lastname']."</td>";
                        echo "<td>".$row['job']."</td>";
                        echo "<td>".$row['role']."</td>";
                        // Condition pour ne pas afficher le lien de suppression pour l'admin
                        if ($row['role'] === 'admin') {
                            echo "<td><a href='edit_user.php?id=".$row['id']."' class='btn btn-primary'>Modifier</a></td>";
                        } else {
                            echo "<td><a href='edit_user.php?id=".$row['id']."' class='btn btn-primary'>Modifier</a> | <a href='delete_user.php?id=".$row['id']."' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\")'>Supprimer</a></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>    
            </table>
        </section>
    </main>

</body>
</html>
