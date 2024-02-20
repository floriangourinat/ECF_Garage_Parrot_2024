<?php
require_once 'includes/db.php';

// Tente de récupérer les véhicules depuis la base de données
try {
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();
    $vehicles = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
    die();
}

// Génère des listes uniques pour les marques, modèles et années
$brands = array_unique(array_column($vehicles, 'brand'));
$models = array_unique(array_column($vehicles, 'model'));
$years = array_unique(array_column($vehicles, 'year'));

require_once 'includes/header.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Nos Véhicules d'Occasion - Garage Vincent Parrot</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/vehicles.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">

    <!-- Lien vers noUiSlider pour les styles CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">

</head>
<body>
    <main>
        <section class="vehicles-section scroll-top">
            <h2>Nos Véhicules d'Occasion</h2>
            <div class="filter-container">
                <div class="filter-left">
                    <!-- Filtre par marque -->
                    <select id="filterMake" class="form-select custom-select">
                        <option value="">Marque</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo $brand; ?>"><?php echo $brand; ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <!-- Filtre par modèle -->
                    <select id="filterModel" class="form-select custom-select">
                        <option value="">Modèle</option>
                        <?php foreach ($models as $model): ?>
                            <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-right">
                    <!-- Slider pour le filtrage par prix -->
                    <div class="slider-container">
                        <div class="slider-label">Filtrer par prix:</div>
                        <div id="price-slider" data-min="<?php echo intval(min(array_column($vehicles, 'price'))); ?>" data-max="<?php echo intval(max(array_column($vehicles, 'price'))); ?>"></div>
                        <div id="price-label" class="slider-label">
                            Entre <span class="min-value"></span> et <span class="max-value"></span> €
                        </div>
                    </div>

                    <!-- Slider pour le filtrage par kilométrage -->
                    <div class="slider-container">
                        <div class="slider-label">Filtrer par kilométrage:</div>
                        <div id="mileage-slider" data-min="<?php echo intval(min(array_column($vehicles, 'mileage'))); ?>" data-max="<?php echo intval(max(array_column($vehicles, 'mileage'))); ?>"></div>
                        <div id="mileage-label" class="slider-label">
                            Entre <span class="min-value"></span> et <span class="max-value"></span> km
                        </div>
                    </div>

                    <!-- Curseur pour le filtrage par année -->
                    <div class="slider-container">
                        <div class="slider-label">Filtrer par année:</div>
                        <div id="year-slider" data-min="<?php echo intval(min(array_column($vehicles, 'year'))); ?>" data-max="<?php echo intval(max(array_column($vehicles, 'year'))); ?>"></div>
                        <div id="year-label" class="slider-label">
                            Entre <span class="min-value"></span> et <span class="max-value"></span>
                        </div>
                    </div>

                    <!-- Bouton de réinitialisation -->
                    <button type="button" id="resetFilters" class="btn btn-secondary">Réinitialiser</button>
                </div>
            </div>

            <div class="vehicles-container scroll-left">
                <?php foreach ($vehicles as $vehicle): ?>
                    <div class="vehicle-card" data-make="<?php echo $vehicle['brand']; ?>" data-model="<?php echo $vehicle['model']; ?>" data-price="<?php echo $vehicle['price']; ?>" data-mileage="<?php echo $vehicle['mileage']; ?>" data-year="<?php echo $vehicle['year']; ?>">
                        <img src="uploads/<?php echo $vehicle['photo_url']; ?>" alt="Image de <?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>">
                        <h3 class="card-title"><?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?></h3>
                        <p>Année: <?php echo htmlspecialchars($vehicle['year']); ?></p>
                        <p>Kilométrage: <?php echo htmlspecialchars(number_format($vehicle['mileage'])); ?> km</p>
                        <p>Prix: <?php echo htmlspecialchars(number_format($vehicle['price'], 2)); ?> €</p>
                        <a href="vehicle_details.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-primary">Voir les détails</a>
                    </div>
                <?php endforeach ?>
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

    <!-- Inclusion de jQuery, noUiSlider, Bootstrap Bundle JS, ScrollReveal et des scripts js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="js/back_to_top.js"></script>
    <script src="js/filter_vehicles.js"></script>
    <script src="js/reset_filters.js"></script>
    <script src="js/scrollreveal-init.js"></script>

    <script>
    // Script pour appliquer les filtres dès que les valeurs des sliders ou des sélections changent
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('filterMake').addEventListener('change', applyFilters);
        document.getElementById('filterModel').addEventListener('change', applyFilters);
        priceSlider.noUiSlider.on('update', applyFilters);
        mileageSlider.noUiSlider.on('update', applyFilters);
        yearSlider.noUiSlider.on('update', applyFilters);
    });
    </script>
</body>
</html>
