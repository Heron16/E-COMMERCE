<?php include '../../templates/header.php'; ?>

<div class="content">
    <h1><?php echo isset($servico) ? 'Editar Serviço' : 'Novo Serviço'; ?></h1>
    
    <form method="POST" action="<?php echo isset($servico) ? '?route=admin-servicos-editar' : '?route=admin-servicos-criar'; ?>">
        <?php if (isset($servico)): ?>
            <input type="hidden" name="id" value="<?php echo $servico['id']; ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="nome">Nome do Serviço:</label>
            <input type="text" id="nome" name="nome" value="<?php echo isset($servico) ? htmlspecialchars($servico['nome']) : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"><?php echo isset($servico) ? htmlspecialchars($servico['descricao']) : ''; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" step="0.01" value="<?php echo isset($servico) ? $servico['preco'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="duracao_minutos">Duração (minutos):</label>
            <input type="number" id="duracao_minutos" name="duracao_minutos" value="<?php echo isset($servico) ? $servico['duracao_minutos'] : '30'; ?>" required>
        </div>
        
        <div class="form-group">
            <input type="submit" value="<?php echo isset($servico) ? 'Atualizar' : 'Criar'; ?>">
            <a href="?route=admin-servicos" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php include '../../templates/footer.php'; ?>

