<<<<<<< HEAD
<?php
/**
 * Gerenciamento de Clientes - CRUD
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Cliente.php';

if (!isAdminLoggedIn()) {
    redirect('admin/');
}

$database = new Database();
$db = $database->getConnection();
$cliente_model = new Cliente($db);

$mensagem = '';
$erro = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    if ($acao == 'deletar') {
        $cliente_model->id = $_POST['id'] ?? 0;
        if ($cliente_model->delete()) {
            $mensagem = 'Cliente deletado com sucesso!';
        } else {
            $erro = 'Erro ao deletar cliente.';
        }
    }
}

// Listar clientes
$stmt = $cliente_model->readAll();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Gerenciar Clientes - Admin";
include __DIR__ . '/../../app/views/admin/header_admin.php';
?>

<div class="admin-content">
    <div class="admin-header">
        <h2>Gerenciar Clientes</h2>
        <div class="admin-stats">
            <span>Total de Clientes: <strong><?php echo count($clientes); ?></strong></span>
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
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cidade/Estado</th>
                    <th>Data Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['cidade']) . '/' . htmlspecialchars($cliente['estado']); ?></td>
                    <td><?php echo formatarData($cliente['data_cadastro']); ?></td>
                    <td>
                        <button onclick="verCliente(<?php echo $cliente['id']; ?>)" class="btn btn-sm">Ver Detalhes</button>
                        <button onclick="deletarCliente(<?php echo $cliente['id']; ?>)" class="btn btn-sm btn-danger">Deletar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Form para deletar -->
<form method="POST" action="" id="formDeletar" style="display:none;">
    <input type="hidden" name="acao" value="deletar">
    <input type="hidden" name="id" id="delete_id">
</form>

<script>
function verCliente(id) {
    alert('Ver detalhes do cliente #' + id);
}

function deletarCliente(id) {
    if (confirm('Tem certeza que deseja deletar este cliente?')) {
        document.getElementById('delete_id').value = id;
        document.getElementById('formDeletar').submit();
    }
}
</script>

<?php include __DIR__ . '/../../app/views/admin/footer_admin.php'; ?>
=======
<?php
/**
 * Gerenciamento de Clientes - CRUD
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Cliente.php';

if (!isAdminLoggedIn()) {
    redirect('admin/');
}

$database = new Database();
$db = $database->getConnection();
$cliente_model = new Cliente($db);

$mensagem = '';
$erro = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    if ($acao == 'deletar') {
        $cliente_model->id = $_POST['id'] ?? 0;
        if ($cliente_model->delete()) {
            $mensagem = 'Cliente deletado com sucesso!';
        } else {
            $erro = 'Erro ao deletar cliente.';
        }
    }
}

// Listar clientes
$stmt = $cliente_model->readAll();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Gerenciar Clientes - Admin";
include __DIR__ . '/../../app/views/admin/header_admin.php';
?>

<div class="admin-content">
    <div class="admin-header">
        <h2>Gerenciar Clientes</h2>
        <div class="admin-stats">
            <span>Total de Clientes: <strong><?php echo count($clientes); ?></strong></span>
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
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cidade/Estado</th>
                    <th>Data Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['cidade']) . '/' . htmlspecialchars($cliente['estado']); ?></td>
                    <td><?php echo formatarData($cliente['data_cadastro']); ?></td>
                    <td>
                        <button onclick="verCliente(<?php echo $cliente['id']; ?>)" class="btn btn-sm">Ver Detalhes</button>
                        <button onclick="deletarCliente(<?php echo $cliente['id']; ?>)" class="btn btn-sm btn-danger">Deletar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Form para deletar -->
<form method="POST" action="" id="formDeletar" style="display:none;">
    <input type="hidden" name="acao" value="deletar">
    <input type="hidden" name="id" id="delete_id">
</form>

<script>
function verCliente(id) {
    alert('Ver detalhes do cliente #' + id);
}

function deletarCliente(id) {
    if (confirm('Tem certeza que deseja deletar este cliente?')) {
        document.getElementById('delete_id').value = id;
        document.getElementById('formDeletar').submit();
    }
}
</script>

<?php include __DIR__ . '/../../app/views/admin/footer_admin.php'; ?>
>>>>>>> 6d2211e1183146ab30b22ae970e8c3384e7feec3
