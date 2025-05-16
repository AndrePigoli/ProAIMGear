<?php
session_start();
include 'includes/db-connect.php';
include 'includes/functions.php';

// Check if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin/index.php');
    exit;
}

$error_message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if(empty($username) || empty($password)) {
        $error_message = 'Por favor, preencha todos os campos.';
    } else {
        // Get admin user data
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM admin_users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if(password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                
                // Redirect to admin panel
                header('Location: admin/index.php');
                exit;
            } else {
                $error_message = 'Senha incorreta.';
            }
        } else {
            $error_message = 'Usuário não encontrado.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - ProAim Gear</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-login-container">
        <div class="login-box">
            <div class="login-logo">
                <img src="assets/images/logo.png" alt="ProAim Gear Logo">
            </div>
            
            <h1>Painel <span class="text-neon">Administrativo</span></h1>
            
            <?php if(!empty($error_message)): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form class="login-form" method="post" action="">
                <div class="form-group">
                    <label for="username">Usuário</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary login-btn">Entrar</button>
            </form>
            
            <div class="login-footer">
                <a href="index.php" class="back-to-site">
                    <i class="fas fa-arrow-left"></i> Voltar para o site
                </a>
            </div>
        </div>
    </div>
    
    <script src="assets/js/admin.js"></script>
</body>
</html>