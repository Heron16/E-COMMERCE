<?php include 'templates/header.php'; ?>

<div class="content">
    <h1>Meus Agendamentos</h1>
    
    <p><a href="?route=agendar" class="btn">Novo Agendamento</a></p>
    
    <?php if (empty($agendamentos)): ?>
        <p>Você não possui agendamentos.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
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
                        <td><?php echo htmlspecialchars($agendamento['observacoes']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>

