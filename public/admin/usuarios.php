<?php
/**
 * Gerenciamento de Usuários - CRUD
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Usuario.php';

if (!isAdminLoggedIn()) {
    redirect('admin/');
}

$database = new Database();
$db = $database->getConnection();
$usuario_model = new Usuario($db);

$mensagem = '';
$erro = '';

// Processar ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    if ($acao == 'criar') {
        $usuario_model->nome = $_POST['nome'] ?? '';
        $usuario_model->email = $_POST['email'] ?? '';
        $usuario_model->senha = $_POST['senha'] ?? '';
        $usuario_model->tipo = $_POST['tipo'] ?? 'funcionario';
        $usuario_model->ativo = $_POST['ativo'] ?? 1;
        
        if ($usuario_model->emailExiste($usuario_model->email)) {
            $erro = 'Este email já está cadastrado.';
        } elseif ($usuario_model->create()) {
            $mensagem = 'Usuário criado com sucesso!';
        } else {
            $erro = 'Erro ao criar usuário.';
        }
    }
    elseif ($acao == 'editar') {
        $usuario_model->id = $_POST['id'] ?? 0;
        $usuario_model->nome = $_POST['nome'] ?? '';
        $usuario_model->email = $_POST['email'] ?? '';
        $usuario_model->tipo = $_POST['tipo'] ?? 'funcionario';
        $usuario_model->ativo = $_POST['ativo'] ?? 1;
        
        if ($usuario_model->update()) {
            $mensagem = 'Usuário atualizado com sucesso!';
        } else {
            $erro = 'Erro ao atualizar usuário.';
        }
    }
    elseif ($acao == 'deletar') {
        $usuario_model->id = $_POST['id'] ?? 0;
        if ($usuario_model->delete()) {
            $mensagem = 'Usuário deletado com sucesso!';
        } else {
            $erro = 'Erro ao deletar usuário.';
        }
    }
}

// Listar usuários
$stmt = $usuario_model->readAll();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Gerenciar Usuários - Admin";
include __DIR__ . '/../../app/views/admin/header_admin.php';
?>

<div class="admin-content">
    <div class="admin-header">
        <h2>Gerenciar Usuários</h2>
        <button onclick="abrirModal('modalCriar')" class="btn btn-primary">+ Novo Usuário</button>
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
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Data Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td>
                        <span class="badge <?php echo $usuario['tipo'] == 'admin' ? 'badge-primary' : 'badge-secondary'; ?>">
                            <?php echo ucfirst($usuario['tipo']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge <?php echo $usuario['ativo'] ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $usuario['ativo'] ? 'Ativo' : 'Inativo'; ?>
                        </span>
                    </td>
                    <td><?php echo formatarDataHora($usuario['data_criacao']); ?></td>
                    <td>
                        <button onclick='editarUsuario(<?php echo json_encode($usuario); ?>)' class="btn btn-sm">Editar</button>
                        <?php if ($usuario['id'] != $_SESSION['admin_id']): ?>
                        <button onclick="deletarUsuario(<?php echo $usuario['id']; ?>)" class="btn btn-sm btn-danger">Deletar</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Criar -->
<div id="modalCriar" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="fecharModal('modalCriar')">&times;</span>
        <h3>Novo Usuário</h3>
        
        <form method="POST" action="">
            <input type="hidden" name="acao" value="criar">
            
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="nome" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="senha" required minlength="6">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Tipo:</label>
                    <select name="tipo">
                        <option value="funcionario">Funcionário</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status:</label>
                    <select name="ativo">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Criar Usuário</button>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="fecharModal('modalEditar')">&times;</span>
        <h3>Editar Usuário</h3>
        
        <form method="POST" action="">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" id="edit_id">
            
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="nome" id="edit_nome" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" id="edit_email" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Tipo:</label>
                    <select name="tipo" id="edit_tipo">
                        <option value="funcionario">Funcionário</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status:</label>
                    <select name="ativo" id="edit_ativo">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>
            
            <p class="form-note">* Deixe a senha em branco para mantê-la inalterada</p>
            
            <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
        </form>
    </div>
</div>

<!-- Form para deletar -->
<form method="POST" action="" id="formDeletar" style="display:none;">
    <input type="hidden" name="acao" value="deletar">
    <input type="hidden" name="id" id="delete_id">
</form>

<script>
function abrirModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function fecharModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function editarUsuario(usuario) {
    document.getElementById('edit_id').value = usuario.id;
    document.getElementById('edit_nome').value = usuario.nome;
    document.getElementById('edit_email').value = usuario.email;
    document.getElementById('edit_tipo').value = usuario.tipo;
    document.getElementById('edit_ativo').value = usuario.ativo;
    abrirModal('modalEditar');
}

function deletarUsuario(id) {
    if (confirm('Tem certeza que deseja deletar este usuário?')) {
        document.getElementById('delete_id').value = id;
        document.getElementById('formDeletar').submit();
    }
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

<?php include __DIR__ . '/../../app/views/admin/footer_admin.php'; ?>
