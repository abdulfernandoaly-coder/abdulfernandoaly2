<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

$nome = trim($_POST["nome"] ?? "");
$bairro = trim($_POST["bairro"] ?? "");
$quantidade = filter_var($_POST["quantidade"] ?? null, FILTER_VALIDATE_INT);

if ($nome === "" || $bairro === "" || $quantidade === false ||
    $quantidade === null || $quantidade < 1) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Preencha todos os campos corretamente."]);
    exit;
}

$stmt = $conexao->prepare(
    "INSERT INTO recolhas (nome, bairro, quantidade) VALUES (?, ?, ?)"
);
$stmt->bind_param("ssi", $nome, $bairro, $quantidade);

if ($stmt->execute()) {
    echo json_encode(["mensagem" => "Registo guardado com sucesso!"]);
} else {
    http_response_code(500);
    echo json_encode(["mensagem" => "Ocorreu um erro ao guardar o registo."]);
}

$stmt->close();
$conexao->close();
?>
