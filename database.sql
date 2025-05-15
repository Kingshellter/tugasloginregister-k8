-- Buat database
CREATE DATABASE IF NOT EXISTS database_k8;
USE database_k8;
-- Buat tabel users

CREATE table users (
    id INT, 
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100),
    role ENUM('admin','user') default 'user',
    created_at TIMESTAMP default CURRENT_TIMESTAMP
);

-- Insert admin default
INSERT INTO users (username, email, password, role) VALUES ('tes','tes@uns.com','tes123','admin')
INSERT INTO users (username, email, password, role) VALUES ('iniadmin','admin@uns.com','admin123','admin')

