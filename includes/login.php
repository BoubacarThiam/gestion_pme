<?php
session_start();

// Utilisateurs valides (en production, utiliser une base de données)
$users = [
    'admin' => 'admin123',
    'gestionnaire' => 'gestion2024',
    'commercial' => 'vente2024'
];

$error = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validation des champs
    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';
    } elseif (isset($users[$username]) && $users[$username] === $password) {
        // Connexion réussie
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système de Gestion PME</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>🏢 Gestion PME</h1>
                <p>Système de Gestion Commerciale et Administrative</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" 
                           placeholder="Entrez votre identifiant" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Entrez votre mot de passe" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    Se connecter
                </button>
            </form>
            
            <div class="login-footer">
                <p><strong>Comptes de test :</strong></p>
                <p>admin / admin123 • gestionnaire / gestion2024</p>
            </div>
        </div>
    </div>
</body>
</html>