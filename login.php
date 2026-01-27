<?php
require_once 'includes/config.php';

// Si déjà connecté, rediriger vers le dashboard
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$erreur = '';
$succes = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($username) || empty($password)) {
        $erreur = 'Veuillez remplir tous les champs.';
    } else {
        $userFound = false;
        foreach ($users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $_SESSION['user'] = [
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                $userFound = true;
                header('Location: dashboard.php');
                exit;
            }
        }
        
        if (!$userFound) {
            $erreur = 'Identifiants incorrects. Veuillez réessayer.';
        }
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
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h1>Gestion PME</h1>
                <p>Système de Gestion Commerciale</p>
            </div>
            
            <?php if ($erreur): ?>
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($succes): ?>
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php echo htmlspecialchars($succes); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="username">Nom d'utilisateur</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input" 
                        placeholder="Entrez votre nom d'utilisateur"
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Entrez votre mot de passe"
                        required
                    >
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Se connecter
                </button>
            </form>
            
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid var(--gray-lighter); text-align: center;">
                <p style="color: var(--gray); font-size: 0.875rem; margin-bottom: 1rem;">
                    <strong>Comptes de démonstration :</strong>
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.875rem;">
                    <div style="background: var(--gray-lighter); padding: 0.75rem; border-radius: 8px;">
                        👤 <strong>admin</strong> / admin123
                    </div>
                    <div style="background: var(--gray-lighter); padding: 0.75rem; border-radius: 8px;">
                        👤 <strong>gestionnaire</strong> / gest123
                    </div>
                    <div style="background: var(--gray-lighter); padding: 0.75rem; border-radius: 8px;">
                        👤 <strong>vendeur</strong> / vend123
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>