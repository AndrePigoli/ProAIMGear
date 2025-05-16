<header class="main-header">
    <div class="container header-container">
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo.png" alt="ProAim Gear">
            </a>
        </div>
        
        <nav class="main-nav">
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Produtos</a></li>
                <li class="dropdown">
                    <a href="products.php">Categorias <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        $cat_query = "SELECT * FROM categories ORDER BY name";
                        $cat_result = mysqli_query($conn, $cat_query);
                        
                        while($category = mysqli_fetch_assoc($cat_result)) {
                            echo "<li><a href='products.php?category={$category['id']}'>{$category['name']}</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="contact.php">Contato</a></li>
            </ul>
        </nav>
        
        <div class="header-actions">
            <div class="search-box">
                <input type="text" placeholder="Buscar produtos..." id="search-input">
                <button class="search-btn"><i class="fas fa-search"></i></button>
            </div>
            
            <a href="cart.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
                <?php endif; ?>
            </a>
            
            <button class="mobile-menu-btn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<div class="mobile-menu">
    <div class="mobile-menu-header">
        <div class="logo">
            <img src="assets/images/logo.png" alt="ProAim Gear">
        </div>
        <button class="close-menu-btn"><i class="fas fa-times"></i></button>
    </div>
    
    <div class="mobile-search">
        <input type="text" placeholder="Buscar produtos..." id="mobile-search-input">
        <button class="search-btn"><i class="fas fa-search"></i></button>
    </div>
    
    <ul class="mobile-nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Produtos</a></li>
        <li class="mobile-dropdown">
            <a href="#" class="mobile-dropdown-toggle">Categorias <i class="fas fa-chevron-down"></i></a>
            <ul class="mobile-dropdown-menu">
                <?php
                mysqli_data_seek($cat_result, 0);
                while($category = mysqli_fetch_assoc($cat_result)) {
                    echo "<li><a href='products.php?category={$category['id']}'>{$category['name']}</a></li>";
                }
                ?>
            </ul>
        </li>
        <li><a href="contact.php">Contato</a></li>
    </ul>
</div>