<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);
$nome = trim($_POST["nome"] ?? "");
$bairro = trim($_POST["bairro"] ?? "");
$quantidade = filter_var($_POST["quantidade"] ?? null, FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1 || $nome === "" || $bairro === "" ||
    $quantidade === false || $quantidade === null || $quantidade < 1) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Dados inválidos. Verifique todos os campos."]);
    exit;
}

$stmt = $conexao->prepare(
    "UPDATE recolhas SET nome = ?, bairro = ?, quantidade = ? WHERE id = ?"
);
$stmt->bind_param("ssii", $nome, $bairro, $quantidade, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows >= 0) {
        echo json_encode(["mensagem" => "Registo atualizado com sucesso!"]);
    } else {
        http_response_code(500);
        echo json_encode(["mensagem" => "Não foi possível atualizar o registo."]);
    }
} else {
    http_response_code(500);
    echo json_encode(["mensagem" => "Ocorreu um erro ao atualizar o registo."]);
}

$stmt->close();
$conexao->close();
?>
