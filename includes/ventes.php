<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Initialiser les tableaux
if (!isset($_SESSION['ventes'])) {
    $_SESSION['ventes'] = [];
}
if (!isset($_SESSION['clients'])) {
    $_SESSION['clients'] = [];
}

$message = '';
$error = '';

// Fonction pour calculer la remise
function calculerRemise($montant) {
    if ($montant >= 100000) {
        return 10; // 10%
    } elseif ($montant >= 50000) {
        return 5; // 5%
    }
    return 0; // 0%
}

// Traitement du formulaire d'ajout de vente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = intval($_POST['client_id'] ?? 0);
    $montant = floatval($_POST['montant'] ?? 0);
    $date_vente = $_POST['date_vente'] ?? date('Y-m-d');
    $description = trim($_POST['description'] ?? '');
    
    // Validation
    if ($client_id <= 0 || $montant <= 0) {
        $error = 'Veuillez remplir tous les champs obligatoires avec des valeurs valides';
    } elseif (empty($date_vente)) {
        $error = 'La date de vente est obligatoire';
    } else {
        // Calculer la remise
        $taux_remise = calculerRemise($montant);
        $montant_remise = $montant * ($taux_remise / 100);
        $montant_final = $montant - $montant_remise;
        
        // Trouver le client
        $client = null;
        foreach ($_SESSION['clients'] as $c) {
            if ($c['id'] == $client_id) {
                $client = $c;
                break;
            }
        }
        
        // Ajouter la vente
        $vente = [
            'id' => count($_SESSION['ventes']) + 1,
            'client_id' => $client_id,
            'client_nom' => $client ? $client['nom'] . ' ' . $client['prenom'] : 'Inconnu',
            'montant_initial' => $montant,
            'taux_remise' => $taux_remise,
            'montant_remise' => $montant_remise,
            'montant_final' => $montant_final,
            'date_vente' => $date_vente,
            'description' => $description,
            'date_enregistrement' => date('Y-m-d H:i:s')
        ];
        
        $_SESSION['ventes'][] = $vente;
        $message = "Vente enregistrée avec succès ! Remise appliquée : {$taux_remise}%";
        
        // Réinitialiser le formulaire
        $_POST = [];
    }
}

$ventes = $_SESSION['ventes'];
$clients = $_SESSION['clients'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Ventes - Gestion PME</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>💰 Gestion des Ventes</h1>
            <p>Enregistrer et consulter les ventes</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h2>➕ Enregistrer une nouvelle vente</h2>
            
            <?php if (empty($clients)): ?>
                <div class="alert alert-warning">
                    Vous devez d'abord ajouter des clients. 
                    <a href="clients.php">Ajouter un client →</a>
                </div>
            <?php else: ?>
                <form method="POST" action="ventes.php" class="form-horizontal">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_id">Client *</label>
                            <select id="client_id" name="client_id" required>
                                <option value="">-- Sélectionner un client --</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?php echo $client['id']; ?>">
                                        <?php echo htmlspecialchars($client['nom'] . ' ' . $client['prenom']); ?>
                                        (<?php echo $client['type']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="date_vente">Date de vente *</label>
                            <input type="date" id="date_vente" name="date_vente" 
                                   value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="montant">Montant (FCFA) *</label>
                        <input type="number" id="montant" name="montant" 
                               step="0.01" min="0" required>
                        <small class="form-help">
                            Remises automatiques : 10% pour ≥100 000 FCFA | 5% pour ≥50 000 FCFA
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enregistrer la vente</button>
                </form>
            <?php endif; ?>
        </div>
        
        <div class="table-section">
            <h2>📋 Liste des ventes (<?php echo count($ventes); ?>)</h2>
            
            <?php if (empty($ventes)): ?>
                <p class="no-data">Aucune vente enregistrée pour le moment.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Montant initial</th>
                                <th>Remise</th>
                                <th>Montant final</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($ventes) as $vente): ?>
                                <tr>
                                    <td><?php echo $vente['id']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($vente['date_vente'])); ?></td>
                                    <td><?php echo htmlspecialchars($vente['client_nom']); ?></td>
                                    <td><?php echo number_format($vente['montant_initial'], 0, ',', ' '); ?> FCFA</td>
                                    <td>
                                        <?php if ($vente['taux_remise'] > 0): ?>
                                            <span class="badge badge-success"><?php echo $vente['taux_remise']; ?>%</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">0%</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="highlight"><?php echo number_format($vente['montant_final'], 0, ',', ' '); ?> FCFA</td>
                                    <td><?php echo htmlspecialchars($vente['description']); ?></td>
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