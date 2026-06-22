-- ============================================================
--  Brasil DNA — Estrutura do Banco de Dados
--  Banco: brasildna | Charset: utf8mb4
-- ============================================================

CREATE DATABASE IF NOT EXISTS `brasildna`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `brasildna`;

-- ------------------------------------------------------------
--  Tabela: admins
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id`         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `nome`       VARCHAR(120)     NOT NULL,
  `email`      VARCHAR(180)     NOT NULL,
  `senha`      VARCHAR(255)     NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admins_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Tabela: parceiros
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `parceiros` (
  `id`           INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `nome_empresa` VARCHAR(150)     NOT NULL,
  `email`        VARCHAR(180)     NOT NULL,
  `senha`        VARCHAR(255)     NOT NULL,
  `status`       ENUM('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente',
  `criado_em`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_parceiros_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Tabela: banners
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `banners` (
  `id`            INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `parceiro_id`   INT UNSIGNED         NULL,
  `nome_parceiro` VARCHAR(150)     NOT NULL,
  `logo_url`      VARCHAR(500)         NULL,
  `imagem_url`    VARCHAR(500)         NULL,
  `titulo`        VARCHAR(200)         NULL,
  `subtexto`      VARCHAR(300)         NULL,
  `botao_texto`   VARCHAR(80)      NOT NULL DEFAULT 'Saiba mais',
  `link_url`      VARCHAR(500)         NULL,
  `ativo`         TINYINT(1)       NOT NULL DEFAULT 0,
  `ordem`         INT              NOT NULL DEFAULT 0,
  `visualizacoes` INT UNSIGNED     NOT NULL DEFAULT 0,
  `cliques`       INT UNSIGNED     NOT NULL DEFAULT 0,
  `criado_em`     TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_banners_parceiro` (`parceiro_id`),
  KEY `idx_banners_ativo`    (`ativo`),
  CONSTRAINT `fk_banners_parceiro`
    FOREIGN KEY (`parceiro_id`) REFERENCES `parceiros` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  Tabela: posts
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
  `id`               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `titulo`           VARCHAR(250)     NOT NULL,
  `resumo`           TEXT                 NULL,
  `conteudo`         LONGTEXT             NULL,
  `regiao`           ENUM('Norte','Nordeste','Centro-Oeste','Sudeste','Sul') NULL,
  `status`           ENUM('rascunho','publicado') NOT NULL DEFAULT 'rascunho',
  `data_publicacao`  DATE                 NULL,
  `imagem`           VARCHAR(500)         NULL,
  `criado_em`        TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_posts_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
