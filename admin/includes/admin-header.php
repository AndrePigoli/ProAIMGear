<header class="admin-header">
    <div class="admin-logo">
        <a href="index.php">
            <img src="../assets/images/logo.png" alt="ProAim Gear">
            <span>Admin</span>
        </a>
    </div>
    
    <div class="admin-actions">
        <a href="../index.php" target="_blank" class="view-site-btn">
            <i class="fas fa-external-link-alt"></i> Visualizar Site
        </a>
        
        <div class="admin-user-dropdown">
            <button class="admin-user-btn">
                <i class="fas fa-user-circle"></i>
                <span><?php echo $_SESSION['admin_username']; ?></span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </div>
    </div>
</header>