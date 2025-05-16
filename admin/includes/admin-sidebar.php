<aside class="admin-sidebar">
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' || basename($_SERVER['PHP_SELF']) == 'add-product.php' || basename($_SERVER['PHP_SELF']) == 'edit-product.php' ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i>
                    <span>Produtos</span>
                </a>
            </li>
            <li>
                <a href="categories.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i>
                    <span>Categorias</span>
                </a>
            </li>
            <li>
                <a href="messages.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' || basename($_SERVER['PHP_SELF']) == 'view-message.php' ? 'active' : ''; ?>">
                    <i class="fas fa-envelope"></i>
                    <span>Mensagens</span>
                </a>
            </li>
            <li>
                <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                    <i class="fas fa-cog"></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>