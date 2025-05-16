<?php
// Product Card Function
function product_card($product) {
    $output = '<div class="product-card">';
    $output .= '<div class="product-image">';
    $output .= '<a href="product-detail.php?id='.$product['id'].'">';
    $output .= '<img src="'.$product['image'].'" alt="'.$product['name'].'">';
    $output .= '</a>';
    
    if($product['featured']) {
        $output .= '<div class="product-badge featured-badge">Destaque</div>';
    }
    
    $output .= '<div class="product-actions">';
    $output .= '<a href="product-detail.php?id='.$product['id'].'" class="btn-view-product">';
    $output .= '<i class="fas fa-eye"></i>';
    $output .= '</a>';
    
    $output .= '<form action="cart.php" method="post" class="quick-add-form">';
    $output .= '<input type="hidden" name="product_id" value="'.$product['id'].'">';
    $output .= '<input type="hidden" name="action" value="add">';
    $output .= '<input type="hidden" name="quantity" value="1">';
    $output .= '<button type="submit" class="btn-add-to-cart">';
    $output .= '<i class="fas fa-shopping-cart"></i>';
    $output .= '</button>';
    $output .= '</form>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '<div class="product-info">';
    $output .= '<h3 class="product-title">';
    $output .= '<a href="product-detail.php?id='.$product['id'].'">'.$product['name'].'</a>';
    $output .= '</h3>';
    $output .= '<div class="product-price">R$ '.number_format($product['price'], 2, ',', '.').'</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}

// Cart Functions
function add_to_cart($product_id, $quantity = 1) {
    // Initialize cart if it doesn't exist
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    // Add to cart or update quantity
    if(isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

function update_cart_item($product_id, $quantity) {
    if($quantity <= 0) {
        remove_from_cart($product_id);
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

function remove_from_cart($product_id) {
    if(isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function get_cart_total() {
    $total = 0;
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        global $conn;
        
        foreach($_SESSION['cart'] as $id => $quantity) {
            $query = "SELECT price FROM products WHERE id = $id";
            $result = mysqli_query($conn, $query);
            
            if(mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);
                $total += $product['price'] * $quantity;
            }
        }
    }
    return $total;
}

function get_cart_count() {
    $count = 0;
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $quantity) {
            $count += $quantity;
        }
    }
    return $count;
}

// Admin Functions
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Other utility functions
function truncate_text($text, $length = 100) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

function get_category_name($category_id) {
    global $conn;
    $query = "SELECT name FROM categories WHERE id = $category_id";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result)['name'];
    }
    return '';
}
?>