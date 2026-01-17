<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Récupérer les données
$ventes = $_SESSION['ventes'] ?? [];
$clients = $_SESSION['clients'] ?? [];

// Calculer les statistiques
$nb_ventes = count($ventes);
$ca_total = 0;
$meilleure_vente = 0;
$remises_totales = 0;

if (!empty($ventes)) {
    foreach ($ventes as $vente) {
        $ca_total += $vente['montant_final'];
        $remises_totales += $vente['montant_remise'];
        if ($vente['montant_final'] > $meilleure_vente) {
            $meilleure_vente = $vente['montant_final'];
        }
    }
}

$vente_moyenne = $nb_ventes > 0 ? $ca_total / $nb_ventes : 0;

// Évaluation de la performance
$seuil_satisfaisant = 500000; // Seuil à 500 000 FCFA
$performance = $ca_total >= $seuil_satisfaisant ? 'Satisfaisante' : 'Insuffisante';
$performance_class = $ca_total >= $seuil_satisfaisant ? 'success' : 'warning';

// Statistiques par type de client
$ventes_particuliers = 0;
$ventes_professionnels = 0;
$ca_particuliers = 0;
$ca_professionnels = 0;

foreach ($ventes as $vente) {
    // Trouver le type de client
    foreach ($clients as $client) {
        if ($client['id'] == $vente['client_id']) {
            if ($client['type'] === 'Particulier') {
                $ventes_particuliers++;
                $ca_particuliers += $vente['montant_final'];
            } else {
                $ventes_professionnels++;
                $ca_professionnels += $vente['montant_final'];
            }
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Gestion PME</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>📊 Statistiques et Analyses</h1>
            <p>Tableau de bord des performances commerciales</p>
        </div>
        
        <?php if (empty($ventes)): ?>
            <div class="alert alert-warning">
                Aucune vente enregistrée. Les statistiques apparaîtront après l'enregistrement de ventes.
                <a href="ventes.php">Enregistrer une vente →</a>
            </div>
        <?php else: ?>
            
            <!-- Indicateurs principaux -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-content">
                        <h3><?php echo number_format($ca_total, 0, ',', ' '); ?> FCFA</h3>
                        <p>Chiffre d'affaires total</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <h3><?php echo number_format($vente_moyenne, 0, ',', ' '); ?> FCFA</h3>
                        <p>Vente moyenne</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🏆</div>
                    <div class="stat-content">
                        <h3><?php echo number_format($meilleure_vente, 0, ',', ' '); ?> FCFA</h3>
                        <p>Meilleure vente</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-content">
                        <h3><?php echo $nb_ventes; ?></h3>
                        <p>Nombre de ventes</p>
                    </div>
                </div>
            </div>
            
            <!-- Évaluation de la performance -->
            <div class="performance-section">
                <h2>📈 Évaluation de la Performance</h2>
                <div class="performance-card <?php echo $performance_class; ?>">
                    <div class="performance-badge">
                        <?php if ($performance === 'Satisfaisante'): ?>
                            ✅ PERFORMANCE SATISFAISANTE
                        <?php else: ?>
                            ⚠️ PERFORMANCE INSUFFISANTE
                        <?php endif; ?>
                    </div>
                    <div class="performance-details">
                        <p><strong>Chiffre d'affaires :</strong> <?php echo number_format($ca_total, 0, ',', ' '); ?> FCFA</p>
                        <p><strong>Objectif :</strong> <?php echo number_format($seuil_satisfaisant, 0, ',', ' '); ?> FCFA</p>
                        <?php if ($performance === 'Satisfaisante'): ?>
                            <p class="success-message">🎉 Félicitations ! L'objectif est atteint.</p>
                        <?php else: ?>
                            <?php $manquant = $seuil_satisfaisant - $ca_total; ?>
                            <p class="warning-message">Il manque <?php echo number_format($manquant, 0, ',', ' '); ?> FCFA pour atteindre l'objectif.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Analyse par type de client -->
            <div class="analysis-section">
                <h2>👥 Analyse par type de client</h2>
                <div class="analysis-grid">
                    <div class="analysis-card">
                        <h3>Particuliers</h3>
                        <div class="analysis-stats">
                            <div class="analysis-item">
                                <span class="label">Nombre de ventes :</span>
                                <span class="value"><?php echo $ventes_particuliers; ?></span>
                            </div>
                            <div class="analysis-item">
                                <span class="label">Chiffre d'affaires :</span>
                                <span class="value"><?php echo number_format($ca_particuliers, 0, ',', ' '); ?> FCFA</span>
                            </div>
                            <div class="analysis-item">
                                <span class="label">Part du CA :</span>
                                <span class="value">
                                    <?php echo $ca_total > 0 ? round(($ca_particuliers / $ca_total) * 100, 1) : 0; ?>%
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="analysis-card">
                        <h3>Professionnels</h3>
                        <div class="analysis-stats">
                            <div class="analysis-item">
                                <span class="label">Nombre de ventes :</span>
                                <span class="value"><?php echo $ventes_professionnels; ?></span>
                            </div>
                            <div class="analysis-item">
                                <span class="label">Chiffre d'affaires :</span>
                                <span class="value"><?php echo number_format($ca_professionnels, 0, ',', ' '); ?> FCFA</span>
                            </div>
                            <div class="analysis-item">
                                <span class="label">Part du CA :</span>
                                <span class="value">
                                    <?php echo $ca_total > 0 ? round(($ca_professionnels / $ca_total) * 100, 1) : 0; ?>%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Remises accordées -->
            <div class="remises-section">
                <h2>💸 Remises accordées</h2>
                <div class="remises-card">
                    <p><strong>Total des remises :</strong> <?php echo number_format($remises_totales, 0, ',', ' '); ?> FCFA</p>
                    <p><strong>Impact sur le CA :</strong> 
                        <?php 
                        $ca_avant_remise = $ca_total + $remises_totales;
                        echo $ca_avant_remise > 0 ? round(($remises_totales / $ca_avant_remise) * 100, 2) : 0; 
                        ?>%
                    </p>
                </div>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>