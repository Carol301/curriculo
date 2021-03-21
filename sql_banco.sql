CREATE DATABASE files;
USE files;

CREATE TABLE uploaded_files (
    id   INT                 AUTO_INCREMENT PRIMARY KEY,
    mime VARCHAR (255)       NOT NULL,
    data LONGBLOB            NOT NULL,
    nome VARCHAR (255)       NOT NULL,
    email VARCHAR (225)      NOT NULL, 
    telefone VARCHAR (15)    NOT NULL,
    cargo VARCHAR (255)      NOT NULL,
    escolaridade INT         NOT NULL,
    observacoes LONGTEXT, 
    datahora DATETIME        NOT NULL,
    ip_cliente VARCHAR (255) NOT NULL 
);
