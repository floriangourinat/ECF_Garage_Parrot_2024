<?php
session_start();
require_once 'includes/db.php';

$error_message = '';
$success_message = '';

// Récupère l'ID du véhicule depuis l'URL 
$vehicleId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$vehicle = null;

// Vérifie si un ID de véhicule valide a été fourni
if ($vehicleId > 0) {
    try {
        // Prépare et exécute la requête pour récupérer les détails du véhicule
        $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :id");
        $stmt->bindParam(':id', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, affiche un message d'erreur et arrête l'exécution
        die("Erreur : " . $e->getMessage());
    }
}

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère et nettoie les données du formulaire
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Valide que tous les champs du formulaire sont remplis
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($message)) {
        $error_message = 'Veuillez remplir tous les champs.';
    } else {
        // Récupère la marque et le modèle du véhicule
        $vehicle_brand = $vehicle['brand'];
        $vehicle_model = $vehicle['model'];

        // Ajoute la marque et le modèle du véhicule au message
        $message .= " ($vehicle_brand $vehicle_model ID du véhicule: $vehicleId)";

        // Commence une transaction pour assurer l'intégrité des données
        $conn->beginTransaction();
        try {
            // Insère les informations du visiteur dans la table visitors
            $stmt = $conn->prepare("INSERT INTO visitors (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email]);
            $visitor_id = $conn->lastInsertId(); // Récupérer l'ID du visiteur inséré

            // Insère le message dans la table contacts avec l'ID du visiteur
            $stmt = $conn->prepare("INSERT INTO contacts (visitor_id, firstname, lastname, email, phone, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$visitor_id, $firstname, $lastname, $email, $phone, $message]);

            // Valide la transaction si tout s'est bien passé
            $conn->commit();

            $success_message = 'Votre message a été envoyé avec succès. Nous vous répondrons dès que possible.';
        } catch (PDOException $e) {
            // En cas d'erreur PDO, annule la transaction et affiche un message d'erreur
            $conn->rollback();
            $error_message = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}

require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Détails du Véhicule</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/vehicle_details.css">

    <!-- Lien vers les polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">

</head>
<body>
<main class="vehicle-details-container scroll-left">
    <?php if ($vehicle): ?>
        <h1><?= htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?></h1>
        <img src="uploads/<?php echo $vehicle['photo_url']; ?>" alt="Image de <?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>">
        <div class="details-container">
            <div class="primary-details">
                <p><strong>Marque:</strong> <?= htmlspecialchars($vehicle['brand']); ?></p>
                <p><strong>Modèle:</strong> <?= htmlspecialchars($vehicle['model']); ?></p>
                <p><strong>Année:</strong> <?= htmlspecialchars($vehicle['year']); ?></p>
                <p><strong>Kilométrage:</strong> <?= number_format($vehicle['mileage']); ?> km</p>
                <p><strong>Prix:</strong> <?= number_format($vehicle['price'], 2); ?> €</p>
                <p><strong>État:</strong> <?= htmlspecialchars($vehicle['condition']); ?></p>
            </div>
            <div class="secondary-details">
                <h2>Spécifications complémentaires</h2>
                <table>
                    <tr>
                        <th>Carburant</th>
                        <td><?= htmlspecialchars($vehicle['fuel']); ?></td>
                    </tr>
                    <tr>
                        <th>Type de transmission</th>
                        <td><?= htmlspecialchars($vehicle['transmission']); ?></td>
                    </tr>
                    <tr>
                        <th>Couleur</th>
                        <td><?= htmlspecialchars($vehicle['color']); ?></td>
                    </tr>
                    <tr>
                        <th>Puissance fiscale</th>
                        <td><?= htmlspecialchars($vehicle['power']); ?> CV</td>
                    </tr>
                    <tr>
                        <th>Consommation</th>
                        <td><?= htmlspecialchars($vehicle['consumption']); ?>/100km</td>
                    </tr>
                    <tr>
                        <th>Système de navigation</th>
                        <td><?= $vehicle['navigation'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Sièges chauffants</th>
                        <td><?= $vehicle['heated_seats'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Vidange</th>
                        <td><?= $vehicle['oil_change'] ? 'À faire' : 'À jour' ?></td>
                    </tr>
                    <tr>
                        <th>Contrôle technique</th>
                        <td><?= $vehicle['technical_control'] ? 'À faire' : 'À jour'; ?></td>
                    </tr>
                    <tr>
                        <th>Garantie</th>
                        <td><?= $vehicle['warranty'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre de portes</th>
                        <td><?= htmlspecialchars($vehicle['number_doors']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="additional-text">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-center mb-4">Contactez-nous</h2>
                <p class="text-center">Si vous avez des questions concernant ce véhicule
                    <?php if ($vehicle): ?>
                    <?= htmlspecialchars($vehicle['brand']) . ' ' . htmlspecialchars($vehicle['model']); ?>
                    <?php endif; ?>
                    ou si vous êtes intéressé, n'hésitez pas à nous contacter. (Si vous souhaitez directement nous contacter par téléphone : <a href="tel:+33306715807">+33306715807</a>)
                </p>
                <!-- Affichage des messages d'erreur ou de succès -->
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>

                <!-- Formulaire de contact -->
                <form action="" method="post">
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
        <a href="vehicles.php" class="back-button">Retour aux véhicules</a>
    <?php else: ?>
        <!-- Affichage si le véhicule n'est pas trouvé -->
        <p>Véhicule non trouvé.</p>
    <?php endif; ?>
</main>

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
