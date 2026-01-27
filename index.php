<?php
require_once 'includes/config.php';

// Redirection vers le dashboard si connecté, sinon vers login
if (isLoggedIn()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
?>