<?php
$host = 'localhost';      // endereço do servidor MySQL
$db   = 'taskmaster';     // nome do banco de dados que você criou
$user = 'root';           // usuário do MySQL (no XAMPP geralmente é 'root')
$pass = '';               // senha do MySQL (no XAMPP geralmente é vazia)
$charset = 'utf8mb4';     // charset recomendado

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // mostra erros do PDO
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // retorna array associativo
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
