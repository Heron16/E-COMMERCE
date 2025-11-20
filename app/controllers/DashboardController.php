<?php
require_once __DIR__ . '/../models/Agendamento.php';
require_once __DIR__ . '/../models/Servico.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/BaseController.php';

class DashboardController extends BaseController {
    public function getResumo() {
        $ag = new Agendamento($this->db);
        $cl = new Cliente($this->db);

        return [
            'total_agendamentos_mes' => $ag->totalAgendamentosMes(),
            'total_lavagens_mes' => $ag->totalLavagensMes(),
            'total_lavagens_semana' => $ag->totalLavagensSemana(),
            'receita_mensal' => $ag->receitaMensal(),
            'receita_semanal' => $ag->receitaSemanal(),
            'total_clientes' => $cl->count(),
        ];
    }

    public function getServicosMaisSolicitados(int $limit = 5) {
        $sv = new Servico($this->db);
        $stmt = $sv->maissolicitados($limit);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDashboardSemanal() {
        $ag = new Agendamento($this->db);
        $stmt = $ag->getDashboardSemanal();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAgendamentosRecentes(int $limit = 10) {
        $ag = new Agendamento($this->db);
        $stmt = $ag->readAll();
        $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_slice($todos, 0, $limit);
    }
}
?>