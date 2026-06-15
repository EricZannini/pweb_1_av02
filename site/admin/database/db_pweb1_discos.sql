-- banco de dados da loja de discos

CREATE DATABASE IF NOT EXISTS `db_pweb1_discos` DEFAULT CHARACTER SET utf8mb4;
USE `db_pweb1_discos`;

CREATE TABLE IF NOT EXISTS `discos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `artista` varchar(100) NOT NULL,
  `genero` varchar(80) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `ano_lancamento` year NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `artistas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `nacionalidade` varchar(80) NOT NULL,
  `estilo_musical` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_nome` varchar(100) NOT NULL,
  `disco_titulo` varchar(150) NOT NULL,
  `quantidade` int NOT NULL,
  `data_venda` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`nome`, `telefone`, `email`, `login`, `senha`) VALUES
('Administrador', '(49) 99999-0000', 'admin@vinylstore.com', 'admin', '$2y$10$ny12Hy1HvEJhG98wcGfr8ubyB3NjZZeTqHlK7U2GeG4qvnPlkYhAi');

INSERT INTO `discos` (`titulo`, `artista`, `genero`, `preco`, `ano_lancamento`) VALUES
('Abbey Road', 'The Beatles', 'Rock', 89.90, 1969),
('Thriller', 'Michael Jackson', 'Pop', 79.90, 1982),
('Back in Black', 'AC/DC', 'Rock', 74.90, 1980),
('Rumours', 'Fleetwood Mac', 'Rock', 69.90, 1977),
('Dark Side of the Moon', 'Pink Floyd', 'Rock Progressivo', 94.90, 1973);

INSERT INTO `artistas` (`nome`, `nacionalidade`, `estilo_musical`) VALUES
('The Beatles', 'Britânica', 'Rock'),
('Michael Jackson', 'Americana', 'Pop'),
('AC/DC', 'Australiana', 'Rock'),
('Fleetwood Mac', 'Britânica', 'Rock'),
('Pink Floyd', 'Britânica', 'Rock Progressivo');

INSERT INTO `vendas` (`cliente_nome`, `disco_titulo`, `quantidade`, `data_venda`) VALUES
('João Silva', 'Abbey Road', 1, '2026-06-01'),
('Maria Souza', 'Thriller', 2, '2026-06-03'),
('Carlos Pereira', 'Back in Black', 1, '2026-06-10');
