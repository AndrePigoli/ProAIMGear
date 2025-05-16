<?php
session_start();
include 'includes/db-connect.php';
include 'includes/functions.php';

// Get category filter
$category_filter = "";
if(isset($_GET['category']) && !empty($_GET['category'])) {
    $category_id = mysqli_real_escape_string($conn, $_GET['category']);
    $category_filter = "WHERE category_id = $category_id";
    
    // Get category name
    $cat_query = "SELECT name FROM categories WHERE id = $category_id";
    $cat_result = mysqli_query($conn, $cat_query);
    $category_name = mysqli_fetch_assoc($cat_result)['name'];
}

// Get products
$products_query = "SELECT * FROM products $category_filter ORDER BY created_at DESC";
$products_result = mysqli_query($conn, $products_query);

// Get all categories for filter
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories_result = mysqli_query($conn, $categories_query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($category_name) ? $category_name : 'Todos os Produtos'; ?> - ProAim Gear</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="page-header">
        <div class="container">
            <h1><?php echo isset($category_name) ? $category_name : 'Todos os Produtos'; ?></h1>
        </div>
    </div>

    <section class="container products-section">
        <div class="products-filter">
            <h3>Filtrar por Categoria</h3>
            <ul class="category-filter">
                <li><a href="products.php" class="<?php echo !isset($_GET['category']) ? 'active' : ''; ?>">Todos os Produtos</a></li>
                <?php 
                while($category = mysqli_fetch_assoc($categories_result)) {
                    $active_class = isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'active' : '';
                    echo "<li><a href='products.php?category={$category['id']}' class='$active_class'>{$category['name']}</a></li>";
                }
                ?>
            </ul>
        </div>

        <div class="products-container">
            <div class="products-grid">
                <?php 
                if (mysqli_num_rows($products_result) > 0) {
                    while($product = mysqli_fetch_assoc($products_result)) {
                        echo product_card($product);
                    }
                } else {
                    echo "<p class='no-products'>Nenhum produto encontrado</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>