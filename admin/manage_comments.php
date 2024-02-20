<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Initialise les variables pour stocker les données du formulaire
$firstname = $lastname = $email = $content = $rating = '';
$errors = [];

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valide les champs du formulaire
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $content = trim($_POST['content']);
    $rating = intval($_POST['rating']);

    // Vérifie la validité de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    // Vérifie que le prénom et le nom ne sont pas vides
    if (empty($firstname) || empty($lastname)) {
        $errors[] = "Veuillez saisir le prénom et le nom.";
    }

    // Vérifie que le contenu n'est pas vide
    if (empty($content)) {
        $errors[] = "Veuillez saisir le contenu du commentaire.";
    }

    // Vérifie que la note est entre 1 et 5
    if ($rating < 1 || $rating > 5) {
        $errors[] = "La note doit être comprise entre 1 et 5.";
    }

    // Si aucune erreur, insère le nouveau commentaire dans la base de données
    if (empty($errors)) {
        try {
            $conn->beginTransaction();

            // Insère le visiteur s'il n'existe pas déjà
            $stmt = $conn->prepare("INSERT INTO visitors (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email]);
            $visitor_id = $conn->lastInsertId();

            // Insère le commentaire
            $stmt = $conn->prepare("INSERT INTO comments (visitor_id, firstname, lastname, content, rating, submitted_at, is_approved) VALUES (?, ?, ?, ?, ?, NOW(), 1)");
            $stmt->execute([$visitor_id, $firstname, $lastname, $content, $rating]);

            $conn->commit();
            $_SESSION['success_message'] = "Commentaire ajouté avec succès.";
            header("Location: manage_comments.php");
            exit;
        } catch (PDOException $e) {
            $conn->rollBack();
            $errors[] = "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
        }
    }
}

// Vérifie si le formulaire a été soumis avec succès
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Efface la variable de session après l'avoir affichée
}

// Récupère tous les commentaires avec les informations visiteur associées
$stmt = $conn->query("SELECT comments.*, visitors.id AS visitor_id, visitors.firstname, visitors.lastname, visitors.email FROM comments JOIN visitors ON comments.visitor_id = visitors.id");
$comments = $stmt->fetchAll();

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Gestion des Commentaires - Administration</title>

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
        <section class="admin-comments-management">
            <h1>Gestion des Commentaires</h1>
            
            <!-- Affiche le message de succès si le formulaire a été soumis avec succès -->
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <div class="add-comment-form">
                <h2>Ajouter un Commentaire</h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="manage_comments.php" method="post">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Commentaire</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required><?php echo htmlspecialchars($content); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Note</label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="1" <?php echo ($rating == 1) ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo ($rating == 2) ? 'selected' : ''; ?>>2</option>
                            <option value="3" <?php echo ($rating == 3) ? 'selected' : ''; ?>>3</option>
                            <option value="4" <?php echo ($rating == 4) ? 'selected' : ''; ?>>4</option>
                            <option value="5" <?php echo ($rating == 5) ? 'selected' : ''; ?>>5</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter Commentaire</button>
                </form>
            </div>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p>ID du Commentaire : <?php echo $comment['id']; ?></p>
                    <p>ID du Visiteur : <?php echo $comment['visitor_id']; ?></p>
                    <p>Prénom du Visiteur : <?php echo htmlspecialchars($comment['firstname']); ?></p>
                    <p>Nom du Visiteur : <?php echo htmlspecialchars($comment['lastname']); ?></p>
                    <p>Email du Visiteur : <?php echo htmlspecialchars($comment['email']); ?></p>
                    <p>Contenu : <?php echo htmlspecialchars($comment['content']); ?></p>
                    <p>Note : <?php echo $comment['rating']; ?>/5</p>
                    <p>Posté le : <?php echo $comment['submitted_at']; ?></p>
                    <p>Status : <?php echo $comment['is_approved'] ? 'Approuvé' : 'En attente'; ?></p>
                    <a href="approve_comment.php?id=<?php echo $comment['id']; ?>">Approuver</a>
                    <a href="delete_comment.php?id=<?= $comment['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</a>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

</body>
</html>
