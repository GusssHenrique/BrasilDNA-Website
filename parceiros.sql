-- Sistema de Parceiros — BrasilDNA
-- Execute no phpMyAdmin sobre o banco `brasildna`, nessa ordem.

-- 1. Tabela de parceiros
CREATE TABLE IF NOT EXISTS `parceiros` (
  `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nome_empresa` VARCHAR(255) NOT NULL,
  `email`        VARCHAR(255) NOT NULL UNIQUE,
  `senha`        VARCHAR(255) NOT NULL,
  `status`       ENUM('pendente','aprovado','rejeitado') NOT NULL DEFAULT 'pendente',
  `criado_em`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Estender tabela banners (parceiro_id, visualizacoes, cliques)
ALTER TABLE `banners`
  ADD COLUMN `parceiro_id`    INT UNSIGNED DEFAULT NULL   AFTER `ordem`,
  ADD COLUMN `visualizacoes`  INT UNSIGNED NOT NULL DEFAULT 0 AFTER `parceiro_id`,
  ADD COLUMN `cliques`        INT UNSIGNED NOT NULL DEFAULT 0 AFTER `visualizacoes`,
  ADD CONSTRAINT `fk_banners_parceiro`
      FOREIGN KEY (`parceiro_id`) REFERENCES `parceiros`(`id`) ON DELETE SET NULL;
