<?php
require_once 'includes/config.php';
requireLogin();

$erreurs = [];
$succes = '';

// Traitement du formulaire d'ajout d'employé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $nom = trim($_POST['nom'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $poste = trim($_POST['poste'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $est_responsable = isset($_POST['est_responsable']) ? true : false;
    
    // Validation
    validerChamp($nom, 'Nom', $erreurs);
    validerChamp($service, 'Service', $erreurs);
    validerChamp($poste, 'Poste', $erreurs);
    validerChamp($telephone, 'Téléphone', $erreurs);
    
    if (empty($erreurs)) {
        $nouvelEmploye = [
            'id' => genererID($_SESSION['employes']),
            'nom' => $nom,
            'service' => $service,
            'poste' => $poste,
            'telephone' => $telephone,
            'est_responsable' => $est_responsable,
            'date_embauche' => date('Y-m-d')
        ];
        
        $_SESSION['employes'][] = $nouvelEmploye;
        $succes = "Employé ajouté avec succès !";
        
        // Réinitialiser le formulaire
        $_POST = [];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés - Gestion PME</title>
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="ventes.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Ventes
                </a></li>
                <li><a href="employes.php" class="nav-link active">
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
            <h1 class="page-title">Gestion des Employés</h1>
            <p class="page-subtitle">Gérez votre équipe et l'organisation interne</p>
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
            <!-- Formulaire d'ajout -->
            <div class="card" style="animation-delay: 0.1s;">
                <div class="card-header">
                    <h2 class="card-title">Ajouter un Employé</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="ajouter">
                        
                        <div class="form-group">
                            <label class="form-label" for="nom">Nom complet *</label>
                            <input 
                                type="text" 
                                id="nom" 
                                name="nom" 
                                class="form-input" 
                                placeholder="Ex: Fatou Sall"
                                value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="service">Service *</label>
                            <select id="service" name="service" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="Commercial" <?php echo (isset($_POST['service']) && $_POST['service'] === 'Commercial') ? 'selected' : ''; ?>>
                                    Commercial
                                </option>
                                <option value="Comptabilité" <?php echo (isset($_POST['service']) && $_POST['service'] === 'Comptabilité') ? 'selected' : ''; ?>>
                                    Comptabilité
                                </option>
                                <option value="Ressources Humaines" <?php echo (isset($_POST['service']) && $_POST['service'] === 'Ressources Humaines') ? 'selected' : ''; ?>>
                                    Ressources Humaines
                                </option>
                                <option value="Logistique" <?php echo (isset($_POST['service']) && $_POST['service'] === 'Logistique') ? 'selected' : ''; ?>>
                                    Logistique
                                </option>
                                <option value="Direction" <?php echo (isset($_POST['service']) && $_POST['service'] === 'Direction') ? 'selected' : ''; ?>>
                                    Direction
                                </option>
                                <option value="Autre" <?php echo (isset($_POST['service']) && $_POST['service'] === 'Autre') ? 'selected' : ''; ?>>
                                    Autre
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="poste">Poste *</label>
                            <input 
                                type="text" 
                                id="poste" 
                                name="poste" 
                                class="form-input" 
                                placeholder="Ex: Responsable Commercial"
                                value="<?php echo htmlspecialchars($_POST['poste'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="telephone">Téléphone *</label>
                            <input 
                                type="tel" 
                                id="telephone" 
                                name="telephone" 
                                class="form-input" 
                                placeholder="Ex: 77 234 56 78"
                                value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group" style="display: flex; align-items: center; gap: 0.75rem;">
                            <input 
                                type="checkbox" 
                                id="est_responsable" 
                                name="est_responsable"
                                style="width: 20px; height: 20px; cursor: pointer;"
                                <?php echo (isset($_POST['est_responsable'])) ? 'checked' : ''; ?>
                            >
                            <label for="est_responsable" style="cursor: pointer; margin: 0; font-weight: 600; color: var(--dark);">
                                Cet employé est un responsable
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ajouter l'employé
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="card" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <h2 class="card-title">Organigramme</h2>
                </div>
                <div class="card-body">
                    <?php
                    $total_employes = count($_SESSION['employes']);
                    $responsables = count(array_filter($_SESSION['employes'], fn($e) => $e['est_responsable']));
                    $employes_par_service = [];
                    foreach ($_SESSION['employes'] as $emp) {
                        $service = $emp['service'];
                        if (!isset($employes_par_service[$service])) {
                            $employes_par_service[$service] = 0;
                        }
                        $employes_par_service[$service]++;
                    }
                    ?>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <div style="padding: 1.5rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 16px; color: white;">
                            <div style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; opacity: 0.9;">
                                Total Employés
                            </div>
                            <div style="font-family: var(--font-display); font-size: 3rem; font-weight: 900;">
                                <?php echo $total_employes; ?>
                            </div>
                        </div>
                        
                        <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Responsables
                                </div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                                    <?php echo $responsables; ?>
                                </div>
                            </div>
                            <div style="height: 8px; background: rgba(245, 158, 11, 0.2); border-radius: 4px; overflow: hidden;">
                                <div style="height: 100%; width: <?php echo $total_employes > 0 ? ($responsables / $total_employes * 100) : 0; ?>%; background: var(--accent);"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                                Répartition par Service
                            </div>
                            <div style="display: grid; gap: 0.75rem;">
                                <?php foreach ($employes_par_service as $service => $count): ?>
                                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: var(--gray-lighter); border-radius: 8px;">
                                        <span style="font-weight: 600;"><?php echo htmlspecialchars($service); ?></span>
                                        <span class="badge badge-primary"><?php echo $count; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liste des employés -->
        <div class="card" style="margin-top: 2rem; animation-delay: 0.3s;">
            <div class="card-header">
                <h2 class="card-title">Liste des Employés (<?php echo count($_SESSION['employes']); ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (empty($_SESSION['employes'])): ?>
                    <div style="text-align: center; padding: 3rem; color: var(--gray);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin: 0 auto 1rem; opacity: 0.3;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <p style="font-size: 1.125rem; font-weight: 600;">Aucun employé enregistré</p>
                        <p>Commencez par ajouter votre premier employé</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Service</th>
                                    <th>Poste</th>
                                    <th>Téléphone</th>
                                    <th>Responsable</th>
                                    <th>Date d'embauche</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse($_SESSION['employes']) as $employe): ?>
                                    <tr>
                                        <td><strong>#<?php echo $employe['id']; ?></strong></td>
                                        <td><strong><?php echo htmlspecialchars($employe['nom']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($employe['service']); ?></td>
                                        <td><?php echo htmlspecialchars($employe['poste']); ?></td>
                                        <td><?php echo htmlspecialchars($employe['telephone']); ?></td>
                                        <td>
                                            <?php if ($employe['est_responsable']): ?>
                                                <span class="badge badge-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; vertical-align: middle;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                    </svg>
                                                    Responsable
                                                </span>
                                            <?php else: ?>
                                                <span class="badge" style="background: var(--gray-light); color: var(--dark);">Employé</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($employe['date_embauche'])); ?></td>
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