<?php

require_once __DIR__ . '/../Models/Servico.php';

class SiteController {
    private $pdo;
    private $servicoModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->servicoModel = new Servico($pdo);
    }
    
    public function home() {
        $servicos = $this->servicoModel->listarTodos();
        include __DIR__ . '/../Views/home.php';
    }
    
    public function listarServicos() {
        $servicos = $this->servicoModel->listarTodos();
        include __DIR__ . '/../Views/servicos.php';
    }
}

?>

