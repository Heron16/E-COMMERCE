<<<<<<< HEAD
-- ==================================================
-- EXEMPLOS DE USO DAS PROCEDURES E FUNCTIONS
-- Sistema de Lavagem de Veículos
-- ==================================================

USE lavagem_veiculos;

-- ==================================================
-- EXEMPLOS DE PROCEDURES
-- ==================================================

-- 1. Inserir 10 serviços de teste na categoria 1
CALL sp_inserir_servicos_massivo(1, 10);

-- 2. Inserir 50 clientes de teste
CALL sp_inserir_clientes_massivo(50);

-- 3. Inserir 20 serviços na categoria 2
CALL sp_inserir_servicos_massivo(2, 20);

-- ==================================================
-- EXEMPLOS DE FUNCTIONS
-- ==================================================

-- 1. Verificar disponibilidade do serviço ID 1 para quantidade 5
SELECT fn_verificar_disponibilidade(1, 5) as status_disponibilidade;

-- 2. Verificar disponibilidade do serviço ID 1 para quantidade 1000 (deve retornar INDISPONIVEL)
SELECT fn_verificar_disponibilidade(1, 1000) as status_disponibilidade;

-- 3. Calcular valor do serviço ID 1 para moto (quantidade 1)
SELECT fn_calcular_valor_servico(1, 'moto', 1) as valor;

-- 4. Calcular valor do serviço ID 1 para carro (quantidade 2)
SELECT fn_calcular_valor_servico(1, 'carro', 2) as valor;

-- 5. Calcular valor do serviço ID 3 para camioneta (quantidade 1)
SELECT fn_calcular_valor_servico(3, 'camioneta', 1) as valor;

-- ==================================================
-- CONSULTAS ÚTEIS PARA TESTE
-- ==================================================

-- 1. Ver todos os serviços com preços
SELECT 
    id,
    nome,
    CONCAT('Moto: R$ ', preco_moto, ' | Carro: R$ ', preco_carro, ' | Camioneta: R$ ', preco_camioneta) as precos,
    estoque_disponivel
FROM servicos
WHERE ativo = 1
ORDER BY nome;

-- 2. Ver dashboard semanal
SELECT * FROM vw_dashboard_semanal;

-- 3. Ver serviços mais solicitados
SELECT * FROM vw_servicos_mais_solicitados;

-- 4. Ver auditoria de preços
SELECT 
    ap.id,
    s.nome as servico,
    ap.tipo_veiculo,
    CONCAT('R$ ', ap.preco_anterior) as preco_anterior,
    CONCAT('R$ ', ap.preco_novo) as preco_novo,
    ap.usuario,
    DATE_FORMAT(ap.data_alteracao, '%d/%m/%Y %H:%i:%s') as data_alteracao
FROM auditoria_precos ap
INNER JOIN servicos s ON ap.servico_id = s.id
ORDER BY ap.data_alteracao DESC;

-- 5. Relatório de agendamentos por status
SELECT 
    status,
    COUNT(*) as quantidade,
    SUM(valor_total) as receita_total
FROM agendamentos
GROUP BY status
ORDER BY quantidade DESC;

-- 6. Clientes com mais agendamentos
SELECT 
    c.nome,
    c.email,
    COUNT(a.id) as total_agendamentos,
    SUM(a.valor_total) as valor_total_gasto
FROM clientes c
INNER JOIN agendamentos a ON c.id = a.cliente_id
GROUP BY c.id, c.nome, c.email
ORDER BY total_agendamentos DESC
LIMIT 10;

-- 7. Serviços por categoria com estatísticas
SELECT 
    cs.nome as categoria,
    COUNT(s.id) as total_servicos,
    MIN(s.preco_carro) as menor_preco,
    MAX(s.preco_carro) as maior_preco,
    AVG(s.preco_carro) as preco_medio
FROM categorias_servicos cs
LEFT JOIN servicos s ON cs.id = s.categoria_id
WHERE s.ativo = 1
GROUP BY cs.id, cs.nome;

-- 8. Agendamentos por tipo de veículo
SELECT 
    tipo_veiculo,
    COUNT(*) as quantidade,
    AVG(valor_total) as ticket_medio
FROM agendamentos
GROUP BY tipo_veiculo
ORDER BY quantidade DESC;

-- 9. Performance por hora do dia
SELECT 
    HOUR(hora_agendamento) as hora,
    COUNT(*) as total_agendamentos
FROM agendamentos
GROUP BY HOUR(hora_agendamento)
ORDER BY hora;

-- 10. Relatório mensal completo
SELECT 
    DATE_FORMAT(data_agendamento, '%Y-%m') as mes_ano,
    COUNT(*) as total_agendamentos,
    SUM(CASE WHEN status = 'concluido' THEN 1 ELSE 0 END) as lavagens_concluidas,
    SUM(CASE WHEN status = 'cancelado' THEN 1 ELSE 0 END) as cancelamentos,
    SUM(CASE WHEN status IN ('concluido', 'confirmado') THEN valor_total ELSE 0 END) as receita
FROM agendamentos
GROUP BY DATE_FORMAT(data_agendamento, '%Y-%m')
ORDER BY mes_ano DESC;

-- ==================================================
-- TESTE DE TRIGGER DE AUDITORIA
-- ==================================================

-- Atualizar preço de um serviço para testar o trigger
UPDATE servicos 
SET preco_moto = 30.00, 
    preco_carro = 50.00, 
    preco_camioneta = 75.00
WHERE id = 1;

-- Ver registros de auditoria criados
SELECT * FROM auditoria_precos WHERE servico_id = 1 ORDER BY data_alteracao DESC;

-- ==================================================
-- ÍNDICES E PERFORMANCE
-- ==================================================

-- Ver índices criados
SHOW INDEX FROM servicos;
SHOW INDEX FROM agendamentos;
SHOW INDEX FROM clientes;

-- Analisar query performance
EXPLAIN SELECT * FROM agendamentos WHERE data_agendamento = '2025-10-27';
EXPLAIN SELECT * FROM servicos WHERE ativo = 1;
EXPLAIN SELECT * FROM clientes WHERE email = 'joao@email.com';

-- ==================================================
-- BACKUP E MANUTENÇÃO
-- ==================================================

-- Verificar tamanho das tabelas
SELECT 
    table_name AS 'Tabela',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Tamanho (MB)'
FROM information_schema.TABLES 
WHERE table_schema = 'lavagem_veiculos'
ORDER BY (data_length + index_length) DESC;

-- Otimizar tabelas
OPTIMIZE TABLE agendamentos;
OPTIMIZE TABLE agendamento_itens;
OPTIMIZE TABLE servicos;
OPTIMIZE TABLE clientes;

-- ==================================================
-- FIM DOS EXEMPLOS
-- ==================================================
=======
-- ==================================================
-- EXEMPLOS DE USO DAS PROCEDURES E FUNCTIONS
-- Sistema de Lavagem de Veículos
-- ==================================================

USE lavagem_veiculos;

-- ==================================================
-- EXEMPLOS DE PROCEDURES
-- ==================================================

-- 1. Inserir 10 serviços de teste na categoria 1
CALL sp_inserir_servicos_massivo(1, 10);

-- 2. Inserir 50 clientes de teste
CALL sp_inserir_clientes_massivo(50);

-- 3. Inserir 20 serviços na categoria 2
CALL sp_inserir_servicos_massivo(2, 20);

-- ==================================================
-- EXEMPLOS DE FUNCTIONS
-- ==================================================

-- 1. Verificar disponibilidade do serviço ID 1 para quantidade 5
SELECT fn_verificar_disponibilidade(1, 5) as status_disponibilidade;

-- 2. Verificar disponibilidade do serviço ID 1 para quantidade 1000 (deve retornar INDISPONIVEL)
SELECT fn_verificar_disponibilidade(1, 1000) as status_disponibilidade;

-- 3. Calcular valor do serviço ID 1 para moto (quantidade 1)
SELECT fn_calcular_valor_servico(1, 'moto', 1) as valor;

-- 4. Calcular valor do serviço ID 1 para carro (quantidade 2)
SELECT fn_calcular_valor_servico(1, 'carro', 2) as valor;

-- 5. Calcular valor do serviço ID 3 para camioneta (quantidade 1)
SELECT fn_calcular_valor_servico(3, 'camioneta', 1) as valor;

-- ==================================================
-- CONSULTAS ÚTEIS PARA TESTE
-- ==================================================

-- 1. Ver todos os serviços com preços
SELECT 
    id,
    nome,
    CONCAT('Moto: R$ ', preco_moto, ' | Carro: R$ ', preco_carro, ' | Camioneta: R$ ', preco_camioneta) as precos,
    estoque_disponivel
FROM servicos
WHERE ativo = 1
ORDER BY nome;

-- 2. Ver dashboard semanal
SELECT * FROM vw_dashboard_semanal;

-- 3. Ver serviços mais solicitados
SELECT * FROM vw_servicos_mais_solicitados;

-- 4. Ver auditoria de preços
SELECT 
    ap.id,
    s.nome as servico,
    ap.tipo_veiculo,
    CONCAT('R$ ', ap.preco_anterior) as preco_anterior,
    CONCAT('R$ ', ap.preco_novo) as preco_novo,
    ap.usuario,
    DATE_FORMAT(ap.data_alteracao, '%d/%m/%Y %H:%i:%s') as data_alteracao
FROM auditoria_precos ap
INNER JOIN servicos s ON ap.servico_id = s.id
ORDER BY ap.data_alteracao DESC;

-- 5. Relatório de agendamentos por status
SELECT 
    status,
    COUNT(*) as quantidade,
    SUM(valor_total) as receita_total
FROM agendamentos
GROUP BY status
ORDER BY quantidade DESC;

-- 6. Clientes com mais agendamentos
SELECT 
    c.nome,
    c.email,
    COUNT(a.id) as total_agendamentos,
    SUM(a.valor_total) as valor_total_gasto
FROM clientes c
INNER JOIN agendamentos a ON c.id = a.cliente_id
GROUP BY c.id, c.nome, c.email
ORDER BY total_agendamentos DESC
LIMIT 10;

-- 7. Serviços por categoria com estatísticas
SELECT 
    cs.nome as categoria,
    COUNT(s.id) as total_servicos,
    MIN(s.preco_carro) as menor_preco,
    MAX(s.preco_carro) as maior_preco,
    AVG(s.preco_carro) as preco_medio
FROM categorias_servicos cs
LEFT JOIN servicos s ON cs.id = s.categoria_id
WHERE s.ativo = 1
GROUP BY cs.id, cs.nome;

-- 8. Agendamentos por tipo de veículo
SELECT 
    tipo_veiculo,
    COUNT(*) as quantidade,
    AVG(valor_total) as ticket_medio
FROM agendamentos
GROUP BY tipo_veiculo
ORDER BY quantidade DESC;

-- 9. Performance por hora do dia
SELECT 
    HOUR(hora_agendamento) as hora,
    COUNT(*) as total_agendamentos
FROM agendamentos
GROUP BY HOUR(hora_agendamento)
ORDER BY hora;

-- 10. Relatório mensal completo
SELECT 
    DATE_FORMAT(data_agendamento, '%Y-%m') as mes_ano,
    COUNT(*) as total_agendamentos,
    SUM(CASE WHEN status = 'concluido' THEN 1 ELSE 0 END) as lavagens_concluidas,
    SUM(CASE WHEN status = 'cancelado' THEN 1 ELSE 0 END) as cancelamentos,
    SUM(CASE WHEN status IN ('concluido', 'confirmado') THEN valor_total ELSE 0 END) as receita
FROM agendamentos
GROUP BY DATE_FORMAT(data_agendamento, '%Y-%m')
ORDER BY mes_ano DESC;

-- ==================================================
-- TESTE DE TRIGGER DE AUDITORIA
-- ==================================================

-- Atualizar preço de um serviço para testar o trigger
UPDATE servicos 
SET preco_moto = 30.00, 
    preco_carro = 50.00, 
    preco_camioneta = 75.00
WHERE id = 1;

-- Ver registros de auditoria criados
SELECT * FROM auditoria_precos WHERE servico_id = 1 ORDER BY data_alteracao DESC;

-- ==================================================
-- ÍNDICES E PERFORMANCE
-- ==================================================

-- Ver índices criados
SHOW INDEX FROM servicos;
SHOW INDEX FROM agendamentos;
SHOW INDEX FROM clientes;

-- Analisar query performance
EXPLAIN SELECT * FROM agendamentos WHERE data_agendamento = '2025-10-27';
EXPLAIN SELECT * FROM servicos WHERE ativo = 1;
EXPLAIN SELECT * FROM clientes WHERE email = 'joao@email.com';

-- ==================================================
-- BACKUP E MANUTENÇÃO
-- ==================================================

-- Verificar tamanho das tabelas
SELECT 
    table_name AS 'Tabela',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Tamanho (MB)'
FROM information_schema.TABLES 
WHERE table_schema = 'lavagem_veiculos'
ORDER BY (data_length + index_length) DESC;

-- Otimizar tabelas
OPTIMIZE TABLE agendamentos;
OPTIMIZE TABLE agendamento_itens;
OPTIMIZE TABLE servicos;
OPTIMIZE TABLE clientes;

-- ==================================================
-- FIM DOS EXEMPLOS
-- ==================================================
>>>>>>> 6d2211e1183146ab30b22ae970e8c3384e7feec3
