<?php

$hostname = "localhost";
$bancodedados = "livros";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysqli->connect_errno) {
    echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_errno;
}



// // SQL para criar a tabela de produtos
// $sql_produtos = "CREATE TABLE IF NOT EXISTS produtos (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     nome VARCHAR(255) UNIQUE NOT NULL
// )";

// // Executar o comando para criar a tabela de produtos
// if ($mysqli->query($sql_produtos) === TRUE) {
//     echo "Tabela 'produtos' criada com sucesso.<br>";
// } else {
//     echo "Erro ao criar a tabela 'produtos': " . $mysqli->error . "<br>";
// }

// // SQL para criar a tabela de histórico de preços
// $sql_historico_precos = "CREATE TABLE IF NOT EXISTS historico_precos (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     produto_id INT,
//     preco DECIMAL(10, 2) NOT NULL,
//     data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (produto_id) REFERENCES produtos(id)
// )";

// // Executar o comando para criar a tabela de histórico de preços
// if ($mysqli->query($sql_historico_precos) === TRUE) {
//     echo "Tabela 'historico_precos' criada com sucesso.<br>";
// } else {
//     echo "Erro ao criar a tabela 'historico_precos': " . $mysqli->error . "<br>";
// }
