<?php
/**
 * Configuration et Gestion des Données
 * Système de Gestion Commerciale PME
 */

session_start();

// Utilisateurs du système
$users = [
    ['username' => 'admin', 'password' => 'admin123', 'role' => 'Administrateur'],
    ['username' => 'gestionnaire', 'password' => 'gest123', 'role' => 'Gestionnaire'],
    ['username' => 'vendeur', 'password' => 'vend123', 'role' => 'Vendeur']
];

// Fonction de vérification de connexion
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Fonction de redirection si non connecté
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Fonction de déconnexion
function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Initialisation des données en session
function initializeData() {
    if (!isset($_SESSION['clients'])) {
        $_SESSION['clients'] = [
            [
                'id' => 1,
                'nom' => 'Amadou Diop',
                'type' => 'Particulier',
                'telephone' => '77 123 45 67',
                'email' => 'adiop@email.com',
                'date_ajout' => '2025-01-15'
            ],
            [
                'id' => 2,
                'nom' => 'SEN Entreprise SARL',
                'type' => 'Professionnel',
                'telephone' => '33 821 45 67',
                'email' => 'contact@senentreprise.sn',
                'date_ajout' => '2025-01-20'
            ]
        ];
    }
    
    if (!isset($_SESSION['ventes'])) {
        $_SESSION['ventes'] = [
            [
                'id' => 1,
                'client_id' => 1,
                'client_nom' => 'Amadou Diop',
                'montant' => 75000,
                'remise' => 5,
                'montant_final' => 71250,
                'date' => '2025-01-25',
                'produit' => 'Équipement informatique'
            ],
            [
                'id' => 2,
                'client_id' => 2,
                'client_nom' => 'SEN Entreprise SARL',
                'montant' => 150000,
                'remise' => 10,
                'montant_final' => 135000,
                'date' => '2025-01-26',
                'produit' => 'Fournitures de bureau'
            ]
        ];
    }
    
    if (!isset($_SESSION['employes'])) {
        $_SESSION['employes'] = [
            [
                'id' => 1,
                'nom' => 'Fatou Sall',
                'service' => 'Commercial',
                'poste' => 'Responsable Commercial',
                'est_responsable' => true,
                'telephone' => '77 234 56 78',
                'date_embauche' => '2024-03-15'
            ],
            [
                'id' => 2,
                'nom' => 'Ibrahima Ndiaye',
                'service' => 'Comptabilité',
                'poste' => 'Comptable',
                'est_responsable' => false,
                'telephone' => '77 345 67 89',
                'date_embauche' => '2024-06-01'
            ],
            [
                'id' => 3,
                'nom' => 'Awa Thiam',
                'service' => 'Commercial',
                'poste' => 'Vendeuse',
                'est_responsable' => false,
                'telephone' => '77 456 78 90',
                'date_embauche' => '2024-09-10'
            ]
        ];
    }
}

// Fonction de calcul de remise
function calculerRemise($montant) {
    if ($montant >= 100000) {
        return 10;
    } elseif ($montant >= 50000) {
        return 5;
    } else {
        return 0;
    }
}

// Fonction de calcul du montant final
function calculerMontantFinal($montant, $remise) {
    return $montant - ($montant * $remise / 100);
}

// Fonction de formatage des montants
function formatMontant($montant) {
    return number_format($montant, 0, ',', ' ') . ' FCFA';
}

// Fonction de validation des données
function validerChamp($valeur, $nom, &$erreurs) {
    if (empty(trim($valeur))) {
        $erreurs[] = "Le champ '$nom' est obligatoire.";
        return false;
    }
    return true;
}

// Fonction de génération d'ID
function genererID($tableau) {
    if (empty($tableau)) return 1;
    $ids = array_column($tableau, 'id');
    return max($ids) + 1;
}

// Fonction de calcul des statistiques
function calculerStatistiques() {
    if (!isset($_SESSION['ventes']) || empty($_SESSION['ventes'])) {
        return [
            'ca_total' => 0,
            'vente_moyenne' => 0,
            'meilleure_vente' => 0,
            'nombre_ventes' => 0,
            'performance' => 'Aucune vente'
        ];
    }
    
    $montants = array_column($_SESSION['ventes'], 'montant_final');
    $ca_total = array_sum($montants);
    $nombre_ventes = count($montants);
    $vente_moyenne = $ca_total / $nombre_ventes;
    $meilleure_vente = max($montants);
    
    // Appréciation de la performance
    if ($vente_moyenne >= 100000) {
        $performance = 'Excellente';
    } elseif ($vente_moyenne >= 50000) {
        $performance = 'Satisfaisante';
    } else {
        $performance = 'Insuffisante';
    }
    
    return [
        'ca_total' => $ca_total,
        'vente_moyenne' => $vente_moyenne,
        'meilleure_vente' => $meilleure_vente,
        'nombre_ventes' => $nombre_ventes,
        'performance' => $performance
    ];
}

// Initialiser les données au démarrage
initializeData();
?>