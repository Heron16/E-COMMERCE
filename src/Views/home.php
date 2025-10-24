<?php include 'templates/header.php'; ?>

<div class="content">
    <h1>Bem-vindo ao Lava-Car</h1>
    <p>Sistema de agendamento online para serviços de lavagem e limpeza de veículos.</p>
    
    <h2>Nossos Serviços</h2>
    <div class="grid">
        <?php foreach ($servicos as $servico): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($servico['nome']); ?></h3>
                <p><?php echo htmlspecialchars($servico['descricao']); ?></p>
                <p class="price">R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></p>
                <p><small>Duração: <?php echo $servico['duracao_minutos']; ?> minutos</small></p>
                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['tipo'] === 'cliente'): ?>
                    <a href="?route=agendar&servico_id=<?php echo $servico['id']; ?>" class="btn">Agendar</a>
                <?php elseif (!isset($_SESSION['usuario_id'])): ?>
                    <a href="?route=login" class="btn">Faça Login para Agendar</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>

