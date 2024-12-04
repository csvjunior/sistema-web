<?php
class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    public function cadastrar($dados) {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email) VALUES (:nome, :email)");
        $stmt->bindParam(":nome", $dados['nome']);
        $stmt->bindParam(":email", $dados['email']);
        $stmt->execute();
        return ["mensagem" => "Usuário cadastrado com sucesso!"];
    }

    public function editar($id, $dados) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id");
        $stmt->bindParam(":nome", $dados['nome']);
        $stmt->bindParam(":email", $dados['email']);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return ["mensagem" => "Usuário atualizado com sucesso!"];
    }

    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return ["mensagem" => "Usuário excluído com sucesso!"];
    }
}
?>

