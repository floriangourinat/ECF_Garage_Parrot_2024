<?php
session_start();
require_once 'includes/db.php';

$error_message = '';
$success_message = '';

// Récupère les données des services depuis la base de données
try {
    $stmt = $conn->query("SELECT * FROM services");
    $services = $stmt->fetchAll();
} catch(PDOException $e) {
    // Enregistre l'erreur dans un fichier journal au lieu de l'afficher directement à l'utilisateur
    error_log("Erreur lors de la récupération des services : " . $e->getMessage());
    $error_message = 'Une erreur s\'est produite. Veuillez réessayer plus tard.';
}

// Récupère les commentaires approuvés depuis la table des commentaires
try {
    $stmt = $conn->prepare("SELECT comments.content, comments.rating, comments.submitted_at, visitors.firstname FROM comments JOIN visitors ON comments.visitor_id = visitors.id WHERE comments.is_approved = 1");
    $stmt->execute();
    $approved_comments = $stmt->fetchAll();
} catch(PDOException $e) {
    // Enregistre l'erreur dans un fichier journal au lieu de l'afficher directement à l'utilisateur
    error_log("Erreur lors de la récupération des commentaires approuvés : " . $e->getMessage());
    $error_message = 'Une erreur s\'est produite. Veuillez réessayer plus tard.';
}

// Récupère les trois derniers véhicules ajoutés depuis la base de données
try {
    $stmt = $conn->prepare("SELECT * FROM vehicles ORDER BY created_at DESC LIMIT 3");
    $stmt->execute();
    $vehicles = $stmt->fetchAll();
} catch(PDOException $e) {
    // Enregistre l'erreur dans un fichier journal au lieu de l'afficher directement à l'utilisateur
    error_log("Erreur lors de la récupération des derniers véhicules : " . $e->getMessage());
    $error_message = 'Une erreur s\'est produite. Veuillez réessayer plus tard.';
}

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $content = htmlspecialchars(trim($_POST['content']));
    $rating = intval($_POST['rating']);

    // Valide les entrées
    if (empty($firstname) || empty($lastname) || empty($email) || empty($content) || $rating < 1 || $rating > 5) {
        $error_message = 'Veuillez remplir tous les champs et fournir une note valide.';
    } else {
        // Insère les informations du visiteur dans la table visitors
        try {
            $stmt = $conn->prepare("INSERT INTO visitors (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email]);
            $visitor_id = $conn->lastInsertId(); // Récupère l'ID du visiteur inséré

            // Insère le commentaire dans la table comments
            $stmt = $conn->prepare("INSERT INTO comments (visitor_id, firstname, lastname, content, rating, submitted_at, is_approved) VALUES (?, ?, ?, ?, ?, NOW(), FALSE)");
            $stmt->execute([$visitor_id, $firstname, $lastname, $content, $rating]);

            $success_message = 'Votre commentaire a été soumis avec succès, merci pour votre réponse !';
        } catch(PDOException $e) {
            // Enregistre l'erreur dans un fichier journal au lieu de l'afficher directement à l'utilisateur
            error_log("Erreur lors de l'insertion du commentaire : " . $e->getMessage());
            $error_message = 'Une erreur s\'est produite lors de la soumission de votre commentaire. Veuillez réessayer.';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
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
    
        <!-- Section de Bienvenue -->
        <section class="welcome-section d-flex justify-content-center align-items-center text-center scroll-top">
            <video playsinline autoplay muted loop class="welcome-video">
                <source src="video/welcome_section.mp4" type="video/mp4">
                Votre navigateur ne supporte pas la balise vidéo.
            </video>
            <div class="welcome-text">
                <h1>Venez découvrir nos véhicules d'occasion haut de gamme ainsi que nos offres de service</h1>
                <p>Depuis 2005, le garage Vincent Parrot vous offre une vaste sélection de véhicules d'occasion certifiés, ainsi que des réparations et entretiens de grande qualité.</p>
                <a href="vehicles.php" class="btn btn-primary btn-lg">Voir nos véhicules</a>
                <a href="services.php" class="btn btn-outline-light btn-lg">Voir nos services</a>
            </div>
        </section>

        <!-- Section Pourquoi Nous Choisir -->
        <section class="why-choose-us py-5 scroll-left">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <h2 class="text-center">Pourquoi Nous Choisir ?</h2>
                </div>
            </div>
            <div class="row align-items-start g-4">
                <div class="col-md-6">
                    <p><strong>Expertise Professionnelle:</strong> Vincent Parrot et son équipe apportent un savoir-faire inégalé à chaque tâche.</p>
                    <p><strong>Service Personnalisé:</strong> Nous comprenons que chaque client a des besoins uniques et nous nous efforçons de répondre à ces besoins avec une attention particulière.</p>
                    <p><strong>Transparence et Confiance:</strong> La clarté dans nos services et la confiance de nos clients sont au cœur de notre éthique.</p>
                    <p><strong>Attention Personnalisée :</strong> Votre expérience automobile est unique, c'est pourquoi nous fournissons des solutions adaptées à vos besoins spécifiques.</p>
                    <p><strong>Innovation Constante:</strong> Nous adoptons les dernières technologies et méthodologies pour garantir que nos services restent à la pointe du secteur.</p>
                    <p><strong>Engagement envers la Qualité:</strong> Chaque projet est exécuté avec le plus haut niveau de qualité, assurant la satisfaction totale du client.</p>
                </div>
                <div class="col-md-6">
                    <img src="img/choose_us.jpg" alt="Image représentative générée en IA" class="img-fluid rounded">
                </div>
            </div>
        </div>
        </section>
        
        <!-- Section des derniers véhicules ajoutés -->
        <section class="vehicles-section mt-5 scroll-right">
            <div class="container">
            <h2 class="text-center mb-4">Nos derniers véhicules</h2>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($vehicles as $vehicle): ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <img src="uploads/<?php echo $vehicle['photo_url']; ?>" alt="Image de <?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>" class="card-img-top vehicle-image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?></h5>
                                            <p class="card-text">Année : <?php echo htmlspecialchars($vehicle['year']); ?></p>
                                            <p class="card-text">Kilométrage : <?php echo htmlspecialchars($vehicle['mileage']); ?></p>
                                            <p class="card-text">Prix : <?php echo htmlspecialchars(number_format($vehicle['price'], 2)); ?> €</p>
                                            <a href="vehicle_details.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-primary">Voir les détails</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center mt-4">
                            <a href="vehicles.php" class="btn btn-secondary">Voir nos autres véhicules</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section des services -->
        <section class="services-section py-5 scroll-top">
            <div class="container">
                <h2 class="text-center mb-4">Nos Services</h2>
                <div class="row">
                    <?php foreach ($services as $service): ?>
                        <div class="col-md-4 text-center mb-3">
                            <?php 
                            // Chemin relatif vers l'image, pour éviter d'avoir des erreurs d'affichage
                            $imgPath = 'uploads/' . basename($service['img_service'] ?? '');
                            // Vérifie si le chemin de l'image est non vide et si le fichier existe
                            if (!empty($service['img_service']) && file_exists($imgPath)): ?>
                                <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="Service Image" class="img-fluid">
                            <?php endif; ?>
                            <h4><?php echo isset($service['title']) ? htmlspecialchars($service['title']) : ''; ?></h4>
                            <p><?php echo isset($service['description']) ? htmlspecialchars($service['description']) : ''; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Section des chiffres déroulants -->
        <section class="number-section text-center py-5 scroll-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-card rounded-pill">
                            <div class="number" id="vehicles-sold">458</div>
                            <h2>de véhicules vendus depuis 2005</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card rounded-pill">
                            <div class="number" id="services-provided">10230</div>
                            <h2>de services offerts depuis 2005</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card rounded-pill text-white">
                            <div class="number" id="satisfied-customers">95%</div>
                            <h2>de clients satisfaits</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <!-- Section carrousel des commentaires approuvés -->
            <section class="approved-comments-carousel mt-5 bg-light scroll-bottom">
                <div class="container">
                    <div id="commentsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($approved_comments as $index => $comment): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="text-center">
                                        <p class="carousel-comment"><?php echo htmlspecialchars($comment['content']); ?></p>
                                        <p class="carousel-author"><?php echo htmlspecialchars($comment['firstname']); ?></p>
                                        <p class="carousel-rating">
                                            <?php
                                                // Convertit la note en étoiles
                                                $rating = intval($comment['rating']);
                                                for ($i = 0; $i < $rating; $i++) {
                                                    echo '<i class="fas fa-star"></i>'; // Utilise une icône d'étoile de Font Awesome
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#commentsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#commentsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Formulaire de soumission de commentaire -->
            <section class="comment-submission-form-section mt-5 scroll-bottom">
                <div class="container">
                    <div class="row justify-content-center">
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

                                <form action="index.php" method="post">
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

    <!-- Inclusion de jQuery, Bootstrap Bundle JS, ScrollReveal et des scripts js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1do9iB5oI7yscp7OE/7gwT5LcGv1QooPnsVg3OcVC7UyssD4g8J2mP1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/back_to_top.js"></script>
    <script src="js/scrollreveal-init.js"></script>
    <script src="js/animated_numbers.js"></script>
    <script src="js/carousel.js"></script>

</body>

</html>
