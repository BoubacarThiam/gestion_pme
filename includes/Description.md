# 🏢 Système de Gestion Commerciale et Administrative d'une PME

## 📋 À propos du projet

Ce projet consiste en une application web de gestion commerciale et administrative développée dans le cadre du cours SGBD/PHP à l'ISM-THIES. Il vise à automatiser les opérations de gestion d'une PME commerciale : suivi des clients, contrôle des ventes, évaluation de la performance et sécurisation de l'accès aux informations.



**Encadrant :** M. SARR  
**Formation :** LIAGE - ISM-THIES  
**Date de réalisation :** [2026]

---

## 🎯 Objectifs du projet

- Comprendre l'utilité de l'informatique dans la gestion d'entreprise
- Automatiser certaines décisions de gestion
- Utiliser PHP et HTML de manière pratique
- Analyser des données commerciales
- Produire un outil d'aide à la décision

---

## 🛠️ Technologies utilisées

| Technologie | Utilisation |
|------------|-------------|
| **PHP** | Logique métier et traitement des données |
| **HTML** | Structure des pages web |
| **CSS** | Présentation et design |
| **XAMPP** | Serveur local de développement |

> **Note :** Ce projet n'utilise pas de base de données. Les données sont stockées dans des tableaux PHP (sessions).

---

## 📂 Structure du projet

```
gestion_pme/
│
├── index.php              # Page d'accueil
├── login.php              # Authentification
├── dashboard.php          # Tableau de bord principal
├── clients.php            # Gestion des clients
├── ventes.php             # Gestion des ventes
├── employes.php           # Gestion des employés
├── statistiques.php       # Statistiques et analyses
├── logout.php             # Déconnexion
│
└── css/
    └── style.css          # Feuille de styles
```

---

## ⚙️ Fonctionnalités

### 🔐 Module 1 : Authentification
- Formulaire de connexion sécurisé
- Vérification utilisateur/mot de passe
- Gestion des sessions
- Déconnexion

**Identifiants par défaut :**
- **Utilisateur :** admin
- **Mot de passe :** admin123

### 👤 Module 2 : Gestion des Clients
- Ajout de clients via formulaire
- Affichage de la liste complète des clients
- Distinction entre types de clients :
  - Particulier
  - Professionnel

### 💰 Module 3 : Gestion des Ventes
- Enregistrement des ventes (client, montant, date)
- Application automatique des remises :

| Montant de la vente | Remise appliquée |
|---------------------|------------------|
| ≥ 100 000 FCFA | 10% |
| ≥ 50 000 FCFA | 5% |
| < 50 000 FCFA | 0% |

- Calcul automatique du montant net après remise

### 👔 Module 4 : Gestion des Employés
- Ajout d'employés
- Précision du service d'affectation
- Identification des responsables

### 📊 Module 5 : Tableau de Bord et Statistiques
Indicateurs de performance :
- **Chiffre d'affaires total**
- **Vente moyenne**
- **Meilleure vente**
- **Appréciation automatique de la performance** (satisfaisante/insuffisante)

### 🛡️ Module 6 : Sécurité et Validation
- Validation des champs obligatoires
- Messages d'erreur clairs et explicites
- Protection contre les saisies incorrectes
- Contrôle d'accès par session

---

## 🚀 Installation et démarrage

### Prérequis
- XAMPP (ou WAMP/LAMP) installé sur votre machine
- Navigateur web moderne (Chrome, Firefox, Edge)

### Étapes d'installation

1. **Télécharger le projet**
   ```bash
   # Clonez ou téléchargez le projet dans le dossier htdocs de XAMPP
   cd C:/xampp/htdocs/
   ```

2. **Démarrer XAMPP**
   - Lancez XAMPP Control Panel
   - Démarrez Apache

3. **Accéder à l'application**
   - Ouvrez votre navigateur
   - Accédez à : `http://localhost/gestion_pme/`

4. **Se connecter**
   - Utilisez les identifiants par défaut (voir section Authentification)

---

## 📖 Guide d'utilisation

### 1️⃣ Connexion
- Accédez à la page de connexion
- Saisissez vos identifiants
- Cliquez sur "Se connecter"

### 2️⃣ Ajout d'un client
- Accédez au menu "Clients"
- Remplissez le formulaire (nom, type)
- Cliquez sur "Ajouter"

### 3️⃣ Enregistrement d'une vente
- Accédez au menu "Ventes"
- Sélectionnez un client
- Saisissez le montant
- La remise est appliquée automatiquement
- Cliquez sur "Enregistrer"

### 4️⃣ Consultation des statistiques
- Accédez au menu "Statistiques"
- Consultez les indicateurs de performance
- Visualisez l'appréciation automatique

### 5️⃣ Déconnexion
- Cliquez sur "Déconnexion" dans le menu

---

## 🔒 Sécurité

Le système intègre plusieurs mécanismes de sécurité :
- Authentification obligatoire
- Gestion des sessions PHP
- Validation des données saisies
- Protection contre les accès non autorisés
- Messages d'erreur sécurisés

---

## 📊 Contexte de gestion

Ce projet répond aux besoins réels d'une PME :

| Module | Enjeu de gestion |
|--------|------------------|
| Authentification | Contrôle interne, confidentialité |
| Clients | Relation client, segmentation |
| Ventes | Politique commerciale |
| Employés | Organisation, ressources humaines |
| Statistiques | Aide à la décision |
| Sécurité | Fiabilité de l'information |

---

## ⚠️ Limitations et perspectives

### Limitations actuelles
- Données stockées en session (perte à la déconnexion)
- Pas de persistance des données
- Interface basique

### Perspectives d'amélioration
- Intégration d'une base de données MySQL
- Export des données (PDF, Excel)
- Graphiques de visualisation
- Interface responsive mobile
- Gestion avancée des stocks
- Module de facturation

---



## 🎓 Contexte académique

**Cours :** SGBD/PHP  
**Établissement :** ISM-THIES  
**Programme :** LIAGE  
**Date limite :** 02 février 2026



---

## 📞 Contact et support

Pour toute question ou problème :
- **Email :** [boubacarthiam005@icoud.com]
- **Encadrant :** M. SARR

---

## 📜 Licence

Ce projet est réalisé dans un cadre pédagogique à l'ISM-THIES.  
Tous droits réservés © 2026

---

**Développé avec 💙 par l'équipe [Nom du groupe]**