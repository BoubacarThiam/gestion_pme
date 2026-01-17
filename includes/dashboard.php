<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Récupérer les données stockées en session
$clients = $_SESSION['clients'] ?? [];
$ventes = $_SESSION['ventes'] ?? [];
$employes = $_SESSION['employes'] ?? [];

// Calculer les statistiques
$nb_clients = count($clients);
$nb_ventes = count($ventes);
$nb_employes = count($employes);

$ca_total = array_sum(array_column($ventes, 'montant_final'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gestion PME</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>📊 Tableau de bord</h1>
            <p>Bienvenue, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
        </div>
        
        <div class="dashboard-grid">
            <div class="card card-primary">
                <div class="card-icon">👥</div>
                <div class="card-content">
                    <h3><?php echo $nb_clients; ?></h3>
                    <p>Clients</p>
                </div>
                <a href="clients.php" class="card-link">Gérer →</a>
            </div>
            
            <div class="card card-success">
                <div class="card-icon">💰</div>
                <div class="card-content">
                    <h3><?php echo $nb_ventes; ?></h3>
                    <p>Ventes</p>
                </div>
                <a href="ventes.php" class="card-link">Gérer →</a>
            </div>
            
            <div class="card card-warning">
                <div class="card-icon">👔</div>
                <div class="card-content">
                    <h3><?php echo $nb_employes; ?></h3>
                    <p>Employés</p>
                </div>
                <a href="employes.php" class="card-link">Gérer →</a>
            </div>
            
            <div class="card card-info">
                <div class="card-icon">📈</div>
                <div class="card-content">
                    <h3><?php echo number_format($ca_total, 0, ',', ' '); ?> FCFA</h3>
                    <p>Chiffre d'affaires</p>
                </div>
                <a href="statistiques.php" class="card-link">Voir détails →</a>
            </div>
        </div>
        
        <div class="quick-actions">
            <h2>Actions rapides</h2>
            <div class="actions-grid">
                <a href="clients.php" class="action-btn">
                    <span class="action-icon">➕</span>
                    <span>Nouveau client</span>
                </a>
                <a href="ventes.php" class="action-btn">
                    <span class="action-icon">🛒</span>
                    <span>Enregistrer vente</span>
                </a>
                <a href="employes.php" class="action-btn">
                    <span class="action-icon">👤</span>
                    <span>Ajouter employé</span>
                </a>
                <a href="statistiques.php" class="action-btn">
                    <span class="action-icon">📊</span>
                    <span>Voir statistiques</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>