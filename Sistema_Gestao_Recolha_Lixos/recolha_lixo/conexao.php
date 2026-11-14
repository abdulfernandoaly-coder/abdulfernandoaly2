<?php
// Configuração de ligacao ao MySQL (XAMPP padrão).
$servidor = "localhost";
$utilizador = "root";
$senha = "";
$banco = "gestao_lixo";

$conexao = new mysqli($servidor, $utilizador, $senha, $banco);

if ($conexao->connect_error) {
    http_response_code(500);
    die("Nao foi possível ligar à base de dados.");
}

$conexao->set_charset("utf8mb4");
?>
