<?php
session_start();
include 'includes/db-connect.php';
include 'includes/functions.php';

// Process cart actions
if(isset($_POST['action']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    if($_POST['action'] == 'update' && isset($_POST['quantity'])) {
        update_cart_item($product_id, $_POST['quantity']);
    } 
    elseif($_POST['action'] == 'remove') {
        remove_from_cart($product_id);
    }
    
    header('Location: cart.php');
    exit;
}

// Get cart items
$cart_items = [];
$total = 0;

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $id => $quantity) {
        $query = "SELECT * FROM products WHERE id = $id";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            $product['quantity'] = $quantity;
            $product['subtotal'] = $product['price'] * $quantity;
            $cart_items[] = $product;
            $total += $product['subtotal'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - ProAim Gear</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="page-header">
        <div class="container">
            <h1>Carrinho de Compras</h1>
        </div>
    </div>

    <div class="container cart-container">
        <?php if(empty($cart_items)): ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h2>Seu carrinho está vazio</h2>
                <p>Adicione produtos ao seu carrinho para continuar</p>
                <a href="products.php" class="btn-primary">Continuar Comprando</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php foreach($cart_items as $item): ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        </div>
                        
                        <div class="item-details">
                            <h3><?php echo $item['name']; ?></h3>
                            <div class="item-category"><?php 
                                $cat_query = "SELECT name FROM categories WHERE id = {$item['category_id']}";
                                $cat_result = mysqli_query($conn, $cat_query);
                                echo mysqli_fetch_assoc($cat_result)['name']; 
                            ?></div>
                            <div class="item-price">R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></div>
                        </div>
                        
                        <div class="item-actions">
                            <form action="" method="post" class="update-quantity-form">
                                <div class="quantity-controls cart-quantity">
                                    <button type="button" class="quantity-btn minus" onclick="updateCartQuantity(this, -1)">-</button>
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>">
                                    <button type="button" class="quantity-btn plus" onclick="updateCartQuantity(this, 1)">+</button>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="update">
                                <button type="submit" class="update-btn">Atualizar</button>
                            </form>
                            
                            <div class="item-subtotal">
                                <span>Subtotal:</span>
                                <span class="subtotal-value">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></span>
                            </div>
                            
                            <form action="" method="post" class="remove-item-form">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="remove-btn"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <h2>Resumo do Pedido</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="summary-value">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Frete</span>
                        <span class="summary-value">Grátis</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="total-value">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                    </div>
                    
                    <button class="btn-primary checkout-btn">Finalizar Compra</button>
                    <a href="products.php" class="btn-secondary continue-shopping">Continuar Comprando</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>