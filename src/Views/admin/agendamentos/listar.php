<?php include '../../templates/header.php'; ?>

<div class="content">
    <h1>Gerenciar Agendamentos</h1>
    
    <?php if (empty($agendamentos)): ?>
        <p>Nenhum agendamento cadastrado.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($agendamento['usuario_nome']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['usuario_email']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['servico_nome']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($agendamento['data_agendamento'])); ?></td>
                        <td><?php echo date('H:i', strtotime($agendamento['hora_agendamento'])); ?></td>
                        <td>R$ <?php echo number_format($agendamento['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <span style="padding: 5px 10px; border-radius: 4px; 
                                <?php if ($agendamento['status'] === 'Confirmado'): ?>
                                    background-color: #d4edda; color: #155724;
                                <?php elseif ($agendamento['status'] === 'Cancelado'): ?>
                                    background-color: #f8d7da; color: #721c24;
                                <?php else: ?>
                                    background-color: #fff3cd; color: #856404;
                                <?php endif; ?>
                            ">
                                <?php echo $agendamento['status']; ?>
                            </span>
                        </td>
                        <td>
                            <a href="?route=admin-agendamentos-atualizar&id=<?php echo $agendamento['id']; ?>" class="btn">Editar</a>
                            <a href="?route=admin-agendamentos-deletar&id=<?php echo $agendamento['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../../templates/footer.php'; ?>

