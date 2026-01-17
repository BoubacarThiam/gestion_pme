<?php
session_start();

// Simulation de la base de données
if (!isset($_SESSION['clients'])) {
    $_SESSION['clients'] = [
        ['id' => 1, 'nom' => 'Diarra Consulting', 'type' => 'Professionnel'],
        ['id' => 2, 'nom' => 'Moussa Ndiaye', 'type' => 'Particulier']
    ];
}

if (!isset($_SESSION['ventes'])) {
    $_SESSION['ventes'] = [
        ['client_id' => 1, 'montant_brut' => 120000, 'date' => '2026-01-01', 'remise' => 12000],
    ];
}

// Fonction de calcul de remise automatique [cite: 61, 63]
function calculerRemise($montant) {
    if ($montant >= 100000) return 0.10; // 10% [cite: 63]
    if ($montant >= 50000) return 0.05;  // 5% [cite: 63]
    return 0; // 0% [cite: 63]
}
?>