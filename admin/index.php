<?php
session_start();
include '../includes/db-connect.php';
include '../includes/functions.php';

// Check if logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Get dashboard data
$products_query = "SELECT COUNT(*) as count FROM products";
$products_result = mysqli_query($conn, $products_query);
$products_count = mysqli_fetch_assoc($products_result)['count'];

$categories_query = "SELECT COUNT(*) as count FROM categories";
$categories_result = mysqli_query($conn, $categories_query);
$categories_count = mysqli_fetch_assoc($categories_result)['count'];

$messages_query = "SELECT COUNT(*) as count FROM contact_messages";
$messages_result = mysqli_query($conn, $messages_query);
$messages_count = mysqli_fetch_assoc($messages_result)['count'];

// Get recent products
$recent_products_query = "SELECT * FROM products ORDER BY created_at DESC LIMIT 5";
$recent_products_result = mysqli_query($conn, $recent_products_query);

// Get low stock products
$low_stock_query = "SELECT * FROM products WHERE stock <= 5 ORDER BY stock ASC LIMIT 5";
$low_stock_result = mysqli_query($conn, $low_stock_query);

// Get recent messages
$recent_messages_query = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5";
$recent_messages_result = mysqli_query($conn, $recent_messages_query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ProAim Gear Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <?php include 'includes/admin-header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/admin-sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    <span>Bem-vindo, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </div>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $products_count; ?></h3>
                        <span>Produtos</span>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $categories_count; ?></h3>
                        <span>Categorias</span>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $messages_count; ?></h3>
                        <span>Mensagens</span>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-details">
                        <h3>0</h3>
                        <span>Pedidos</span>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-content">
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>Produtos Recentes</h2>
                        <a href="products.php" class="view-all">Ver Todos</a>
                    </div>
                    
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Preço</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (mysqli_num_rows($recent_products_result) > 0) {
                                    while($product = mysqli_fetch_assoc($recent_products_result)) {
                                        // Get category name
                                        $cat_query = "SELECT name FROM categories WHERE id = {$product['category_id']}";
                                        $cat_result = mysqli_query($conn, $cat_query);
                                        $category_name = mysqli_fetch_assoc($cat_result)['name'];
                                        
                                        echo "<tr>";
                                        echo "<td>{$product['id']}</td>";
                                        echo "<td><img src='{$product['image']}' alt='{$product['name']}' class='product-thumbnail'></td>";
                                        echo "<td>{$product['name']}</td>";
                                        echo "<td>{$category_name}</td>";
                                        echo "<td>R$ " . number_format($product['price'], 2, ',', '.') . "</td>";
                                        echo "<td>{$product['stock']}</td>";
                                        echo "<td>
                                                <a href='edit-product.php?id={$product['id']}' class='action-btn edit'><i class='fas fa-edit'></i></a>
                                                <a href='delete-product.php?id={$product['id']}' class='action-btn delete' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'><i class='fas fa-trash-alt'></i></a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='no-data'>Nenhum produto cadastrado</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>Produtos com Estoque Baixo</h2>
                    </div>
                    
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (mysqli_num_rows($low_stock_result) > 0) {
                                    while($product = mysqli_fetch_assoc($low_stock_result)) {
                                        $stock_class = $product['stock'] <= 3 ? 'low-stock' : '';
                                        
                                        echo "<tr>";
                                        echo "<td>{$product['id']}</td>";
                                        echo "<td>{$product['name']}</td>";
                                        echo "<td class='{$stock_class}'>{$product['stock']}</td>";
                                        echo "<td>
                                                <a href='edit-product.php?id={$product['id']}' class='action-btn edit'><i class='fas fa-edit'></i></a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='no-data'>Nenhum produto com estoque baixo</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>Mensagens Recentes</h2>
                    </div>
                    
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Assunto</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (mysqli_num_rows($recent_messages_result) > 0) {
                                    while($message = mysqli_fetch_assoc($recent_messages_result)) {
                                        $date = date('d/m/Y H:i', strtotime($message['created_at']));
                                        
                                        echo "<tr>";
                                        echo "<td>{$message['id']}</td>";
                                        echo "<td>{$message['name']}</td>";
                                        echo "<td>{$message['email']}</td>";
                                        echo "<td>{$message['subject']}</td>";
                                        echo "<td>{$date}</td>";
                                        echo "<td>
                                                <a href='view-message.php?id={$message['id']}' class='action-btn view'><i class='fas fa-eye'></i></a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='no-data'>Nenhuma mensagem recebida</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>