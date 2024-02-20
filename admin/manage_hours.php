<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}

$error_message = '';
$success_message = '';
$schedule_data = [];

try {
    $query = "SELECT * FROM schedules ORDER BY id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $schedule_data[$row['day']] = [
            'morning_opening_hour' => $row['morning_opening_hour'],
            'morning_closing_hour' => $row['morning_closing_hour'],
            'afternoon_opening_hour' => $row['afternoon_opening_hour'],
            'afternoon_closing_hour' => $row['afternoon_closing_hour']
        ];
    }
} catch (PDOException $e) {
    $error_message = "Erreur lors de la récupération des horaires : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($schedule_data as $day => &$times) {
        if (isset($_POST[$day . '_morning_opening_hour']) && isset($_POST[$day . '_morning_closing_hour']) &&
            isset($_POST[$day . '_afternoon_opening_hour']) && isset($_POST[$day . '_afternoon_closing_hour'])) {
            $times['morning_opening_hour'] = $_POST[$day . '_morning_opening_hour'];
            $times['morning_closing_hour'] = $_POST[$day . '_morning_closing_hour'];
            $times['afternoon_opening_hour'] = $_POST[$day . '_afternoon_opening_hour'];
            $times['afternoon_closing_hour'] = $_POST[$day . '_afternoon_closing_hour'];
            try {
                $update_query = "UPDATE schedules SET 
                    morning_opening_hour = :morning_opening_hour, 
                    morning_closing_hour = :morning_closing_hour,
                    afternoon_opening_hour = :afternoon_opening_hour, 
                    afternoon_closing_hour = :afternoon_closing_hour 
                    WHERE day = :day";
                $stmt = $conn->prepare($update_query);
                $stmt->execute([
                    ':morning_opening_hour' => $times['morning_opening_hour'],
                    ':morning_closing_hour' => $times['morning_closing_hour'],
                    ':afternoon_opening_hour' => $times['afternoon_opening_hour'],
                    ':afternoon_closing_hour' => $times['afternoon_closing_hour'],
                    ':day' => $day
                ]);
            } catch (PDOException $e) {
                $error_message = "Erreur lors de la mise à jour des horaires pour $day : " . $e->getMessage();
                break; // Sortie de la boucle en cas d'erreur 
            }
        }
    }
    if (empty($error_message)) {
        $success_message = "Les horaires ont été mis à jour avec succès.";
    }
}

require_once '../includes/admin_header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Meta tags pour la configuration de la page -->
    <meta charset="UTF-8">
    <title>Modifier les Horaires d'Ouverture et de Fermeture</title>

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
        <section class="admin-hours-management">
            <h1>Modifier les Horaires d'Ouverture et de Fermeture</h1>
            <?php if (!empty($success_message)): ?>
                <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form action="update_hours.php" method="post">
                <?php foreach ($schedule_data as $day => $times): ?>
                    <div class="day-schedule">
                        <h2><?php echo htmlspecialchars(ucfirst($day)); ?></h2>
                        <label for="<?php echo $day; ?>_morning_opening_hour">Heure d'ouverture (matin):</label>
                        <input type="time" name="<?php echo $day; ?>_morning_opening_hour" id="<?php echo $day; ?>_morning_opening_hour" value="<?php echo htmlspecialchars($times['morning_opening_hour']); ?>">

                        <label for="<?php echo $day; ?>_morning_closing_hour">Heure de fermeture (matin):</label>
                        <input type="time" name="<?php echo $day; ?>_morning_closing_hour" id="<?php echo $day; ?>_morning_closing_hour" value="<?php echo htmlspecialchars($times['morning_closing_hour']); ?>">

                        <label for="<?php echo $day; ?>_afternoon_opening_hour">Heure d'ouverture (après-midi):</label>
                        <input type="time" name="<?php echo $day; ?>_afternoon_opening_hour" id="<?php echo $day; ?>_afternoon_opening_hour" value="<?php echo htmlspecialchars($times['afternoon_opening_hour']); ?>">

                        <label for="<?php echo $day; ?>_afternoon_closing_hour">Heure de fermeture (après-midi):</label>
                        <input type="time" name="<?php echo $day; ?>_afternoon_closing_hour" id="<?php echo $day; ?>_afternoon_closing_hour" value="<?php echo htmlspecialchars($times['afternoon_closing_hour']); ?>">
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </section>
    </main>
</body>   
</html>
