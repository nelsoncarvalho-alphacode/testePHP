-- root / TestPassword
-- lauradamascenno / UserTestPassword

CREATE DATABASE bdVagas;
USE bdVagas;

CREATE TABLE vagas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    status ENUM('ativo', 'pausado') DEFAULT 'ativo'
);

CREATE TABLE candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20)    
);

CREATE TABLE inscricoes (
    candidato_id INT,
    vaga_id INT,
    FOREIGN KEY (candidato_id) REFERENCES candidatos(id),
    FOREIGN KEY (vaga_id) REFERENCES vagas(id),
    PRIMARY KEY (candidato_id, vaga_id)
);