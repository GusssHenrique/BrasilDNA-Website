-- Execute este script no phpMyAdmin (banco: brasildna)
CREATE TABLE IF NOT EXISTS `banners` (
  `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome_parceiro` VARCHAR(255) NOT NULL,
  `logo_url`      VARCHAR(500) DEFAULT NULL,
  `imagem_url`    VARCHAR(500) DEFAULT NULL,
  `titulo`        VARCHAR(255) DEFAULT NULL,
  `subtexto`      VARCHAR(500) DEFAULT NULL,
  `botao_texto`   VARCHAR(100) NOT NULL DEFAULT 'Learn More',
  `link_url`      VARCHAR(500) DEFAULT NULL,
  `ativo`         TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `ordem`         SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `criado_em`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
