<?php
session_start();

// Rediriger vers le dashboard si déjà connecté
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Rediriger vers la page de connexion
header('Location: login.php');
exit();
?>