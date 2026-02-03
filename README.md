# Système de Gestion Commerciale et Administrative - PME

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)

## 📋 Description du Projet

Application web de gestion commerciale et administrative développée pour une PME. Ce système permet d'automatiser et de centraliser la gestion des clients, des ventes, des employés et de générer des statistiques de performance pour faciliter la prise de décision.

**Projet académique** - LIAGE/ISM Thiès | SGBD & PHP

## 🎯 Objectifs

- Informatiser la gestion commerciale d'une PME
- Automatiser les décisions de gestion (remises commerciales, indicateurs de performance)
- Sécuriser l'accès aux données de l'entreprise
- Fournir des outils d'aide à la décision via un tableau de bord statistique

## ✨ Fonctionnalités

### 🔐 Authentification et Sécurité
- Système de connexion utilisateur/mot de passe
- Contrôle d'accès aux différents modules
- Déconnexion sécurisée
- Validation des données saisies

### 👥 Gestion des Clients
- Ajout de nouveaux clients
- Affichage de la liste complète des clients
- Segmentation client (Particulier/Professionnel)

### 💰 Gestion des Ventes
- Enregistrement des transactions (client, montant, date)
- Application automatique de remises commerciales :
  - ≥ 100 000 FCFA : 10% de remise
  - ≥ 50 000 FCFA : 5% de remise
  - < 50 000 FCFA : aucune remise

### 👔 Gestion des Employés
- Ajout d'employés
- Attribution par service
- Identification des responsables

### 📊 Tableau de Bord
- Chiffre d'affaires total
- Vente moyenne
- Meilleure vente
- Évaluation automatique de la performance (satisfaisante/insuffisante)

## 🛠️ Technologies Utilisées

- **Frontend** : HTML5, CSS3
- **Backend** : PHP
- **Serveur local** : XAMPP / WAMP / MAMP
- **Stockage** : Tableaux PHP (sans base de données)

## 📁 Structure du Projet

```
gestion_pme/
│
├── index.php              # Page d'accueil
├── login.php              # Authentification
├── dashboard.php          # Tableau de bord
├── clients.php            # Gestion clients
├── ventes.php             # Gestion ventes
├── employes.php           # Gestion employés
├── statistiques.php       # Statistiques et indicateurs
├── logout.php             # Déconnexion
│
└── css/
    └── style.css          # Feuille de style
```

## 🚀 Installation et Utilisation

### Prérequis
- XAMPP, WAMP ou MAMP installé
- PHP 7.4 ou supérieur

### Installation

1. **Cloner le dépôt**
```bash
git clone https://github.com/votre-username/gestion-pme.git
```

2. **Déplacer le projet dans le dossier serveur**
```bash
# Pour XAMPP
mv gestion-pme /opt/lampp/htdocs/

# Pour WAMP
mv gestion-pme C:/wamp64/www/

# Pour MAMP
mv gestion-pme /Applications/MAMP/htdocs/
```

3. **Démarrer le serveur local**
- Lancer XAMPP/WAMP/MAMP
- Démarrer Apache

4. **Accéder à l'application**
```
http://localhost/gestion-pme
```

### Connexion par défaut
```
Utilisateur : admin
Mot de passe : admin123
```


## 📝 Licence

Ce projet est développé à des fins pédagogiques dans le cadre d'un projet académique.

## 🙏 Remerciements

- M. SARR - Enseignant SGBD/PHP
- Institut LIAGE/ISM Thiès

---

**Date de livraison** : 02 février 2026

**Note** : Ce projet démontre l'application pratique des concepts de gestion commerciale et de développement web pour répondre aux besoins réels d'une PME.
