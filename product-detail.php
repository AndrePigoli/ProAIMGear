<?php
session_start();
include 'includes/db-connect.php';
include 'includes/functions.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$product_id = mysqli_real_escape_string($conn, $_GET['id']);
$product_query = "SELECT p.*, c.name as category_name FROM products p 
                  JOIN categories c ON p.category_id = c.id
                  WHERE p.id = $product_id";
$product_result = mysqli_query($conn, $product_query);

if(mysqli_num_rows($product_result) == 0) {
    header('Location: products.php');
    exit;
}

$product = mysqli_fetch_assoc($product_result);

// Get related products
$related_query = "SELECT * FROM products 
                  WHERE category_id = {$product['category_id']} 
                  AND id != $product_id 
                  LIMIT 4";
$related_result = mysqli_query($conn, $related_query);

// Handle add to cart action
if(isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    add_to_cart($product_id, $quantity);
    header("Location: product-detail.php?id=$product_id&added=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - ProAim Gear</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <?php if(isset($_GET['added']) && $_GET['added'] == 1): ?>
    <div class="notification" id="cart-notification">
        <p><i class="fas fa-check-circle"></i> Produto adicionado ao carrinho!</p>
    </div>
    <?php endif; ?>

    <div class="container product-detail-container">
        <div class="product-detail">
            <div class="product-images">
                <div class="main-image">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" id="main-product-image">
                </div>
                <?php if(!empty($product['image_2']) || !empty($product['image_3'])): ?>
                <div class="thumbnail-images">
                    <div class="thumbnail active" onclick="changeImage('<?php echo $product['image']; ?>')">
                        <img src="<?php echo $product['image']; ?>" alt="Thumbnail 1">
                    </div>
                    <?php if(!empty($product['image_2'])): ?>
                    <div class="thumbnail" onclick="changeImage('<?php echo $product['image_2']; ?>')">
                        <img src="<?php echo $product['image_2']; ?>" alt="Thumbnail 2">
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($product['image_3'])): ?>
                    <div class="thumbnail" onclick="changeImage('<?php echo $product['image_3']; ?>')">
                        <img src="<?php echo $product['image_3']; ?>" alt="Thumbnail 3">
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="product-info">
                <div class="product-category"><?php echo $product['category_name']; ?></div>
                <h1 class="product-title"><?php echo $product['name']; ?></h1>
                <div class="product-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></div>
                
                <div class="product-description">
                    <?php echo nl2br($product['description']); ?>
                </div>
                
                <form action="" method="post" class="add-to-cart-form">
                    <div class="quantity-selector">
                        <label for="quantity">Quantidade:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn minus" onclick="changeQuantity(-1)">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                            <button type="button" class="quantity-btn plus" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="add_to_cart" value="1">
                    <button type="submit" class="btn-primary add-to-cart-btn">
                        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                    </button>
                </form>
                
                <div class="product-meta">
                    <div class="meta-item">
                        <i class="fas fa-box"></i>
                        <span>Estoque: <?php echo $product['stock'] > 0 ? $product['stock'] . ' unidades' : 'Esgotado'; ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-truck"></i>
                        <span>Entrega grátis para todo o Brasil</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Garantia de 12 meses</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <?php if(mysqli_num_rows($related_result) > 0): ?>
        <section class="related-products section">
            <div class="section-header">
                <h2>PRODUTOS <span class="text-neon">RELACIONADOS</span></h2>
            </div>
            
            <div class="products-grid">
                <?php 
                while($related = mysqli_fetch_assoc($related_result)) {
                    echo product_card($related);
                }
                ?>
            </div>
        </section>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/product-detail.js"></script>
</body>
</html>