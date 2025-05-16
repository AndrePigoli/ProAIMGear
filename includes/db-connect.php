<?php
// Database connection settings
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'proaim_gear';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Set character set
mysqli_set_charset($conn, "utf8");
?>