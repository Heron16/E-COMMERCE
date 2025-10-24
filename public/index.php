<?php

session_start();

// Incluir a configuração do PDO
require_once '../config/pdo.php';

// Incluir os Controllers
require_once '../src/Controllers/AuthController.php';
require_once '../src/Controllers/SiteController.php';
require_once '../src/Controllers/AdminController.php';
require_once '../src/Controllers/AgendamentoController.php';

// Obter a rota do parâmetro GET
$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Roteador simples
switch ($route) {
    // Rotas de autenticação
    case 'login':
        $authController = new AuthController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLoginForm();
        }
        break;
    
    case 'cadastro':
        $authController = new AuthController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->cadastrar();
        } else {
            $authController->showCadastroForm();
        }
        break;
    
    case 'logout':
        $authController = new AuthController($pdo);
        $authController->logout();
        break;
    
    // Rotas do site público
    case 'home':
        $siteController = new SiteController($pdo);
        $siteController->home();
        break;
    
    case 'servicos':
        $siteController = new SiteController($pdo);
        $siteController->listarServicos();
        break;
    
    // Rotas de agendamento
    case 'agendar':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?route=login');
            exit;
        }
        $agendamentoController = new AgendamentoController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $agendamentoController->criar();
        } else {
            $agendamentoController->showAgendarForm();
        }
        break;
    
    case 'meus-agendamentos':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?route=login');
            exit;
        }
        $agendamentoController = new AgendamentoController($pdo);
        $agendamentoController->listarMeus();
        break;
    
    // Rotas do painel admin
    case 'admin':
    case 'admin-dashboard':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->dashboard();
        break;
    
    // Gerenciar Serviços
    case 'admin-servicos':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->listarServicos();
        break;
    
    case 'admin-servicos-criar':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->criarServico();
        } else {
            $adminController->showFormServico();
        }
        break;
    
    case 'admin-servicos-editar':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->atualizarServico();
        } else {
            $adminController->showFormServico();
        }
        break;
    
    case 'admin-servicos-deletar':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->deletarServico();
        break;
    
    // Gerenciar Agendamentos
    case 'admin-agendamentos':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->listarAgendamentos();
        break;
    
    case 'admin-agendamentos-atualizar':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->atualizarAgendamento();
        } else {
            $adminController->showFormAgendamento();
        }
        break;
    
    case 'admin-agendamentos-deletar':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->deletarAgendamento();
        break;
    
    // Gerenciar Usuários/Clientes
    case 'admin-usuarios':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->listarUsuarios();
        break;
    
    case 'admin-usuarios-deletar':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: ?route=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $adminController->deletarUsuario();
        break;
    
    default:
        $siteController = new SiteController($pdo);
        $siteController->home();
        break;
}

?>

