<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Validation de l'ID du véhicule
$vehicleId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Données par défaut du véhicule
$vehicleData = [
    'brand' => '', 'model' => '', 'year' => '', 'mileage' => '', 'price' => '', 
    'condition' => '', 'power' => '', 'transmission' => '', 'fuel' => '', 
    'consumption' => '', 'navigation' => 0, 'heated_seats' => 0, 'oil_change' => 0, 
    'technical_control' => 0, 'warranty' => 0, 'number_doors' => '', 'color' => '', 
    'photo_url' => ''
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation et traitement des données du formulaire

    // Échappement des données saisies dans le formulaire
    $brand = htmlspecialchars($_POST['brand']);
    $model = htmlspecialchars($_POST['model']);
    $year = htmlspecialchars($_POST['year']);
    $mileage = htmlspecialchars($_POST['mileage']);
    $price = htmlspecialchars($_POST['price']);
    $condition = htmlspecialchars($_POST['condition']);
    $power = htmlspecialchars($_POST['power']);
    $transmission = htmlspecialchars($_POST['transmission']);
    $fuel = htmlspecialchars($_POST['fuel']);
    $consumption = htmlspecialchars($_POST['consumption']);
    $navigation = isset($_POST['navigation']) ? 1 : 0;
    $heated_seats = isset($_POST['heated_seats']) ? 1 : 0;
    $oil_change = isset($_POST['oil_change']) ? 1 : 0;
    $technical_control = isset($_POST['technical_control']) ? 1 : 0;
    $warranty = isset($_POST['warranty']) ? 1 : 0;
    $number_doors = htmlspecialchars($_POST['number_doors']);
    $color = htmlspecialchars($_POST['color']);
    $photo_url = $vehicleData['photo_url'];

    // Validation des fichiers téléchargés
    if (isset($_FILES['photo_url']) && $_FILES['photo_url']['size'] > 0) {
        // Traitement de l'upload de la nouvelle image
    }

    // Mise à jour des données dans la base de données
    try {
        // Requête préparée pour mettre à jour les données du véhicule
        $stmt = $conn->prepare("UPDATE vehicles SET brand = ?, model = ?, year = ?, mileage = ?, price = ?, `condition` = ?, power = ?, transmission = ?, fuel = ?, consumption = ?, navigation = ?, heated_seats = ?, oil_change = ?, technical_control = ?, warranty = ?, number_doors = ?, color = ?" . (!empty($photo_url) ? ", photo_url = ?" : "") . " WHERE id = ?");
        
        // Paramètres de la requête
        $params = [
            $brand, $model, $year, $mileage, $price, $condition, $power, $transmission, $fuel, 
            $consumption, $navigation, $heated_seats, $oil_change, $technical_control, $warranty, 
            $number_doors, $color
        ];
        
        // Ajoute l'URL de la photo et l'ID du véhicule aux paramètres si une nouvelle photo a été téléchargée
        if (!empty($photo_url)) {
            $params[] = $photo_url;
        }
        $params[] = $vehicleId;

        // Exécution de la requête
        $stmt->execute($params);
        header("Location: manage_cars.php");
        exit;
    } catch (PDOException $e) {
        // Gestion des erreurs
        $_SESSION['error_message'] = "Erreur lors de la modification du véhicule : " . $e->getMessage();
        header("Location: edit_car.php?id=$vehicleId");
        exit;
    }
} else {
    // Récupération des détails du véhicule à modifier
    try {
        $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
        $stmt->execute([$vehicleId]);
        $vehicleData = $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la récupération des détails du véhicule : " . $e->getMessage();
        header("Location: manage_cars.php");
        exit;
    }
}

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Modifier un véhicule</title> 

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
        <section class="edit-car-section">
            <h2>Modifier un Véhicule</h2>
            <form action="edit_car.php?id=<?= $vehicleId; ?>" method="post" enctype="multipart/form-data">
                <input type="text" name="brand" placeholder="Marque" value="<?= isset($vehicleData['brand']) ? htmlspecialchars($vehicleData['brand']) : ''; ?>" required>
                <input type="text" name="model" placeholder="Modèle" value="<?= isset($vehicleData['model']) ? htmlspecialchars($vehicleData['model']) : ''; ?>" required>
                <input type="number" name="year" placeholder="Année" value="<?= isset($vehicleData['year']) ? htmlspecialchars($vehicleData['year']) : ''; ?>" required>
                <input type="number" name="mileage" placeholder="Kilométrage" value="<?= isset($vehicleData['mileage']) ? htmlspecialchars($vehicleData['mileage']) : ''; ?>" required>
                <input type="number" name="price" placeholder="Prix" value="<?= isset($vehicleData['price']) ? htmlspecialchars($vehicleData['price']) : ''; ?>" required>
                <select name="condition" required>
                    <option value="Neuf" <?= isset($vehicleData['condition']) && $vehicleData['condition'] == 'Neuf' ? 'selected' : ''; ?>>Neuf</option>
                    <option value="Occasion" <?= isset($vehicleData['condition']) && $vehicleData['condition'] == 'Occasion' ? 'selected' : ''; ?>>Occasion</option>
                </select>
                <input type="number" name="power" placeholder="Puissance (CV)" value="<?= isset($vehicleData['power']) ? htmlspecialchars($vehicleData['power']) : ''; ?>" required>
                <input type="text" name="transmission" placeholder="Transmission" value="<?= isset($vehicleData['transmission']) ? htmlspecialchars($vehicleData['transmission']) : ''; ?>" required>
                <input type="text" name="fuel" placeholder="Carburant" value="<?= isset($vehicleData['fuel']) ? htmlspecialchars($vehicleData['fuel']) : ''; ?>" required>
                <input type="text" name="consumption" placeholder="Consommation /100km (Rajouter L ou kWh)" value="<?= isset($vehicleData['consumption']) ? htmlspecialchars($vehicleData['consumption']) : ''; ?>" required>
                <label for="navigation">Navigation :</label>
                <input type="checkbox" name="navigation" id="navigation" <?= isset($vehicleData['navigation']) && $vehicleData['navigation'] == 1 ? 'checked' : ''; ?>>
                <label for="heated_seats">Sièges chauffants :</label>
                <input type="checkbox" name="heated_seats" id="heated_seats" <?= isset($vehicleData['heated_seats']) && $vehicleData['heated_seats'] == 1 ? 'checked' : ''; ?>>
                <label for="oil_change">Vidange nécessaire :</label>
                <input type="checkbox" name="oil_change" id="oil_change" <?= isset($vehicleData['oil_change']) && $vehicleData['oil_change'] == 1 ? 'checked' : ''; ?>>
                <label for="technical_control">Contrôle technique :</label>
                <input type="checkbox" name="technical_control" id="technical_control" <?= isset($vehicleData['technical_control']) && $vehicleData['technical_control'] == 1 ? 'checked' : ''; ?>>
                <label for="warranty">Garantie :</label>
                <input type="checkbox" name="warranty" id="warranty" <?= isset($vehicleData['warranty']) && $vehicleData['warranty'] == 1 ? 'checked' : ''; ?>>
                <input type="number" name="number_doors" placeholder="Nombre de portes" value="<?= isset($vehicleData['number_doors']) ? htmlspecialchars($vehicleData['number_doors']) : ''; ?>" required>
                <input type="text" name="color" placeholder="Couleur" value="<?= isset($vehicleData['color']) ? htmlspecialchars($vehicleData['color']) : ''; ?>" required>
                <label for="photo_url">Photo du véhicule :</label>
                <input type="file" name="photo_url" id="photo_url">
                <?php if (!empty($vehicleData['photo_url'])): ?>
                    <p>Photo actuelle :</p>
                    <img src="<?= $vehicleData['photo_url'] ?>" alt="<?= isset($vehicleData['brand']) && isset($vehicleData['model']) ? htmlspecialchars($vehicleData['brand'] . ' ' . $vehicleData['model']) : ''; ?>" width="100">
                <?php endif; ?>
                <button type="submit" name="submit">Modifier le Véhicule</button>
            </form>
        </section>
    </main>

</body>
</html>
