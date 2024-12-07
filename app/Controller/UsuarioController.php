<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sistema_web';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(['sucesso' => false, 'mensagem' => 'Erro de conexão com o banco de dados']));
}

$action = $_GET['action'] ?? '';

// Requisição para listar usuários
if ($action === 'list') {
    $result = $conn->query("SELECT * FROM usuarios");
    $usuarios = [];
    
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
    exit;
}

// Requisição para cadastrar usuário
if ($action === 'create') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data['nome'] ?? null;
    $email = $data['email'] ?? null;

    if ($nome && $email) {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $email);

        if ($stmt->execute()) {
            echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário cadastrado com sucesso!']);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao cadastrar usuário!']);
        }
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Nome e e-mail são obrigatórios!']);
    }
    exit;
}

// Requisição para excluir usuário
if ($action === 'delete') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário excluído com sucesso!']);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'ID inválido!']);
    }
    exit;
}

// Requisição para editar usuário
if ($action === 'edit') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    $nome = $data['nome'] ?? null;
    $email = $data['email'] ?? null;

    if ($id && $nome && $email) {
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $email, $id);
        $stmt->execute();

        echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário atualizado com sucesso!']);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Faltam dados!']);
    }
    exit;
}

echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida!']);
?>
