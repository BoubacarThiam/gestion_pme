<?php
require_once 'includes/config.php';
requireLogin();

$stats = calculerStatistiques();
$nbClients = count($_SESSION['clients']);
$nbEmployes = count($_SESSION['employes']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Gestion PME</title>
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
                <li><a href="dashboard.php" class="nav-link active">
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
                <li><a href="statistiques.php" class="nav-link">
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
            <h1 class="page-title">Tableau de Bord</h1>
            <p class="page-subtitle">Vue d'ensemble de votre activité commerciale</p>
        </div>
        
        <!-- Cartes statistiques -->
        <div class="grid grid-4" style="margin-bottom: 2rem;">
            <div class="stat-card" style="animation-delay: 0.1s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="stat-label">Total Clients</div>
                <div class="stat-value"><?php echo $nbClients; ?></div>
                <div class="stat-change positive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Actifs
                </div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.2s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-label">Chiffre d'affaires</div>
                <div class="stat-value" style="font-size: 1.5rem;"><?php echo formatMontant($stats['ca_total']); ?></div>
                <div class="stat-change positive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Total généré
                </div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.3s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="stat-label">Ventes Réalisées</div>
                <div class="stat-value"><?php echo $stats['nombre_ventes']; ?></div>
                <div class="stat-change positive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Transactions
                </div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.4s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stat-label">Employés</div>
                <div class="stat-value"><?php echo $nbEmployes; ?></div>
                <div class="stat-change positive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Équipe active
                </div>
            </div>
        </div>
        
        <!-- Grille à 2 colonnes -->
        <div class="grid grid-2">
            <!-- Dernières ventes -->
            <div class="card" style="animation-delay: 0.5s;">
                <div class="card-header">
                    <h2 class="card-title">Dernières Ventes</h2>
                    <a href="ventes.php" class="btn btn-accent btn-sm">Voir tout</a>
                </div>
                <div class="card-body">
                    <?php if (empty($_SESSION['ventes'])): ?>
                        <p style="text-align: center; color: var(--gray); padding: 2rem;">
                            Aucune vente enregistrée
                        </p>
                    <?php else: ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $dernieres_ventes = array_slice(array_reverse($_SESSION['ventes']), 0, 5);
                                    foreach ($dernieres_ventes as $vente): 
                                    ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($vente['client_nom']); ?></strong></td>
                                            <td><?php echo formatMontant($vente['montant_final']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($vente['date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Aperçu performance -->
            <div class="card" style="animation-delay: 0.6s;">
                <div class="card-header">
                    <h2 class="card-title">Performance Commerciale</h2>
                    <a href="statistiques.php" class="btn btn-accent btn-sm">Détails</a>
                </div>
                <div class="card-body">
                    <div style="text-align: center; padding: 2rem;">
                        <?php
                        $performanceClass = 'performance-insuffisante';
                        if ($stats['performance'] === 'Excellente') {
                            $performanceClass = 'performance-excellent';
                        } elseif ($stats['performance'] === 'Satisfaisante') {
                            $performanceClass = 'performance-satisfaisante';
                        }
                        ?>
                        <div class="performance-badge <?php echo $performanceClass; ?>" style="margin-bottom: 2rem;">
                            <?php echo htmlspecialchars($stats['performance']); ?>
                        </div>
                        
                        <div style="display: grid; gap: 1.5rem; text-align: left;">
                            <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px;">
                                <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Vente Moyenne</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                                    <?php echo formatMontant($stats['vente_moyenne']); ?>
                                </div>
                            </div>
                            
                            <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px;">
                                <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Meilleure Vente</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                                    <?php echo formatMontant($stats['meilleure_vente']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Accès rapides -->
        <div class="card" style="margin-top: 2rem; animation-delay: 0.7s;">
            <div class="card-header">
                <h2 class="card-title">Accès Rapides</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-4">
                    <a href="clients.php" class="btn btn-primary" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Ajouter un client
                    </a>
                    
                    <a href="ventes.php" class="btn btn-accent" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouvelle vente
                    </a>
                    
                    <a href="employes.php" class="btn btn-primary" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter un employé
                    </a>
                    
                    <a href="statistiques.php" class="btn btn-secondary" style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Voir les stats
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <p>© 2026 Système de Gestion PME - Développé pour ISM Thiès</p>
    </footer>
</body>
</html>