<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

$sql = "SELECT id, nome, bairro, quantidade, data_registo
        FROM recolhas ORDER BY id DESC";
$resultado = $conexao->query($sql);

if (!$resultado) {
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro ao consultar os registos."]);
    exit;
}

$dados = [];
while ($linha = $resultado->fetch_assoc()) {
    $dados[] = $linha;
}

echo json_encode($dados);
$conexao->close();
?>
