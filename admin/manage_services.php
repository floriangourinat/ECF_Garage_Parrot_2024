<?php
session_start();
require_once '../includes/db.php';

// Vérification de l'authentification et des autorisations
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}


// Traitement de l'ajout d'un nouveau service
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $imgService = '';

    // Vérifie si un fichier a été téléchargé
    if (isset($_FILES['image_service']) && $_FILES['image_service']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image_service']['tmp_name'];
        $name = basename($_FILES['image_service']['name']);
        $upload_dir = '../uploads/';
        $upload_path = $upload_dir . $name;

        // Déplace le fichier téléchargé vers le dossier des téléchargements
        move_uploaded_file($tmp_name, $upload_path);
        $imgService = $upload_path;
    } else {
        // Gère l'erreur de téléchargement de fichier
        echo "Une erreur s'est produite lors du téléchargement du fichier.";
        exit;
    }

    // Stocke les informations du service dans la base de données
    $stmt = $conn->prepare("INSERT INTO services (title, description, img_service) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $imgService]);

    header('Location: manage_services.php');
    exit;
}

// Traitement de la suppression d'un service
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT img_service FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $service = $stmt->fetch();

    // Supprimer l'image associée du dossier "uploads"
    if ($service && file_exists($service['img_service'])) {
        unlink($service['img_service']);
    }

    // Supprimer l'enregistrement de la base de données
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: manage_services.php');
    exit;
}

// Récupération des services existants
$stmt = $conn->query("SELECT * FROM services");
$services = $stmt->fetchAll();

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Gérer les Services</title>

    <!-- Inclusion des fichiers CSS spécifiques à la page -->
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

    <main>
        <section class="admin-service-management mt-5">
            <h2 class="page-title">Gérer les Services</h2>
            
            <!-- Formulaire d'ajout de service -->
            <form method="POST" action="manage_services.php" class="mb-5 form-container" enctype="multipart/form-data">
                <h3 class="form-title">Ajouter un Service</h3>
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du Service</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image du Service</label>
                    <input type="file" class="form-control" id="image_service" name="image_service" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary btn-action">Ajouter</button>
            </form>

            <!-- Affichage des services existants -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($service['title'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($service['description'] ?? ''); ?></td>
                            <td>
                                <?php if ($service['img_service']): ?>
                                    <img src="<?php echo htmlspecialchars($service['img_service']); ?>" alt="Service Image" class="service-image" style="max-width: 100px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_service.php?id=<?php echo $service['id']; ?>" class="btn btn-primary btn-action">Modifier</a>
                                <a href="manage_services.php?action=delete&id=<?php echo $service['id']; ?>" class="btn btn-danger btn-action" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>
</html>
