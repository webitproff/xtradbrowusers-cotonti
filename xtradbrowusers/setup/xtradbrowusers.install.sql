-- xtradbrowusers
-- plugins/xtradbrowusers/setup/xtradbrowusers.install.sql
-- Установочный файл: plugins/xtradbrowusers/setup/xtradbrowusers.install.sql
-- Создаёт таблицу только с user_id – все остальные столбцы будут добавлены через API Extrafields.

-- plugins/xtradbrowusers/setup/xtradbrowusers.install.sql
-- Создаёт таблицу с первичным ключом "id", чтобы избежать авто-префикса "user_"

CREATE TABLE IF NOT EXISTS `cot_xtradbrowusers` (
    `id` int UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_xtradbrowusers_users` 
        FOREIGN KEY (`id`) 
        REFERENCES `cot_users` (`user_id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;