<?php
session_start();

// Efface toutes les variables de session 
$_SESSION = array();

// Si vous voulez tuer la session, effacez également le cookie de session.
// Cela détruira la session et pas seulement les données de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, détruire la session.
session_destroy();

// Redirige vers la page de connexion ou la page d'accueil
header('Location: login.php');
exit;
