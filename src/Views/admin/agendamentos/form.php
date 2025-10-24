<?php include '../../templates/header.php'; ?>

<div class="content">
    <h1>Editar Agendamento</h1>
    
    <?php if (!isset($agendamento)): ?>
        <p>Agendamento não encontrado.</p>
        <a href="?route=admin-agendamentos" class="btn">Voltar</a>
    <?php else: ?>
        <form method="POST" action="?route=admin-agendamentos-atualizar">
            <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">
            
            <div class="form-group">
                <label>Cliente:</label>
                <p><strong><?php echo htmlspecialchars($agendamento['usuario_nome']); ?></strong></p>
            </div>
            
            <div class="form-group">
                <label>Serviço:</label>
                <p><strong><?php echo htmlspecialchars($agendamento['servico_nome']); ?></strong></p>
            </div>
            
            <div class="form-group">
                <label for="data_agendamento">Data:</label>
                <input type="date" id="data_agendamento" name="data_agendamento" value="<?php echo $agendamento['data_agendamento']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="hora_agendamento">Hora:</label>
                <input type="time" id="hora_agendamento" name="hora_agendamento" value="<?php echo $agendamento['hora_agendamento']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Pendente" <?php echo $agendamento['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Confirmado" <?php echo $agendamento['status'] === 'Confirmado' ? 'selected' : ''; ?>>Confirmado</option>
                    <option value="Cancelado" <?php echo $agendamento['status'] === 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="observacoes">Observações:</label>
                <textarea id="observacoes" name="observacoes"><?php echo htmlspecialchars($agendamento['observacoes']); ?></textarea>
            </div>
            
            <div class="form-group">
                <input type="submit" value="Atualizar">
                <a href="?route=admin-agendamentos" class="btn">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>

