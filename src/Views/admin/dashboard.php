<?php include '../templates/header.php'; ?>

<div class="content">
    <h1>Painel de Administração</h1>
    
    <div class="grid">
        <div class="card">
            <h3>Gerenciar Serviços</h3>
            <p>Criar, editar e deletar serviços de lavagem.</p>
            <a href="?route=admin-servicos" class="btn">Acessar</a>
        </div>
        
        <div class="card">
            <h3>Gerenciar Agendamentos</h3>
            <p>Visualizar e atualizar status dos agendamentos.</p>
            <a href="?route=admin-agendamentos" class="btn">Acessar</a>
        </div>
        
        <div class="card">
            <h3>Gerenciar Clientes</h3>
            <p>Visualizar e deletar clientes cadastrados.</p>
            <a href="?route=admin-usuarios" class="btn">Acessar</a>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>

