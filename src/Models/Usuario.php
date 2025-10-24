<?php

class Usuario {
    private $pdo;
    private $tabela = 'usuarios';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // CREATE
    public function criar($nome, $email, $senha, $tipo = 'cliente') {
        try {
            $sql = "INSERT INTO {$this->tabela} (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $email, $senha, $tipo]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // READ - Buscar por ID
    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM {$this->tabela} WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // READ - Buscar por Email
    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT * FROM {$this->tabela} WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // READ - Listar todos (apenas clientes)
    public function listarTodos() {
        try {
            $sql = "SELECT * FROM {$this->tabela} WHERE tipo = 'cliente' ORDER BY data_criacao DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // UPDATE
    public function atualizar($id, $nome, $email) {
        try {
            $sql = "UPDATE {$this->tabela} SET nome = ?, email = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $email, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // DELETE
    public function deletar($id) {
        try {
            $sql = "DELETE FROM {$this->tabela} WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>

