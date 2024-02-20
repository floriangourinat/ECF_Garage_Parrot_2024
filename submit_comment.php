<?php
session_start();
include 'includes/db.php';

$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $content = trim($_POST['content']);
    $rating = intval($_POST['rating']);

    // Valide les entrées
    if (empty($firstname) || empty($lastname) || empty($email) || empty($content) || $rating < 1 || $rating > 5) {
        $error_message = 'Veuillez remplir tous les champs et fournir une note valide.';
    } else {
        // Insère les informations du visiteur dans la table visitors
        $stmt = $conn->prepare("INSERT INTO visitors (firstname, lastname, email) VALUES (?, ?, ?)");
        $stmt->execute([$firstname, $lastname, $email]);
        $visitor_id = $conn->lastInsertId(); // Récupère l'ID du visiteur inséré

        // Insère le commentaire dans la table comments
        $stmt = $conn->prepare("INSERT INTO comments (visitor_id, firstname, lastname, content, rating, submitted_at, is_approved) VALUES (?, ?, ?, ?, ?, NOW(), FALSE)");
        $stmt->execute([$visitor_id, $firstname, $lastname, $content, $rating]);

        $success_message = 'Votre commentaire a été soumis avec succès, merci pour votre réponse !';
    }
}

include 'includes/header.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Commentaires - Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/submit_comment.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">


</head>
<body>

    <div class="container my-5">
        <div class="row align-items-center scroll-left">
            <!-- Colonne pour le formulaire -->
            <div class="col-md-6">
                <div class="comment-submission-form bg-white p-4 rounded shadow">
                    <h2 class="text-center mb-4">Donnez votre avis sur nos services</h2>
                    <p class="text-center">Votre avis sera traité par nos équipes et sera potentiellement publié sur notre site</p>
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <?php if ($success_message): ?>
                        <div class="alert alert-success"><?php echo $success_message; ?></div>
                    <?php endif; ?>

                    <form action="submit_comment.php" method="post">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Votre prénom :</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Votre nom :</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Votre email :</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Votre commentaire :</label>
                            <textarea class="form-control" name="content" id="content" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre note :</label>
                            <select class="form-select" name="rating" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Soumettre le commentaire</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Colonne pour l'image -->
            <div class="col-md-6 text-center scroll-right">
                <img src="img/contact.jpg" alt="Image de garagistes" class="img-fluid rounded mb-4">
            </div>
        </div>
    </div>

    <?php
    require_once 'includes/footer.php'; 
    ?>

    <!-- Bouton Back to Top utilisant les classes Bootstrap -->
    <button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Inclusion de Bootstrap Bundle JS, Scrollreveal et des scripts js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/back_to_top.js"></script>
    <script src="js/scrollreveal-init.js"></script>
</body>
</html>
