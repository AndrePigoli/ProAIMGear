<?php
session_start();
include 'includes/db-connect.php';
include 'includes/functions.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form validation
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = 'Por favor, preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Por favor, forneça um email válido.';
    } else {
        // Insert into database
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $subject = mysqli_real_escape_string($conn, $subject);
        $message = mysqli_real_escape_string($conn, $message);
        
        $query = "INSERT INTO contact_messages (name, email, subject, message, created_at) 
                  VALUES ('$name', '$email', '$subject', '$message', NOW())";
        
        if (mysqli_query($conn, $query)) {
            $success_message = 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.';
            // Reset form data after successful submission
            $name = $email = $subject = $message = '';
        } else {
            $error_message = 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - ProAim Gear</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="page-header">
        <div class="container">
            <h1>Contato</h1>
        </div>
    </div>

    <div class="container contact-container">
        <div class="contact-info">
            <h2>Entre em <span class="text-neon">Contato</span></h2>
            <p>Tem alguma dúvida ou precisa de suporte? Estamos aqui para ajudar!</p>
            
            <div class="info-items">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Endereço</h3>
                        <p>Av. Paulista, 1000 - Bela Vista<br>São Paulo - SP, 01310-100</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <h3>Telefone</h3>
                        <p>(11) 3456-7890</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>E-mail</h3>
                        <p>contato@proaimgear.com</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Horário de Atendimento</h3>
                        <p>Segunda a Sexta: 9h às 18h<br>Sábados: 10h às 15h</p>
                    </div>
                </div>
            </div>
            
            <div class="social-media">
                <h3>Siga-nos nas Redes Sociais</h3>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitch"></i></a>
                </div>
            </div>
        </div>
        
        <div class="contact-form-container">
            <?php if (!empty($success_message)): ?>
                <div class="message success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form class="contact-form" method="post" action="" id="contactForm">
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Assunto</label>
                    <input type="text" id="subject" name="subject" value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Mensagem</label>
                    <textarea id="message" name="message" rows="5" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                </div>
                
                <button type="submit" class="btn-primary">Enviar Mensagem</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/contact.js"></script>
</body>
</html>