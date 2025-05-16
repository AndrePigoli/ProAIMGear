<footer class="main-footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>ProAim <span class="text-neon">Gear</span></h3>
                    <p>Equipamentos de alto desempenho para gamers e profissionais que exigem precisão e qualidade em cada detalhe.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitch"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h3>Links Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Produtos</a></li>
                        <li><a href="contact.php">Contato</a></li>
                        <li><a href="login.php">Área Administrativa</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Categorias</h3>
                    <ul class="footer-links">
                        <?php
                        $cat_query = "SELECT * FROM categories ORDER BY name LIMIT 5";
                        $cat_result = mysqli_query($conn, $cat_query);
                        
                        while($category = mysqli_fetch_assoc($cat_result)) {
                            echo "<li><a href='products.php?category={$category['id']}'>{$category['name']}</a></li>";
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Informações</h3>
                    <div class="footer-info">
                        <p><i class="fas fa-map-marker-alt"></i> Av. Paulista, 1000 - Bela Vista<br>São Paulo - SP, 01310-100</p>
                        <p><i class="fas fa-phone-alt"></i> (11) 3456-7890</p>
                        <p><i class="fas fa-envelope"></i> contato@proaimgear.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright">&copy; <?php echo date('Y'); ?> ProAim Gear. Todos os direitos reservados.</p>
            <div class="payment-methods">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-amex"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-pix"></i>
            </div>
        </div>
    </div>
</footer>

<!-- Notification Template -->
<div class="notification-container" id="notificationContainer"></div>