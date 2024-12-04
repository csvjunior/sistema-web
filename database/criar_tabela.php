<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'sistema_web';

try {
    $conn = new PDO("mysql:host=$host", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);

    $conn->exec("USE $dbname");

    $sql = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $conn->exec($sql);
    echo "Configuração concluída com sucesso!";
} catch (PDOException $e) {
    die("Erro ao configurar o banco de dados: " . $e->getMessage());
}
?>

