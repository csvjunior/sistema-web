<?php
// Inclui a conexão ao banco
require 'conexao.php';

// Lê os dados enviados pelo JavaScript
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['nome'], $input['email'])) {
    $nome = $input['nome'];
    $email = $input['email'];

    try {
        // Prepara e executa a inserção no banco
        $sql = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Retorna uma resposta de sucesso
        echo json_encode(["mensagem" => "Usuário cadastrado com sucesso!"]);
    } catch (PDOException $e) {
        // Captura erros, como email duplicado
        echo json_encode(["mensagem" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["mensagem" => "Dados inválidos."]);
}
?>
