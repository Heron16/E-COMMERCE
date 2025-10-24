<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Servico.php';
require_once __DIR__ . '/../Models/Agendamento.php';

class AdminController {
    private $pdo;
    private $usuarioModel;
    private $servicoModel;
    private $agendamentoModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($pdo);
        $this->servicoModel = new Servico($pdo);
        $this->agendamentoModel = new Agendamento($pdo);
    }
    
    // Dashboard
    public function dashboard() {
        include __DIR__ . '/../Views/admin/dashboard.php';
    }
    
    // ===== CRUD SERVIÇOS =====
    
    public function listarServicos() {
        $servicos = $this->servicoModel->listarTodos();
        include __DIR__ . '/../Views/admin/servicos/listar.php';
    }
    
    public function showFormServico() {
        $id = $_GET['id'] ?? null;
        $servico = null;
        
        if ($id) {
            $servico = $this->servicoModel->buscarPorId($id);
        }
        
        include __DIR__ . '/../Views/admin/servicos/form.php';
    }
    
    public function criarServico() {
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $duracao_minutos = $_POST['duracao_minutos'] ?? 30;
        
        if (empty($nome) || empty($preco)) {
            $_SESSION['erro'] = 'Nome e preço são obrigatórios';
        } else {
            if ($this->servicoModel->criar($nome, $descricao, $preco, $duracao_minutos)) {
                $_SESSION['sucesso'] = 'Serviço criado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Erro ao criar serviço';
            }
        }
        
        header('Location: ?route=admin-servicos');
        exit;
    }
    
    public function atualizarServico() {
        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $duracao_minutos = $_POST['duracao_minutos'] ?? 30;
        
        if (!$id || empty($nome) || empty($preco)) {
            $_SESSION['erro'] = 'Dados inválidos';
        } else {
            if ($this->servicoModel->atualizar($id, $nome, $descricao, $preco, $duracao_minutos)) {
                $_SESSION['sucesso'] = 'Serviço atualizado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Erro ao atualizar serviço';
            }
        }
        
        header('Location: ?route=admin-servicos');
        exit;
    }
    
    public function deletarServico() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['erro'] = 'ID inválido';
        } else {
            if ($this->servicoModel->deletar($id)) {
                $_SESSION['sucesso'] = 'Serviço deletado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Erro ao deletar serviço';
            }
        }
        
        header('Location: ?route=admin-servicos');
        exit;
    }
    
    // ===== CRUD AGENDAMENTOS =====
    
    public function listarAgendamentos() {
        $agendamentos = $this->agendamentoModel->listarTodos();
        include __DIR__ . '/../Views/admin/agendamentos/listar.php';
    }
    
    public function showFormAgendamento() {
        $id = $_GET['id'] ?? null;
        $agendamento = null;
        
        if ($id) {
            $agendamento = $this->agendamentoModel->buscarPorId($id);
        }
        
        include __DIR__ . '/../Views/admin/agendamentos/form.php';
    }
    
    public function atualizarAgendamento() {
        $id = $_POST['id'] ?? null;
        $data_agendamento = $_POST['data_agendamento'] ?? '';
        $hora_agendamento = $_POST['hora_agendamento'] ?? '';
        $status = $_POST['status'] ?? 'Pendente';
        $observacoes = $_POST['observacoes'] ?? '';
        
        if (!$id || empty($data_agendamento) || empty($hora_agendamento)) {
            $_SESSION['erro'] = 'Dados inválidos';
        } else {
            if ($this->agendamentoModel->atualizar($id, $data_agendamento, $hora_agendamento, $status, $observacoes)) {
                $_SESSION['sucesso'] = 'Agendamento atualizado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Erro ao atualizar agendamento';
            }
        }
        
        header('Location: ?route=admin-agendamentos');
        exit;
    }
    
    public function deletarAgendamento() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['erro'] = 'ID inválido';
        } else {
            if ($this->agendamentoModel->deletar($id)) {
                $_SESSION['sucesso'] = 'Agendamento deletado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Erro ao deletar agendamento';
            }
        }
        
        header('Location: ?route=admin-agendamentos');
        exit;
    }
    
    // ===== CRUD USUÁRIOS/CLIENTES =====
    
    public function listarUsuarios() {
        $usuarios = $this->usuarioModel->listarTodos();
        include __DIR__ . '/../Views/admin/usuarios/listar.php';
    }
    
    public function deletarUsuario() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['erro'] = 'ID inválido';
        } else {
            if ($this->usuarioModel->deletar($id)) {
                $_SESSION['sucesso'] = 'Usuário deletado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Erro ao deletar usuário';
            }
        }
        
        header('Location: ?route=admin-usuarios');
        exit;
    }
}

?>

