

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') DEFAULT 'cliente'
    
);

CREATE TABLE IF NOT EXISTS servicos (
    id_servicos INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    duracao_minutos INT DEFAULT 30
    
);

CREATE TABLE IF NOT EXISTS agendamentos (
    id_agendamentos INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_servicos INT NOT NULL,
    data_agendamento DATE NOT NULL,
    hora_agendamento TIME NOT NULL,
    status_agendamento ENUM('Pendente', 'Confirmado', 'Cancelado') DEFAULT 'Pendente',
    observacoes TEXT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ,
    FOREIGN KEY (id_servicos) REFERENCES servicos(id_servicos)
);

CREATE TABLE LOGS_ALTERACAO_PRECO (

    id_logs INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario int NOT NULL ,
    id_servicos INT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    valor_antigo DECIMAL(10, 2),
    valor_novo DECIMAL(10, 2),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ,
    FOREIGN KEY (id_servicos) REFERENCES servicos(id_servicos)


);


!