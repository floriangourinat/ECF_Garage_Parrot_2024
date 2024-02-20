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

// Vérifie si l'ID du service est défini pour la modification
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $service = $stmt->fetch();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $imgService = $service['img_service'] ?? ''; // Garder l'image actuelle par défaut

    // Vérifie si un nouveau fichier a été téléchargé
    if (isset($_FILES['image_service']) && $_FILES['image_service']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image_service']['tmp_name'];
        $name = basename($_FILES['image_service']['name']);
        $upload_dir = '../uploads/';
        $upload_path = $upload_dir . $name;

        // Déplace le nouveau fichier téléchargé vers le dossier des téléchargements
        move_uploaded_file($tmp_name, $upload_path);
        $imgService = $upload_path;
    }

    // Mettre à jour les informations du service dans la base de données, y compris l'image uniquement si une nouvelle image est téléchargée
    if (!empty($title) && !empty($description)) {
        if (!empty($imgService)) {
            $stmt = $conn->prepare("UPDATE services SET title = ?, description = ?, img_service = ? WHERE id = ?");
            $stmt->execute([$title, $description, $imgService, $id]);
        } else {
            // Si aucune nouvelle image n'est téléchargée, conserver l'image actuelle en base de données
            $stmt = $conn->prepare("UPDATE services SET title = ?, description = ? WHERE id = ?");
            $stmt->execute([$title, $description, $id]);
        }
        $success_message = 'Service mis à jour avec succès.';
    } else {
        $error_message = 'Veuillez remplir tous les champs.';
    }

    header('Location: manage_services.php');
    exit;
}

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Modifier un Service</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/admin.css">

    <!-- Inclusion des polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lien vers Bootstrap pour les styles CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <div class="admin-service-management mt-5">
        <h2 class="page-title">Modifier un Service</h2>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="edit_service.php" class="form-container" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['id'] ?? ''); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre du Service</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($service['title'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($service['description'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image du Service</label>
                <input type="file" class="form-control" id="image_service" name="image_service" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary btn-action">Enregistrer les modifications</button>
        </form>
    </div>

</body>
</html>
