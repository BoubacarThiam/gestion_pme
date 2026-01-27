<?php
require_once 'includes/config.php';
requireLogin();

$erreurs = [];
$succes = '';

// Traitement du formulaire d'ajout de vente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $client_id = intval($_POST['client_id'] ?? 0);
    $montant = floatval($_POST['montant'] ?? 0);
    $produit = trim($_POST['produit'] ?? '');
    
    // Validation
    if ($client_id <= 0) {
        $erreurs[] = 'Veuillez sélectionner un client.';
    }
    if ($montant <= 0) {
        $erreurs[] = 'Le montant doit être supérieur à zéro.';
    }
    validerChamp($produit, 'Produit/Service', $erreurs);
    
    if (empty($erreurs)) {
        // Trouver le nom du client
        $client = array_filter($_SESSION['clients'], fn($c) => $c['id'] === $client_id);
        $client = reset($client);
        
        if ($client) {
            $remise = calculerRemise($montant);
            $montant_final = calculerMontantFinal($montant, $remise);
            
            $nouvelleVente = [
                'id' => genererID($_SESSION['ventes']),
                'client_id' => $client_id,
                'client_nom' => $client['nom'],
                'montant' => $montant,
                'remise' => $remise,
                'montant_final' => $montant_final,
                'date' => date('Y-m-d'),
                'produit' => $produit
            ];
            
            $_SESSION['ventes'][] = $nouvelleVente;
            $succes = "Vente enregistrée avec succès ! Remise appliquée : {$remise}%";
            
            // Réinitialiser le formulaire
            $_POST = [];
        } else {
            $erreurs[] = 'Client introuvable.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Ventes - Gestion PME</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Calcul automatique de la remise et du montant final
        function calculerRemise() {
            const montant = parseFloat(document.getElementById('montant').value) || 0;
            let remise = 0;
            
            if (montant >= 100000) {
                remise = 10;
            } else if (montant >= 50000) {
                remise = 5;
            }
            
            const montantRemise = montant * (remise / 100);
            const montantFinal = montant - montantRemise;
            
            document.getElementById('remise-info').innerHTML = 
                `<strong>Remise : ${remise}%</strong> (-${montantRemise.toLocaleString('fr-FR')} FCFA)<br>` +
                `<strong style="color: var(--primary); font-size: 1.25rem;">Montant final : ${montantFinal.toLocaleString('fr-FR')} FCFA</strong>`;
        }
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="dashboard.php" class="nav-brand">
                <div class="nav-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
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
                <li><a href="ventes.php" class="nav-link active">
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
            <h1 class="page-title">Gestion des Ventes</h1>
            <p class="page-subtitle">Enregistrez vos ventes avec application automatique des remises</p>
        </div>
        
        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <?php foreach ($erreurs as $erreur): ?>
                        <div><?php echo htmlspecialchars($erreur); ?></div>
                    <?php endforeach; ?>
                </div>
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
        
        <div class="grid grid-2">
            <!-- Formulaire de vente -->
            <div class="card" style="animation-delay: 0.1s;">
                <div class="card-header">
                    <h2 class="card-title">Nouvelle Vente</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($_SESSION['clients'])): ?>
                        <div class="alert alert-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Aucun client disponible. <a href="clients.php" style="color: var(--accent-dark); font-weight: 700;">Ajoutez un client d'abord</a>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="ajouter">
                            
                            <div class="form-group">
                                <label class="form-label" for="client_id">Client *</label>
                                <select id="client_id" name="client_id" class="form-select" required>
                                    <option value="">-- Sélectionner un client --</option>
                                    <?php foreach ($_SESSION['clients'] as $client): ?>
                                        <option value="<?php echo $client['id']; ?>" <?php echo (isset($_POST['client_id']) && $_POST['client_id'] == $client['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($client['nom']) . ' (' . $client['type'] . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="produit">Produit / Service *</label>
                                <input 
                                    type="text" 
                                    id="produit" 
                                    name="produit" 
                                    class="form-input" 
                                    placeholder="Ex: Équipement informatique"
                                    value="<?php echo htmlspecialchars($_POST['produit'] ?? ''); ?>"
                                    required
                                >
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="montant">Montant (FCFA) *</label>
                                <input 
                                    type="number" 
                                    id="montant" 
                                    name="montant" 
                                    class="form-input" 
                                    placeholder="Ex: 75000"
                                    min="1"
                                    step="1"
                                    value="<?php echo htmlspecialchars($_POST['montant'] ?? ''); ?>"
                                    oninput="calculerRemise()"
                                    required
                                >
                            </div>
                            
                            <div id="remise-info" style="padding: 1rem; background: var(--gray-lighter); border-radius: 12px; margin-bottom: 1.5rem; text-align: center; color: var(--dark);">
                                Saisissez un montant pour voir la remise applicable
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Enregistrer la vente
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Politique de remises -->
            <div class="card" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <h2 class="card-title">Politique de Remises</h2>
                </div>
                <div class="card-body">
                    <p style="color: var(--gray); margin-bottom: 1.5rem;">
                        Les remises sont automatiquement appliquées selon le montant de la vente :
                    </p>
                    
                    <div style="display: grid; gap: 1rem;">
                        <div style="padding: 1.25rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; color: white;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">≥ 100 000 FCFA</div>
                                    <div style="font-size: 2rem; font-weight: 900;">10%</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.5;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                        
                        <div style="padding: 1.25rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; color: white;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">≥ 50 000 FCFA</div>
                                    <div style="font-size: 2rem; font-weight: 900;">5%</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.5;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                        
                        <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.25rem;">< 50 000 FCFA</div>
                                    <div style="font-size: 2rem; font-weight: 900; color: var(--dark);">0%</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity: 0.2;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem; padding: 1rem; background: #fef3c7; border-radius: 12px; color: #92400e; font-size: 0.875rem;">
                        <strong>💡 Astuce :</strong> Les remises sont calculées automatiquement lors de la saisie du montant.
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liste des ventes -->
        <div class="card" style="margin-top: 2rem; animation-delay: 0.3s;">
            <div class="card-header">
                <h2 class="card-title">Historique des Ventes (<?php echo count($_SESSION['ventes']); ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (empty($_SESSION['ventes'])): ?>
                    <div style="text-align: center; padding: 3rem; color: var(--gray);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin: 0 auto 1rem; opacity: 0.3;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p style="font-size: 1.125rem; font-weight: 600;">Aucune vente enregistrée</p>
                        <p>Commencez par enregistrer votre première vente</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Produit/Service</th>
                                    <th>Montant</th>
                                    <th>Remise</th>
                                    <th>Montant Final</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse($_SESSION['ventes']) as $vente): ?>
                                    <tr>
                                        <td><strong>#<?php echo $vente['id']; ?></strong></td>
                                        <td><strong><?php echo htmlspecialchars($vente['client_nom']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($vente['produit']); ?></td>
                                        <td><?php echo formatMontant($vente['montant']); ?></td>
                                        <td>
                                            <?php if ($vente['remise'] > 0): ?>
                                                <span class="badge badge-success"><?php echo $vente['remise']; ?>%</span>
                                            <?php else: ?>
                                                <span class="badge" style="background: var(--gray-light); color: var(--dark);">0%</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong style="color: var(--primary);"><?php echo formatMontant($vente['montant_final']); ?></strong></td>
                                        <td><?php echo date('d/m/Y', strtotime($vente['date'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <p>© 2026 Système de Gestion PME - Développé pour ISM Thiès</p>
    </footer>
</body>
</html>