-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS vpn_db;
USE vpn_db;


-- Criação da tabela 'usuarios'
-- Campos:
-- - email: identificador único do usuário (login)
-- - nome: nome completo
-- - senha: hash da senha (password_hash - DEFAULT)
-- - ativo: se o usuário está ativo (1) ou não (0)

CREATE TABLE usuarios (
    email VARCHAR(255) PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    ativo BOOLEAN NOT NULL
);


-- Inserção de usuários de exemplo
INSERT INTO usuarios (email, nome, senha, ativo) VALUES
('admin@gmail.com', 'Administrador Padrão', '$2y$10$k21XjVO61dMuUyZVJkhZZu5spbn5kXeWEgSwsfp7bShbep65fHGmy', 1),
('arthur.gabriel@gmail.com', 'Arthur Gabriel', '$2y$10$bj22Do0m.PUy1fq.SHaTzOHk5DWrao1CBB4UoM29CyjTws3lHiQsi', 0);


-- Criação da tabela 'certificados'
-- Campos:
-- - id: identificador único de 7 caracteres
-- - data: data e hora da criação
-- - validade: data de expiração (7 dias após a criação)

CREATE TABLE certificados (
    id CHAR(7) PRIMARY KEY,
    data DATETIME NOT NULL,
    validade DATE NOT NULL
);


-- Inserção de certificados de exemplo
INSERT INTO certificados (id, data, validade) VALUES
('EL0O1TB', '2025-06-17 12:53:46', '2025-06-24'),
('APF1ZUO', '2025-06-17 22:47:34', '2025-06-24');
