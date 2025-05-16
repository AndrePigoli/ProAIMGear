<?php
session_start();
include 'includes/db-connect.php';
include 'includes/functions.php';

// Get featured products
$featured_query = "SELECT * FROM products WHERE featured = 1 LIMIT 6";
$featured_result = mysqli_query($conn, $featured_query);

// Get new arrivals
$new_query = "SELECT * FROM products ORDER BY created_at DESC LIMIT 8";
$new_result = mysqli_query($conn, $new_query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProAim Gear - Periféricos de Alto Desempenho</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>PRECISÃO ENGENHADA <span class="text-neon">PARA GAMERS</span></h1>
            <p>Eleve seu gameplay com periféricos de nível profissional</p>
            <a href="products.php" class="btn-primary">COMPRAR AGORA</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="container section">
        <div class="section-header">
            <h2>PRODUTOS <span class="text-neon">EM DESTAQUE</span></h2>
            <p>Nossos equipamentos de alto desempenho mais populares</p>
        </div>

        <div class="featured-slider">
            <div class="slider-wrapper">
                <?php 
                if (mysqli_num_rows($featured_result) > 0) {
                    while($product = mysqli_fetch_assoc($featured_result)) {
                        echo product_card($product);
                    }
                } else {
                    echo "<p>Nenhum produto em destaque encontrado</p>";
                }
                ?>
            </div>
            <div class="slider-controls">
                <button id="prev-btn" class="slider-btn"><i class="fas fa-chevron-left"></i></button>
                <button id="next-btn" class="slider-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories container section">
        <div class="section-header">
            <h2>COMPRE POR <span class="text-neon">CATEGORIA</span></h2>
            <p>Explore nossa seleção premium de periféricos gaming</p>
        </div>
        
        <div class="category-grid">
            <a href="products.php?category=1" class="category-card">
                <div class="category-image mouse-img"></div>
                <h3>MOUSES GAMING</h3>
                <p>Sensores de alta precisão, designs ergonômicos</p>
            </a>
            <a href="products.php?category=2" class="category-card">
                <div class="category-image keyboard-img"></div>
                <h3>TECLADOS MECÂNICOS</h3>
                <p>Switches responsivos, RGB personalizável</p>
            </a>
            <a href="products.php?category=3" class="category-card">
                <div class="category-image mousepad-img"></div>
                <h3>MOUSEPADS PREMIUM</h3>
                <p>Superfícies suaves e duráveis</p>
            </a>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="container section">
        <div class="section-header">
            <h2>NOVOS <span class="text-neon">LANÇAMENTOS</span></h2>
            <p>As mais recentes adições à nossa linha de alto desempenho</p>
        </div>

        <div class="products-grid">
            <?php 
            if (mysqli_num_rows($new_result) > 0) {
                while($product = mysqli_fetch_assoc($new_result)) {
                    echo product_card($product);
                }
            } else {
                echo "<p>Nenhum produto encontrado</p>";
            }
            ?>
        </div>
    </section>

    <!-- Gaming Advantage Section -->
    <section class="advantage-section">
        <div class="container">
            <div class="advantage-content">
                <h2>CONQUISTE SUA <span class="text-neon">VANTAGEM</span></h2>
                <p>Os periféricos ProAim Gear são projetados para oferecer precisão milimétrica e resposta ultrarrápida, essenciais para gamers competitivos e profissionais que exigem o melhor.</p>
                <a href="products.php" class="btn-secondary">DESCUBRA MAIS</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>