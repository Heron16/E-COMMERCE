<?php include 'templates/header.php'; ?>

<div class="content">
    <h1>Agendar Serviço</h1>
    
    <form method="POST" action="?route=agendar">
        <div class="form-group">
            <label for="servico_id">Serviço:</label>
            <select id="servico_id" name="servico_id" required>
                <option value="">Selecione um serviço</option>
                <?php foreach ($servicos as $servico): ?>
                    <option value="<?php echo $servico['id']; ?>">
                        <?php echo htmlspecialchars($servico['nome']); ?> - R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="data_agendamento">Data:</label>
            <input type="date" id="data_agendamento" name="data_agendamento" required>
        </div>
        
        <div class="form-group">
            <label for="hora_agendamento">Hora:</label>
            <input type="time" id="hora_agendamento" name="hora_agendamento" required>
        </div>
        
        <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes"></textarea>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Agendar">
        </div>
    </form>
    
    <p><a href="?route=meus-agendamentos">Ver meus agendamentos</a></p>
</div>

<?php include 'templates/footer.php'; ?>

