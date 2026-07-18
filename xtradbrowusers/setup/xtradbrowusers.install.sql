-- xtradbrowusers
-- Filename: plugins/xtradbrowusers/setup/xtradbrowusers.install.sql
-- Установочный файл: plugins/xtradbrowusers/setup/xtradbrowusers.install.sql
-- Создаёт таблицу только с id (с первичным ключом "id", чтобы избежать авто-префикса "user_") 
-- все остальные столбцы будут добавлены через API Extrafields.
-- 
-- Custom Extrafields Users i18n plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
-- 
-- Date: Jul 18, 2026
-- package xtradbrowusers
-- version 1.1.1
-- author webitproff
-- copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
-- license BSD
-- 
-- Основная таблица с внешним ключом, без авто-префикса
CREATE TABLE IF NOT EXISTS `cot_xtradbrowusers` (
    `id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_xtradbrowusers_users` 
        FOREIGN KEY (`id`) REFERENCES `cot_users` (`user_id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица переводов значений экстраполей (мультиязычность)
CREATE TABLE IF NOT EXISTS `cot_xtradbrowusers_i18n` (
    `id` INT UNSIGNED NOT NULL,
    `field_name` VARCHAR(255) NOT NULL,
    `lang` CHAR(2) NOT NULL DEFAULT 'en',
    `value` TEXT,
    PRIMARY KEY (`id`, `field_name`, `lang`),
    CONSTRAINT `fk_xtradbrowusers_i18n` 
        FOREIGN KEY (`id`) REFERENCES `cot_xtradbrowusers` (`id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
