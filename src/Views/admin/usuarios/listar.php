<?php include '../../templates/header.php'; ?>

<div class="content">
    <h1>Gerenciar Clientes</h1>
    
    <?php if (empty($usuarios)): ?>
        <p>Nenhum cliente cadastrado.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($usuario['data_criacao'])); ?></td>
                        <td>
                            <a href="?route=admin-usuarios-deletar&id=<?php echo $usuario['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza? Isso também deletará todos os agendamentos deste cliente.')">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>

