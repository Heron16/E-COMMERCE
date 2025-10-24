<?php

require_once __DIR__ . '/../Models/Agendamento.php';
require_once __DIR__ . '/../Models/Servico.php';

class AgendamentoController {
    private $pdo;
    private $agendamentoModel;
    private $servicoModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->agendamentoModel = new Agendamento($pdo);
        $this->servicoModel = new Servico($pdo);
    }
    
    public function showAgendarForm() {
        $servicos = $this->servicoModel->listarTodos();
        include __DIR__ . '/../Views/agendar.php';
    }
    
    public function criar() {
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        $servico_id = $_POST['servico_id'] ?? null;
        $data_agendamento = $_POST['data_agendamento'] ?? '';
        $hora_agendamento = $_POST['hora_agendamento'] ?? '';
        $observacoes = $_POST['observacoes'] ?? '';
        
        if (!$usuario_id || !$servico_id || empty($data_agendamento) || empty($hora_agendamento)) {
            $_SESSION['erro'] = 'Dados inválidos';
            header('Location: ?route=agendar');
            exit;
        }
        
        // Validar data (não pode ser no passado)
        $data_agendamento_obj = new DateTime($data_agendamento);
        $hoje = new DateTime();
        
        if ($data_agendamento_obj < $hoje) {
            $_SESSION['erro'] = 'A data deve ser no futuro';
            header('Location: ?route=agendar');
            exit;
        }
        
        // Verificar disponibilidade
        if (!$this->agendamentoModel->verificarDisponibilidade($data_agendamento, $hora_agendamento, $servico_id)) {
            $_SESSION['erro'] = 'Este horário não está disponível';
            header('Location: ?route=agendar');
            exit;
        }
        
        if ($this->agendamentoModel->criar($usuario_id, $servico_id, $data_agendamento, $hora_agendamento, $observacoes)) {
            $_SESSION['sucesso'] = 'Agendamento realizado com sucesso!';
            header('Location: ?route=meus-agendamentos');
        } else {
            $_SESSION['erro'] = 'Erro ao criar agendamento';
            header('Location: ?route=agendar');
        }
        exit;
    }
    
    public function listarMeus() {
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        
        if (!$usuario_id) {
            header('Location: ?route=login');
            exit;
        }
        
        $agendamentos = $this->agendamentoModel->listarPorUsuario($usuario_id);
        include __DIR__ . '/../Views/meus-agendamentos.php';
    }
}

?>

