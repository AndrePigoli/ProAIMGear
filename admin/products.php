<?php
session_start();
include '../includes/db-connect.php';
include '../includes/functions.php';

// Check if logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Handle search and filtering
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Build query based on filters
$query = "SELECT p.*, c.name as category_name FROM products p 
          JOIN categories c ON p.category_id = c.id";

$where_clauses = [];

if(!empty($search)) {
    $where_clauses[] = "(p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}

if($category_filter > 0) {
    $where_clauses[] = "p.category_id = $category_filter";
}

if(!empty($where_clauses)) {
    $query .= " WHERE " . implode(' AND ', $where_clauses);
}

$query .= " ORDER BY p.created_at DESC";

// Get products
$result = mysqli_query($conn, $query);

// Get categories for filter
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories_result = mysqli_query($conn, $categories_query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - ProAim Gear Admin</title>
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
                <h1>Gerenciar Produtos</h1>
                <a href="add-product.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </a>
            </div>
            
            <div class="filter-container">
                <form action="" method="get" class="filter-form">
                    <div class="search-box">
                        <input type="text" name="search" placeholder="Buscar produtos..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                    
                    <div class="filter-box">
                        <select name="category" id="category-filter">
                            <option value="0">Todas as categorias</option>
                            <?php 
                            mysqli_data_seek($categories_result, 0);
                            while($category = mysqli_fetch_assoc($categories_result)) {
                                $selected = $category_filter == $category['id'] ? 'selected' : '';
                                echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="filter-btn">Filtrar</button>
                        <?php if(!empty($search) || $category_filter > 0): ?>
                            <a href="products.php" class="reset-btn">Limpar filtros</a>
                        <?php endif; ?>
                    </div>
                </form>
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
                            <th>Destaque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($result) > 0) {
                            while($product = mysqli_fetch_assoc($result)) {
                                $featured_icon = $product['featured'] ? 
                                    '<i class="fas fa-star featured-icon"></i>' : 
                                    '<i class="far fa-star"></i>';
                                
                                echo "<tr>";
                                echo "<td>{$product['id']}</td>";
                                echo "<td><img src='{$product['image']}' alt='{$product['name']}' class='product-thumbnail'></td>";
                                echo "<td>{$product['name']}</td>";
                                echo "<td>{$product['category_name']}</td>";
                                echo "<td>R$ " . number_format($product['price'], 2, ',', '.') . "</td>";
                                echo "<td>{$product['stock']}</td>";
                                echo "<td>$featured_icon</td>";
                                echo "<td>
                                        <a href='edit-product.php?id={$product['id']}' class='action-btn edit'><i class='fas fa-edit'></i></a>
                                        <a href='delete-product.php?id={$product['id']}' class='action-btn delete' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'><i class='fas fa-trash-alt'></i></a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='no-data'>Nenhum produto encontrado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>