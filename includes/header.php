<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <h1>🏢 Gestion PME</h1>
        </div>
        
        <nav class="main-nav">
            <a href="dashboard.php" class="nav-link">📊 Tableau de bord</a>
            <a href="clients.php" class="nav-link">👥 Clients</a>
            <a href="ventes.php" class="nav-link">💰 Ventes</a>
            <a href="employes.php" class="nav-link">👔 Employés</a>
            <a href="statistiques.php" class="nav-link">📈 Statistiques</a>
        </nav>
        
        <div class="user-menu">
            <span class="user-name">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="btn btn-logout">Déconnexion</a>
        </div>
    </div>
</header>