<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Initialiser le tableau des employés
if (!isset($_SESSION['employes'])) {
    $_SESSION['employes'] = [];
}

$message = '';
$error = '';

// Services disponibles
$services = ['Commercial', 'Comptabilité', 'Ressources Humaines', 'Informatique', 'Direction', 'Logistique'];

// Traitement du formulaire d'ajout d'employé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = $_POST['service'] ?? '';
    $est_responsable = isset($_POST['est_responsable']) ? 1 : 0;
    
    // Validation
    if (empty($nom) || empty($prenom) || empty($telephone) || empty($service)) {
        $error = 'Veuillez remplir tous les champs obligatoires';
    } elseif (!in_array($service, $services)) {
        $error = 'Service invalide';
    } else {
        // Ajouter l'employé
        $employe = [
            'id' => count($_SESSION['employes']) + 1,
            'nom' => $nom,
            'prenom' => $prenom,
            'telephone' => $telephone,
            'email' => $email,
            'service' => $service,
            'est_responsable' => $est_responsable,
            'date_embauche' => date('Y-m-d H:i:s')
        ];
        
        $_SESSION['employes'][] = $employe;
        $message = 'Employé ajouté avec succès !';
        
        // Réinitialiser le formulaire
        $_POST = [];
    }
}

$employes = $_SESSION['employes'];
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
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>👔 Gestion des Employés</h1>
            <p>Ajouter et consulter vos employés</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h2>➕ Ajouter un nouvel employé</h2>
            <form method="POST" action="employes.php" class="form-horizontal">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" 
                               value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" 
                               value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" 
                               value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="service">Service *</label>
                        <select id="service" name="service" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($services as $srv): ?>
                                <option value="<?php echo $srv; ?>"><?php echo $srv; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="est_responsable" value="1">
                            <span>Responsable de service</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Ajouter l'employé</button>
            </form>
        </div>
        
        <div class="table-section">
            <h2>📋 Liste des employés (<?php echo count($employes); ?>)</h2>
            
            <?php if (empty($employes)): ?>
                <p class="no-data">Aucun employé enregistré pour le moment.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom complet</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Statut</th>
                                <th>Date d'embauche</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employes as $employe): ?>
                                <tr>
                                    <td><?php echo $employe['id']; ?></td>
                                    <td><?php echo htmlspecialchars($employe['nom'] . ' ' . $employe['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($employe['telephone']); ?></td>
                                    <td><?php echo htmlspecialchars($employe['email']); ?></td>
                                    <td><?php echo htmlspecialchars($employe['service']); ?></td>
                                    <td>
                                        <?php if ($employe['est_responsable']): ?>
                                            <span class="badge badge-warning">⭐ Responsable</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Employé</span>
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
</body>
</html>