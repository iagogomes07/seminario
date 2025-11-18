<?php
// config.php - Configuração do Banco de Dados

$host = 'localhost';        // Servidor do banco de dados
$user = 'root';             // Seu usuário do MySQL (padrão: root)
$password = '';             // Sua senha do MySQL (padrão: vazio)
$database = 'seminario_bd'; // Nome do banco que vamos criar

// Conectar ao MySQL
$conn = new mysqli($host, $user, $password);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Criar banco de dados se não existir
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_db) === TRUE) {
    // echo "Banco de dados criado com sucesso!<br>";
} else {
    die("Erro ao criar banco: " . $conn->error);
}

// Selecionar o banco
$conn->select_db($database);

// Criar tabela se não existir
$sql_create_table = "CREATE TABLE IF NOT EXISTS TB_Curso (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_curso VARCHAR(100) NOT NULL,
    descricao TEXT,
    duracao_horas INT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_table) === FALSE) {
    die("Erro ao criar tabela: " . $conn->error);
}

// echo "Sistema configurado com sucesso!";
?>