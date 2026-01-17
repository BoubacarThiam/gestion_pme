<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Initialiser le tableau des clients s'il n'existe pas
if (!isset($_SESSION['clients'])) {
    $_SESSION['clients'] = [];
}

$message = '';
$error = '';

// Traitement du formulaire d'ajout de client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $type = $_POST['type'] ?? '';
    
    // Validation
    if (empty($nom) || empty($prenom) || empty($telephone) || empty($type)) {
        $error = 'Veuillez remplir tous les champs obligatoires';
    } elseif (!in_array($type, ['Particulier', 'Professionnel'])) {
        $error = 'Type de client invalide';
    } else {
        // Ajouter le client
        $client = [
            'id' => count($_SESSION['clients']) + 1,
            'nom' => $nom,
            'prenom' => $prenom,
            'telephone' => $telephone,
            'email' => $email,
            'type' => $type,
            'date_ajout' => date('Y-m-d H:i:s')
        ];
        
        $_SESSION['clients'][] = $client;
        $message = 'Client ajouté avec succès !';
        
        // Réinitialiser le formulaire
        $_POST = [];
    }
}

$clients = $_SESSION['clients'];
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
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>👥 Gestion des Clients</h1>
            <p>Ajouter et consulter vos clients</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h2>➕ Ajouter un nouveau client</h2>
            <form method="POST" action="clients.php" class="form-horizontal">
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
                
                <div class="form-group">
                    <label for="type">Type de client *</label>
                    <select id="type" name="type" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Particulier">Particulier</option>
                        <option value="Professionnel">Professionnel</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Ajouter le client</button>
            </form>
        </div>
        
        <div class="table-section">
            <h2>📋 Liste des clients (<?php echo count($clients); ?>)</h2>
            
            <?php if (empty($clients)): ?>
                <p class="no-data">Aucun client enregistré pour le moment.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom complet</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Date d'ajout</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?php echo $client['id']; ?></td>
                                    <td><?php echo htmlspecialchars($client['nom'] . ' ' . $client['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                                    <td><?php echo htmlspecialchars($client['email']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $client['type'] === 'Professionnel' ? 'badge-info' : 'badge-primary'; ?>">
                                            <?php echo $client['type']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($client['date_ajout'])); ?></td>
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