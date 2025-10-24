<?php

class Agendamento {
    private $pdo;
    private $tabela = 'agendamentos';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // CREATE
    public function criar($usuario_id, $servico_id, $data_agendamento, $hora_agendamento, $observacoes = '') {
        try {
            $sql = "INSERT INTO {$this->tabela} (usuario_id, servico_id, data_agendamento, hora_agendamento, observacoes, status) 
                    VALUES (?, ?, ?, ?, ?, 'Pendente')";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$usuario_id, $servico_id, $data_agendamento, $hora_agendamento, $observacoes]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // READ - Buscar por ID
    public function buscarPorId($id) {
        try {
            $sql = "SELECT a.*, u.nome as usuario_nome, u.email as usuario_email, s.nome as servico_nome, s.preco 
                    FROM {$this->tabela} a
                    JOIN usuarios u ON a.usuario_id = u.id
                    JOIN servicos s ON a.servico_id = s.id
                    WHERE a.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // READ - Listar todos (para admin)
    public function listarTodos() {
        try {
            $sql = "SELECT a.*, u.nome as usuario_nome, u.email as usuario_email, s.nome as servico_nome, s.preco 
                    FROM {$this->tabela} a
                    JOIN usuarios u ON a.usuario_id = u.id
                    JOIN servicos s ON a.servico_id = s.id
                    ORDER BY a.data_agendamento DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // READ - Listar por usuário
    public function listarPorUsuario($usuario_id) {
        try {
            $sql = "SELECT a.*, s.nome as servico_nome, s.preco 
                    FROM {$this->tabela} a
                    JOIN servicos s ON a.servico_id = s.id
                    WHERE a.usuario_id = ?
                    ORDER BY a.data_agendamento DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // UPDATE - Atualizar status
    public function atualizarStatus($id, $status) {
        try {
            $sql = "UPDATE {$this->tabela} SET status = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // UPDATE - Atualizar agendamento completo
    public function atualizar($id, $data_agendamento, $hora_agendamento, $status, $observacoes = '') {
        try {
            $sql = "UPDATE {$this->tabela} SET data_agendamento = ?, hora_agendamento = ?, status = ?, observacoes = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$data_agendamento, $hora_agendamento, $status, $observacoes, $id]);
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
    
    // Verificar disponibilidade de horário
    public function verificarDisponibilidade($data, $hora, $servico_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->tabela} 
                    WHERE data_agendamento = ? AND hora_agendamento = ? AND servico_id = ? AND status != 'Cancelado'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$data, $hora, $servico_id]);
            $resultado = $stmt->fetch();
            return $resultado['total'] == 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>

