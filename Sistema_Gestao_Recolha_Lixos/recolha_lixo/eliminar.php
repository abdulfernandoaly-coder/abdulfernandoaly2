<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    echo json_encode(["mensagem" => "Identificador inválido."]);
    exit;
}

$stmt = $conexao->prepare("DELETE FROM recolhas WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows === 1) {
        echo json_encode(["mensagem" => "Registo eliminado com sucesso!"]);
    } else {
        http_response_code(404);
        echo json_encode(["mensagem" => "O registo não foi encontrado."]);
    }
} else {
    http_response_code(500);
    echo json_encode(["mensagem" => "Ocorreu um erro ao eliminar o registo."]);
}

$stmt->close();
$conexao->close();
?>
