<?php
include 'includes/db.php';

// Récupère les services depuis la base de données
$stmt = $conn->query("SELECT * FROM services");
$services = $stmt->fetchAll();

include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/services.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">

</head>
<body>

<main>
    <!-- Section pour afficher les services -->
    <section class="services-section py-5 scroll-top">
        <div class="container">
            <h2 class="text-center mb-4">Nos Services</h2>
            <div class="row">
                <?php foreach ($services as $service): ?>
                    <!-- Boucle à travers les services pour les afficher -->
                    <div class="col-md-4 text-center mb-3">
                        <?php 
                        // Chemin relatif vers l'image du service
                        $imgPath = 'uploads/' . basename($service['img_service'] ?? '');
                        // Vérifier si le chemin de l'image est non vide et si le fichier existe
                        if (!empty($service['img_service']) && file_exists($imgPath)): ?>
                            <!-- Affiche l'image du service -->
                            <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="Service Image" class="img-fluid">
                        <?php endif; ?>
                        <!-- Affiche le titre et la description du service -->
                        <h4><?php echo isset($service['title']) ? htmlspecialchars($service['title']) : ''; ?></h4>
                        <p><?php echo isset($service['description']) ? htmlspecialchars($service['description']) : ''; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Section de présentation des services -->
    <section class="services-presentation py-5 scroll-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="list-unstyled">
                        <!-- Liste des points forts de l'entreprise -->
                        <li>
                            <h3>Communication Transparente</h3>
                            <p>Nous croyons en une communication ouverte et transparente avec nos clients à chaque étape du processus de réparation ou d'achat de véhicule.</p>
                        </li>
                        <li>
                            <h3>Service Client Exceptionnel</h3>
                            <p>Notre équipe dévouée est là pour répondre à toutes vos questions et préoccupations, et pour vous fournir un service client de haute qualité à chaque visite.</p>
                        </li>
                        <li>
                            <h3>Expertise Technique</h3>
                            <p>Nos techniciens qualifiés et expérimentés sont formés pour offrir les meilleurs services de réparation, d'entretien et de personnalisation pour votre véhicule.</p>
                        </li>
                        <li>
                            <h3>Fiabilité et Transparence</h3>
                            <p>Nous nous engageons à offrir des services fiables et transparents, avec des devis clairs et des délais de livraison respectés.</p>
                        </li>
                        <li>
                            <h3>Engagement envers la Qualité</h3>
                            <p>Nous sommes dédiés à la qualité de notre travail et nous nous efforçons continuellement d'améliorer nos services pour répondre aux besoins changeants de nos clients.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
require_once 'includes/footer.php'; 
?>

    <!-- Bouton Back to Top utilisant les classes Bootstrap -->
    <button type="button" class="btn btn-primary back-to-top" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Inclusion de Bootstrap Bundle JS, ScrollReveal et des scripts js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/back_to_top.js"></script>
    <script src="js/scrollreveal-init.js"></script>

</body>
</html>
