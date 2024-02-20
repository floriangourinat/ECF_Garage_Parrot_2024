<!DOCTYPE html>
<html lang="fr">
<head>
    
    <!-- Meta tags pour la configuration de la page --> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/header.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">

    <!-- Lien vers Font Awesome pour les styles CSS notamment les icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/Logo_Garage.png" alt="Logo Garage Vincent Parrot">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Nos services</a></li>
                    <li class="nav-item"><a class="nav-link" href="vehicles.php">Nos véhicules</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Nous contacter</a></li>
                    <li class="nav-item"><a class="nav-link" href="submit_comment.php">Donnez votre avis</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php">🔒</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Inclusion de jQuery et Bootstrap Bundle JS pour le hamburger en version mobile -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
