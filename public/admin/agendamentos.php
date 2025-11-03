<?php
/**
 * Gerenciamento de Agendamentos - CRUD
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Agendamento.php';

if (!isAdminLoggedIn()) {
    redirect('admin/');
}

$database = new Database();
$db = $database->getConnection();
$agendamento_model = new Agendamento($db);

$mensagem = '';
$erro = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    if ($acao == 'atualizar_status') {
        $agendamento_model->id = $_POST['id'] ?? 0;
        $novo_status = $_POST['status'] ?? '';
        
        if ($agendamento_model->updateStatus($novo_status)) {
            $mensagem = 'Status atualizado com sucesso!';
        } else {
            $erro = 'Erro ao atualizar status.';
        }
    }
    elseif ($acao == 'deletar') {
        $agendamento_model->id = $_POST['id'] ?? 0;
        if ($agendamento_model->delete()) {
            $mensagem = 'Agendamento deletado com sucesso!';
        } else {
            $erro = 'Erro ao deletar agendamento.';
        }
    }
}

// Listar agendamentos
$stmt = $agendamento_model->readAll();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Gerenciar Agendamentos - Admin";
include __DIR__ . '/../../app/views/admin/header_admin.php';
?>

<div class="admin-content">
    <div class="admin-header">
        <h2>Gerenciar Agendamentos</h2>
        <div class="admin-stats">
            <span>Total: <strong><?php echo count($agendamentos); ?></strong></span>
        </div>
    </div>
    
    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    
    <?php if ($erro): ?>
        <div class="alert alert-error"><?php echo $erro; ?></div>
    <?php endif; ?>
    
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Contato</th>
                    <th>Data/Hora</th>
                    <th>Veículo</th>
                    <th>Placa</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $ag): ?>
                <tr>
                    <td>#<?php echo $ag['id']; ?></td>
                    <td><?php echo htmlspecialchars($ag['cliente_nome']); ?></td>
                    <td><?php echo htmlspecialchars($ag['cliente_telefone']); ?></td>
                    <td>
                        <?php echo formatarData($ag['data_agendamento']); ?><br>
                        <small><?php echo date('H:i', strtotime($ag['hora_agendamento'])); ?></small>
                    </td>
                    <td><?php echo ucfirst($ag['tipo_veiculo']); ?></td>
                    <td><?php echo htmlspecialchars($ag['placa_veiculo'] ?? '-'); ?></td>
                    <td><?php echo formatarMoeda($ag['valor_total']); ?></td>
                    <td>
                        <select onchange="atualizarStatus(<?php echo $ag['id']; ?>, this.value)" class="status-select">
                            <option value="pendente" <?php echo $ag['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="confirmado" <?php echo $ag['status'] == 'confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                            <option value="em_andamento" <?php echo $ag['status'] == 'em_andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                            <option value="concluido" <?php echo $ag['status'] == 'concluido' ? 'selected' : ''; ?>>Concluído</option>
                            <option value="cancelado" <?php echo $ag['status'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="verDetalhes(<?php echo $ag['id']; ?>)" class="btn btn-sm">Ver</button>
                        <button onclick="deletarAgendamento(<?php echo $ag['id']; ?>)" class="btn btn-sm btn-danger">Deletar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Form para atualizar status -->
<form method="POST" action="" id="formStatus" style="display:none;">
    <input type="hidden" name="acao" value="atualizar_status">
    <input type="hidden" name="id" id="status_id">
    <input type="hidden" name="status" id="status_valor">
</form>

<!-- Form para deletar -->
<form method="POST" action="" id="formDeletar" style="display:none;">
    <input type="hidden" name="acao" value="deletar">
    <input type="hidden" name="id" id="delete_id">
</form>

<script>
function atualizarStatus(id, novoStatus) {
    document.getElementById('status_id').value = id;
    document.getElementById('status_valor').value = novoStatus;
    document.getElementById('formStatus').submit();
}

function verDetalhes(id) {
    alert('Ver detalhes do agendamento #' + id);
}

function deletarAgendamento(id) {
    if (confirm('Tem certeza que deseja deletar este agendamento?')) {
        document.getElementById('delete_id').value = id;
        document.getElementById('formDeletar').submit();
    }
}
</script>

<?php include __DIR__ . '/../../app/views/admin/footer_admin.php'; ?>
