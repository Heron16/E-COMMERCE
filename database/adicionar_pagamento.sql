-- Adicionar campo de forma de pagamento na tabela agendamentos
-- Execute este script para atualizar o banco de dados com o sistema de pagamento

USE lavagem_veiculos;

-- Verificar e adicionar colunas de pagamento na tabela agendamentos
ALTER TABLE agendamentos 
ADD COLUMN IF NOT EXISTS forma_pagamento ENUM('pix', 'dinheiro', 'cartao') DEFAULT NULL AFTER valor_total,
ADD COLUMN IF NOT EXISTS pagamento_confirmado TINYINT(1) DEFAULT 0 AFTER forma_pagamento,
ADD COLUMN IF NOT EXISTS data_pagamento TIMESTAMP NULL AFTER pagamento_confirmado;

-- Criar tabela para armazenar informações de pagamento PIX
CREATE TABLE IF NOT EXISTS pagamentos_pix (
    id INT PRIMARY KEY AUTO_INCREMENT,
    agendamento_id INT NOT NULL,
    chave_pix VARCHAR(255) NOT NULL COMMENT 'Chave PIX (telefone, email, CPF, CNPJ ou aleatória)',
    qr_code_texto TEXT COMMENT 'Texto do QR Code PIX Copia e Cola',
    valor DECIMAL(10,2) NOT NULL,
    status ENUM('pendente', 'confirmado', 'cancelado') DEFAULT 'pendente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_confirmacao TIMESTAMP NULL,
    FOREIGN KEY (agendamento_id) REFERENCES agendamentos(id) ON DELETE CASCADE,
    INDEX idx_agendamento (agendamento_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- Mensagem de sucesso
SELECT 'Banco de dados atualizado com sucesso!' as Mensagem;
