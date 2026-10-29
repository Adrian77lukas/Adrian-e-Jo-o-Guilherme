CREATE DATABASE IF NOT EXISTS bd_herodex_mvc
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bd_herodex_mvc;

CREATE TABLE IF NOT EXISTS personagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  universo VARCHAR(100) NOT NULL,
  poder VARCHAR(100) NOT NULL,
  categoria VARCHAR(30) NOT NULL DEFAULT 'Outro',
  descricao VARCHAR(500) NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO personagens (nome, universo, poder, categoria, descricao) VALUES
('Homem-Aranha', 'Marvel', 'Agilidade e sentido-aranha', 'Herói', 'Um herói que usa suas habilidades para proteger a cidade.'),
('Ravena', 'DC Comics', 'Magia e telecinese', 'Herói', 'Controla energia e poderes místicos.'),
('Loki', 'Marvel', 'Ilusão e metamorfose', 'Vilão', 'Mestre da trapaça e das ilusões.'),
('Sonic', 'Sega', 'Supervelocidade', 'Herói', 'O ouriço azul conhecido por sua velocidade.'),
('Darth Vader', 'Star Wars', 'A Força', 'Vilão', 'Um dos personagens mais conhecidos da galáxia.'),
('Geralt de Rívia', 'The Witcher', 'Combate e sinais mágicos', 'Anti-herói', 'Caçador de monstros treinado desde jovem.');
