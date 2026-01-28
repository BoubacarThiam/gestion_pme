<?php
require_once 'includes/config.php';
requireLogin();

$stats = calculerStatistiques();
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
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="dashboard.php" class="nav-brand">
                <div class="nav-logo">
                    <img src="asserts/image.png" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 12px;">
                </div>
                <span class="nav-title">Gestion PME</span>
            </a>
            
            <ul class="nav-menu">
                <li><a href="dashboard.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Tableau de bord
                </a></li>
                <li><a href="clients.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Clients
                </a></li>
                <li><a href="ventes.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Ventes
                </a></li>
                <li><a href="employes.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Employés
                </a></li>
                <li><a href="statistiques.php" class="nav-link active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistiques
                </a></li>
            </ul>
            
            <div class="nav-user">
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($_SESSION['user']['role']); ?></div>
                </div>
                <a href="logout.php" class="btn btn-secondary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Déconnexion
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Contenu principal -->
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">Tableau de Statistiques</h1>
            <p class="page-subtitle">Analyses et indicateurs de performance commerciale</p>
        </div>
        
        <?php if (empty($_SESSION['ventes'])): ?>
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Aucune donnée de vente disponible. Les statistiques seront générées une fois les ventes enregistrées.
            </div>
        <?php endif; ?>
        
        <!-- Indicateurs principaux -->
        <div class="grid grid-3" style="margin-bottom: 2rem;">
            <div class="stat-card" style="animation-delay: 0.1s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-label">Chiffre d'Affaires Total</div>
                <div class="stat-value" style="font-size: 1.75rem;"><?php echo formatMontant($stats['ca_total']); ?></div>
                <div class="stat-change positive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <?php echo $stats['nombre_ventes']; ?> vente(s)
                </div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.2s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stat-label">Vente Moyenne</div>
                <div class="stat-value" style="font-size: 1.75rem;"><?php echo formatMontant($stats['vente_moyenne']); ?></div>
                <div class="stat-change" style="color: var(--info);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Par transaction
                </div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.3s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <div class="stat-label">Meilleure Vente</div>
                <div class="stat-value" style="font-size: 1.75rem;"><?php echo formatMontant($stats['meilleure_vente']); ?></div>
                <div class="stat-change" style="color: var(--warning);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Record
                </div>
            </div>
        </div>
        
        <!-- Performance globale -->
        <div class="card" style="animation-delay: 0.4s; margin-bottom: 2rem;">
            <div class="card-header">
                <h2 class="card-title">Évaluation de la Performance</h2>
            </div>
            <div class="card-body">
                <div style="text-align: center; padding: 2rem;">
                    <?php
                    $performanceClass = 'performance-insuffisante';
                    $performanceIcon = '⚠️';
                    $performanceMessage = "La performance commerciale nécessite une amélioration. Objectif : atteindre une vente moyenne d'au moins 50 000 FCFA.";
                    
                    if ($stats['performance'] === 'Excellente') {
                        $performanceClass = 'performance-excellent';
                        $performanceIcon = '🎉';
                        $performanceMessage = "Excellente performance ! La vente moyenne dépasse les 100 000 FCFA. L'entreprise est en excellente santé commerciale.";
                    } elseif ($stats['performance'] === 'Satisfaisante') {
                        $performanceClass = 'performance-satisfaisante';
                        $performanceIcon = '👍';
                        $performanceMessage = "Performance satisfaisante. La vente moyenne se situe entre 50 000 et 100 000 FCFA. Continue sur cette lancée !";
                    }
                    ?>
                    
                    <div style="font-size: 4rem; margin-bottom: 1rem;"><?php echo $performanceIcon; ?></div>
                    <div class="performance-badge <?php echo $performanceClass; ?>" style="margin-bottom: 2rem;">
                        Performance : <?php echo htmlspecialchars($stats['performance']); ?>
                    </div>
                    
                    <p style="color: var(--gray); font-size: 1.125rem; max-width: 600px; margin: 0 auto; line-height: 1.8;">
                        <?php echo $performanceMessage; ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Analyses détaillées -->
        <div class="grid grid-2">
            <!-- Analyse des remises -->
            <div class="card" style="animation-delay: 0.5s;">
                <div class="card-header">
                    <h2 class="card-title">Analyse des Remises</h2>
                </div>
                <div class="card-body">
                    <?php
                    if (!empty($_SESSION['ventes'])) {
                        $ventes_avec_remise_10 = count(array_filter($_SESSION['ventes'], fn($v) => $v['remise'] == 10));
                        $ventes_avec_remise_5 = count(array_filter($_SESSION['ventes'], fn($v) => $v['remise'] == 5));
                        $ventes_sans_remise = count(array_filter($_SESSION['ventes'], fn($v) => $v['remise'] == 0));
                        
                        $total_remises = array_sum(array_map(function($v) {
                            return $v['montant'] * ($v['remise'] / 100);
                        }, $_SESSION['ventes']));
                    ?>
                        <div style="display: grid; gap: 1.5rem;">
                            <div style="padding: 1.5rem; background: var(--gray-lighter); border-radius: 12px;">
                                <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                                    Montant Total des Remises
                                </div>
                                <div style="font-size: 2rem; font-weight: 900; color: var(--error);">
                                    -<?php echo formatMontant($total_remises); ?>
                                </div>
                            </div>
                            
                            <div style="display: grid; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #d1fae5; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 600; color: #065f46;">Remise 10%</div>
                                        <div style="font-size: 0.875rem; color: #059669;">≥ 100 000 FCFA</div>
                                    </div>
                                    <div style="font-size: 1.5rem; font-weight: 900; color: #065f46;">
                                        <?php echo $ventes_avec_remise_10; ?>
                                    </div>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #dbeafe; border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 600; color: #1e40af;">Remise 5%</div>
                                        <div style="font-size: 0.875rem; color: #2563eb;">≥ 50 000 FCFA</div>
                                    </div>
                                    <div style="font-size: 1.5rem; font-weight: 900; color: #1e40af;">
                                        <?php echo $ventes_avec_remise_5; ?>
                                    </div>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: var(--gray-lighter); border-radius: 8px;">
                                    <div>
                                        <div style="font-weight: 600; color: var(--dark);">Sans remise</div>
                                        <div style="font-size: 0.875rem; color: var(--gray);">< 50 000 FCFA</div>
                                    </div>
                                    <div style="font-size: 1.5rem; font-weight: 900; color: var(--dark);">
                                        <?php echo $ventes_sans_remise; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div style="text-align: center; padding: 2rem; color: var(--gray);">
                            <p>Aucune donnée disponible</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <!-- Top clients -->
            <div class="card" style="animation-delay: 0.6s;">
                <div class="card-header">
                    <h2 class="card-title">Top Clients</h2>
                </div>
                <div class="card-body">
                    <?php
                    if (!empty($_SESSION['ventes'])) {
                        // Calculer le CA par client
                        $ca_par_client = [];
                        foreach ($_SESSION['ventes'] as $vente) {
                            $client_id = $vente['client_id'];
                            if (!isset($ca_par_client[$client_id])) {
                                $ca_par_client[$client_id] = [
                                    'nom' => $vente['client_nom'],
                                    'total' => 0,
                                    'nombre_achats' => 0
                                ];
                            }
                            $ca_par_client[$client_id]['total'] += $vente['montant_final'];
                            $ca_par_client[$client_id]['nombre_achats']++;
                        }
                        
                        // Trier par CA décroissant
                        usort($ca_par_client, fn($a, $b) => $b['total'] <=> $a['total']);
                        $top_clients = array_slice($ca_par_client, 0, 5);
                    ?>
                        <div style="display: grid; gap: 1rem;">
                            <?php foreach ($top_clients as $index => $client): ?>
                                <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px; position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: 0; left: 0; bottom: 0; width: <?php echo min(($client['total'] / $ca_par_client[0]['total']) * 100, 100); ?>%; background: linear-gradient(90deg, rgba(4, 120, 87, 0.1) 0%, rgba(4, 120, 87, 0.05) 100%);"></div>
                                    <div style="position: relative; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
                                                <span style="font-size: 1.5rem; font-weight: 900; color: var(--accent);">
                                                    #<?php echo $index + 1; ?>
                                                </span>
                                                <strong style="font-size: 1.125rem;"><?php echo htmlspecialchars($client['nom']); ?></strong>
                                            </div>
                                            <div style="font-size: 0.875rem; color: var(--gray);">
                                                <?php echo $client['nombre_achats']; ?> achat<?php echo $client['nombre_achats'] > 1 ? 's' : ''; ?>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <div style="font-size: 1.25rem; font-weight: 900; color: var(--primary);">
                                                <?php echo formatMontant($client['total']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php } else { ?>
                        <div style="text-align: center; padding: 2rem; color: var(--gray);">
                            <p>Aucune donnée disponible</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- Recommandations -->
        <div class="card" style="margin-top: 2rem; animation-delay: 0.7s;">
            <div class="card-header">
                <h2 class="card-title">Recommandations Stratégiques</h2>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1.5rem;">
                    <?php if ($stats['performance'] === 'Insuffisante'): ?>
                        <div class="alert alert-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <strong>Amélioration nécessaire :</strong>
                                <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                                    <li>Cibler des ventes de montant plus élevé (≥ 50 000 FCFA)</li>
                                    <li>Développer les offres pour clients professionnels</li>
                                    <li>Mettre en place des stratégies de fidélisation</li>
                                </ul>
                            </div>
                        </div>
                    <?php elseif ($stats['performance'] === 'Satisfaisante'): ?>
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <strong>Bonne performance, continuez :</strong>
                                <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                                    <li>Maintenir la qualité du service client</li>
                                    <li>Viser des ventes ≥ 100 000 FCFA pour atteindre l'excellence</li>
                                    <li>Élargir le portefeuille clients</li>
                                </ul>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <strong>Excellente performance :</strong>
                                <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                                    <li>Maintenir ce niveau d'excellence</li>
                                    <li>Capitaliser sur les meilleures pratiques actuelles</li>
                                    <li>Explorer de nouveaux marchés pour la croissance</li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div style="padding: 1.5rem; background: var(--gray-lighter); border-radius: 12px;">
                        <h3 style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">💡 Conseils généraux</h3>
                        <ul style="display: grid; gap: 0.75rem; margin-left: 1.5rem; color: var(--dark);">
                            <li>Analysez régulièrement vos statistiques pour identifier les tendances</li>
                            <li>Fidélisez vos meilleurs clients avec des offres personnalisées</li>
                            <li>Formez votre équipe commerciale aux techniques de vente</li>
                            <li>Diversifiez votre offre de produits/services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <p>© 2026 Système de Gestion PME - Développé pour ISM Thiès</p>
    </footer>
</body>
</html>