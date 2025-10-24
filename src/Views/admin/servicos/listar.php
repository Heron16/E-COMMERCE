<?php include '../../templates/header.php'; ?>

<div class="content">
    <h1>Gerenciar Serviços</h1>
    
    <p><a href="?route=admin-servicos-criar" class="btn btn-success">Novo Serviço</a></p>
    
    <?php if (empty($servicos)): ?>
        <p>Nenhum serviço cadastrado.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Duração</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicos as $servico): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($servico['nome']); ?></td>
                        <td><?php echo htmlspecialchars($servico['descricao']); ?></td>
                        <td>R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo $servico['duracao_minutos']; ?> min</td>
                        <td>
                            <a href="?route=admin-servicos-editar&id=<?php echo $servico['id']; ?>" class="btn">Editar</a>
                            <a href="?route=admin-servicos-deletar&id=<?php echo $servico['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>

