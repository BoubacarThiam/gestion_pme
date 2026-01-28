<?php
require_once 'includes/config.php';
requireLogin();

$erreurs = [];
$succes = '';

// Traitement du formulaire d'ajout de client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $nom = trim($_POST['nom'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    // Validation
    validerChamp($nom, 'Nom', $erreurs);
    validerChamp($type, 'Type de client', $erreurs);
    validerChamp($telephone, 'Téléphone', $erreurs);
    validerChamp($email, 'Email', $erreurs);
    
    if (empty($erreurs)) {
        $nouveauClient = [
            'id' => genererID($_SESSION['clients']),
            'nom' => $nom,
            'type' => $type,
            'telephone' => $telephone,
            'email' => $email,
            'date_ajout' => date('Y-m-d')
        ];
        
        $_SESSION['clients'][] = $nouveauClient;
        $succes = "Client ajouté avec succès !";
        
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
    <title>Gestion des Clients - Gestion PME</title>
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
                <li><a href="clients.php" class="nav-link active">
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
            <h1 class="page-title">Gestion des Clients</h1>
            <p class="page-subtitle">Gérez votre portefeuille clients et leur segmentation</p>
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
                    <h2 class="card-title">Ajouter un Client</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="ajouter">
                        
                        <div class="form-group">
                            <label class="form-label" for="nom">Nom du client *</label>
                            <input 
                                type="text" 
                                id="nom" 
                                name="nom" 
                                class="form-input" 
                                placeholder="Ex: Amadou Diop ou SEN Entreprise SARL"
                                value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="type">Type de client *</label>
                            <select id="type" name="type" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="Particulier" <?php echo (isset($_POST['type']) && $_POST['type'] === 'Particulier') ? 'selected' : ''; ?>>
                                    Particulier
                                </option>
                                <option value="Professionnel" <?php echo (isset($_POST['type']) && $_POST['type'] === 'Professionnel') ? 'selected' : ''; ?>>
                                    Professionnel
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="telephone">Téléphone *</label>
                            <input 
                                type="tel" 
                                id="telephone" 
                                name="telephone" 
                                class="form-input" 
                                placeholder="Ex: 77 123 45 67"
                                value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="email">Email *</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="Ex: contact@exemple.sn"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ajouter le client
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Statistiques clients -->
            <div class="card" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <h2 class="card-title">Statistiques Clients</h2>
                </div>
                <div class="card-body">
                    <?php
                    $total_clients = count($_SESSION['clients']);
                    $particuliers = count(array_filter($_SESSION['clients'], fn($c) => $c['type'] === 'Particulier'));
                    $professionnels = count(array_filter($_SESSION['clients'], fn($c) => $c['type'] === 'Professionnel'));
                    ?>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <div style="padding: 1.5rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 16px; color: white;">
                            <div style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; opacity: 0.9;">
                                Total Clients
                            </div>
                            <div style="font-family: var(--font-display); font-size: 3rem; font-weight: 900;">
                                <?php echo $total_clients; ?>
                            </div>
                        </div>
                        
                        <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem;">
                                        Particuliers
                                    </div>
                                    <div style="font-size: 1.75rem; font-weight: 700; color: var(--primary);">
                                        <?php echo $particuliers; ?>
                                    </div>
                                </div>
                                <div class="badge badge-primary" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                    <?php echo $total_clients > 0 ? round(($particuliers / $total_clients) * 100) : 0; ?>%
                                </div>
                            </div>
                        </div>
                        
                        <div style="padding: 1.25rem; background: var(--gray-lighter); border-radius: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="color: var(--gray); font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem;">
                                        Professionnels
                                    </div>
                                    <div style="font-size: 1.75rem; font-weight: 700; color: var(--accent);">
                                        <?php echo $professionnels; ?>
                                    </div>
                                </div>
                                <div class="badge badge-warning" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                    <?php echo $total_clients > 0 ? round(($professionnels / $total_clients) * 100) : 0; ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liste des clients -->
        <div class="card" style="margin-top: 2rem; animation-delay: 0.3s;">
            <div class="card-header">
                <h2 class="card-title">Liste des Clients (<?php echo count($_SESSION['clients']); ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (empty($_SESSION['clients'])): ?>
                    <div style="text-align: center; padding: 3rem; color: var(--gray);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin: 0 auto 1rem; opacity: 0.3;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p style="font-size: 1.125rem; font-weight: 600;">Aucun client enregistré</p>
                        <p>Commencez par ajouter votre premier client</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Date d'ajout</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse($_SESSION['clients']) as $client): ?>
                                    <tr>
                                        <td><strong>#<?php echo $client['id']; ?></strong></td>
                                        <td><strong><?php echo htmlspecialchars($client['nom']); ?></strong></td>
                                        <td>
                                            <?php if ($client['type'] === 'Particulier'): ?>
                                                <span class="badge badge-info">Particulier</span>
                                            <?php else: ?>
                                                <span class="badge badge-primary">Professionnel</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                                        <td><?php echo htmlspecialchars($client['email']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($client['date_ajout'])); ?></td>
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