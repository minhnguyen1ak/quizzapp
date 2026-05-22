<?php
$host     = getenv('DB_HOST')     ?: 'localhost';
$user     = getenv('DB_USER')     ?: 'root';
$password = getenv('DB_PASS')     ?: '';
$database = getenv('DB_NAME')     ?: 'quizz_app';
$port     = getenv('DB_PORT')     ?: 3306;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Kết nối database thất bại");
}
?>
