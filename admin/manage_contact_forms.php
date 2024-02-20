<?php
session_start();
require_once '../includes/db.php';

// Vérifie si l'utilisateur est connecté et a le rôle 'admin' ou 'employee'
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    header('Location: ../user/login.php');
    exit;
}

// Traitement de la suppression si le formulaire est soumis 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_contact'])) {
    $contact_id = $_POST['contact_id'];
    
    // Supprime le formulaire de contact de la base de données en fonction de son ID
    try {
        $stmt = $conn->prepare("DELETE FROM contacts WHERE id = :contact_id");
        $stmt->bindParam(':contact_id', $contact_id);
        $stmt->execute();
        
        // Redirection vers la page actuelle après la suppression
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de la suppression du formulaire de contact : " . $e->getMessage());
    }
}

// Récupère les formulaires de contact depuis la base de données
try {
    $stmt = $conn->query("SELECT contacts.id, contacts.visitor_id, contacts.message, contacts.created_at, visitors.firstname, visitors.lastname, visitors.email FROM contacts JOIN visitors ON contacts.visitor_id = visitors.id");
    $contact_forms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de récupération des formulaires de contact : " . $e->getMessage());
}

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Gérer les Formulaires de Contact</title>

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
        <section class="admin-contact-forms-management">
            <h2>Liste des Formulaires de Contact Soumis</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Visitor ID</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contact_forms as $form): ?>
                        <tr>
                            <td><?php echo $form['id']; ?></td>
                            <td><?php echo $form['visitor_id']; ?></td>
                            <td><?php echo htmlspecialchars($form['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($form['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($form['email']); ?></td>
                            <td><?php echo htmlspecialchars($form['message']); ?></td>
                            <td><?php echo $form['created_at']; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce formulaire de contact ?');">
                                    <input type="hidden" name="contact_id" value="<?php echo $form['id']; ?>">
                                    <button type="submit" name="delete_contact" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
