-- plugins/xtradbrowusers/setup/xtradbrowusers.uninstall.sql
-- Удаляет таблицу cot_xtradbrowusers при деинсталляции плагина.
-- Удаляем таблицу переводов первой, затем основную (из-за внешнего ключа)

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

DROP TABLE IF EXISTS `cot_xtradbrowusers_i18n`;
DROP TABLE IF EXISTS `cot_xtradbrowusers`;
