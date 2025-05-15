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
INSERT INTO users (username, email, password, role) VALUES ('tes','tes@uns.com','$2y$12$QM4SuIrmdbyTSTRELuJDK.45xFT66Ml0Czj/RhY9r.KkDMKCzgGJm','admin')
/*untuk password admin tes adalah tes123*/
INSERT INTO users (username, email, password, role) VALUES ('iniadmin','admin@uns.com','$2y$12$FcNxol3DPtg06TC/.8TMwuvX/IMOiUsVJwsS4UOAY7rMxpbLuVJrG','admin')
/*untuk password admin iniadmin adalah admin123*/
