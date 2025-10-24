<?php

require_once __DIR__ . '/../Models/Usuario.php';

class AuthController {
    private $pdo;
    private $usuarioModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($pdo);
    }
    
    public function login() {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        if (empty($email) || empty($senha)) {
            $_SESSION['erro'] = 'Email e senha são obrigatórios';
            header('Location: ?route=login');
            exit;
        }
        
        $usuario = $this->usuarioModel->buscarPorEmail($email);
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo'] = $usuario['tipo'];
            
            if ($usuario['tipo'] === 'admin') {
                header('Location: ?route=admin');
            } else {
                header('Location: ?route=home');
            }
            exit;
        } else {
            $_SESSION['erro'] = 'Email ou senha inválidos';
            header('Location: ?route=login');
            exit;
        }
    }
    
    public function cadastrar() {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar_senha = $_POST['confirmar_senha'] ?? '';
        
        if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
            $_SESSION['erro'] = 'Todos os campos são obrigatórios';
            header('Location: ?route=cadastro');
            exit;
        }
        
        if ($senha !== $confirmar_senha) {
            $_SESSION['erro'] = 'As senhas não coincidem';
            header('Location: ?route=cadastro');
            exit;
        }
        
        if (strlen($senha) < 6) {
            $_SESSION['erro'] = 'A senha deve ter no mínimo 6 caracteres';
            header('Location: ?route=cadastro');
            exit;
        }
        
        $usuarioExistente = $this->usuarioModel->buscarPorEmail($email);
        if ($usuarioExistente) {
            $_SESSION['erro'] = 'Este email já está cadastrado';
            header('Location: ?route=cadastro');
            exit;
        }
        
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        if ($this->usuarioModel->criar($nome, $email, $senhaHash, 'cliente')) {
            $_SESSION['sucesso'] = 'Cadastro realizado com sucesso! Faça login para continuar.';
            header('Location: ?route=login');
            exit;
        } else {
            $_SESSION['erro'] = 'Erro ao cadastrar. Tente novamente.';
            header('Location: ?route=cadastro');
            exit;
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: ?route=home');
        exit;
    }
    
    public function showLoginForm() {
        include __DIR__ . '/../Views/login.php';
    }
    
    public function showCadastroForm() {
        include __DIR__ . '/../Views/cadastro.php';
    }
}

?>

