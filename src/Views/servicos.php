<?php include 'templates/header.php'; ?>

<div class="content">
    <h1>Nossos Serviços</h1>
    
    <table>
        <thead>
            <tr>
                <th>Serviço</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Duração</th>
                <th>Ação</th>
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
                        <?php if (isset($_SESSION['usuario_id']) && $_SESSION['tipo'] === 'cliente'): ?>
                            <a href="?route=agendar&servico_id=<?php echo $servico['id']; ?>" class="btn">Agendar</a>
                        <?php elseif (!isset($_SESSION['usuario_id'])): ?>
                            <a href="?route=login" class="btn">Login</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'templates/footer.php'; ?>

