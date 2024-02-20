<?php
session_start();
require_once 'includes/db.php';

$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Valide les entrées
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($message)) {
        $error_message = 'Veuillez remplir tous les champs.';
    } else {
        // Commence une transaction
        $conn->beginTransaction();
        try {
            // Insère les informations du visiteur dans la table visitors
            $stmt = $conn->prepare("INSERT INTO visitors (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email]);
            $visitor_id = $conn->lastInsertId(); // Récupére l'ID du visiteur inséré

            // Insère le message dans la table contacts
            $stmt = $conn->prepare("INSERT INTO contacts (visitor_id, firstname, lastname, email, phone, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$visitor_id, $firstname, $lastname, $email, $phone, $message]);

            // Valide la transaction
            $conn->commit();

            $success_message = 'Votre message a été envoyé avec succès. Nous vous répondrons dès que possible.';
        } catch (Exception $e) {
            // En cas d'erreur, annule la transaction
            $conn->rollback();

            // Affiche le message d'erreur
            $error_message = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}

require_once 'includes/header.php'
?>


<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/contact.css">

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
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-center mb-4">Contactez-nous</h2>
                    <p class="text-center">Si vous avez des questions concernant nos services ou si vous êtes intéressé par un de nos véhicules, n'hésitez pas à nous contacter. (Si vous souhaitez directement nous contacter par téléphone : <a href="tel:+33306715807">+33306715807</a>)</p>
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <?php if ($success_message): ?>
                        <div class="alert alert-success"><?php echo $success_message; ?></div>
                    <?php endif; ?>

                    <form action="contact.php" method="post">
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
                            <label for="phone" class="form-label">Votre numéro de téléphone :</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Votre message :</label>
                            <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Colonne pour l'image, maintenant à droite -->
            <div class="col-md-6 text-center scroll-right">
                <img src="img/team.jpg" alt="Image de garagistes" class="img-fluid rounded mb-4">
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
