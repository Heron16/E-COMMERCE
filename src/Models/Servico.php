<?php

class Servico {
    private $pdo;
    private $tabela = 'servicos';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // CREATE
    public function criar($nome, $descricao, $preco, $duracao_minutos = 30) {
        try {
            $sql = "INSERT INTO {$this->tabela} (nome, descricao, preco, duracao_minutos) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $duracao_minutos]);
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
    
    // READ - Listar todos
    public function listarTodos() {
        try {
            $sql = "SELECT * FROM {$this->tabela} ORDER BY nome ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // UPDATE
    public function atualizar($id, $nome, $descricao, $preco, $duracao_minutos = 30) {
        try {
            $sql = "UPDATE {$this->tabela} SET nome = ?, descricao = ?, preco = ?, duracao_minutos = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $descricao, $preco, $duracao_minutos, $id]);
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

