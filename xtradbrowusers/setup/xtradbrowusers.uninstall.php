<?php
/**
 * Filename: xtradbrowusers.uninstall.php – Полное удаление данных плагина при деинсталляции
 *
 * Удаляет:
 * - Все записи в таблице cot_extra_fields, относящиеся к таблице $db_xtradbrowusers
 * - Саму таблицу $db_xtradbrowusers (DROP TABLE IF EXISTS)
 * - Папку с загруженными файлами (datas/exflds/xtradbrowusers)
 *
 *
 * Custom Extrafields Users i18n plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
 *
 * Date: Jul 18, 2026
 * @package xtradbrowusers
 * @version 1.1.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Подключаем файл плагина для регистрации глобальных переменных ($db_xtradbrowusers)
require_once cot_incfile('xtradbrowusers', 'plug');

global $db, $db_extra_fields, $db_xtradbrowusers;

// 1. Удаляем все определения экстраполей для нашей таблицы
$db->delete($db_extra_fields, "field_location = ?", [$db_xtradbrowusers]);

// 2. Удаляем саму таблицу (на случай, если SQL-файл не сработал или префикс отличается)
$db->query("DROP TABLE IF EXISTS `{$db_xtradbrowusers}`");

// 3. Удаляем папку с файлами
$exfld_dir = 'datas/exflds/xtradbrowusers';
if (is_dir($exfld_dir)) {
    // Простая рекурсивная функция удаления директории
    function xtradbrowusers_removeDir($dir) {
        if (!is_dir($dir)) return;
        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = $dir . '/' . $item;
            is_dir($path) ? xtradbrowusers_removeDir($path) : unlink($path);
        }
        rmdir($dir);
    }
    xtradbrowusers_removeDir($exfld_dir);
}

/* 
// ВАРИАНТ 2
//  RecursiveIteratorIterator и RecursiveDirectoryIterator — это встроенные классы PHP 
// (являются частью SPL — Standard PHP Library), доступные всегда, без какого‑либо дополнительного кода. 
// Их не нужно ни объявлять, ни подключать — они работают «из коробки».

// 3. Удаляем папку с файлами экстраполей, если она существует
$exfld_dir = 'datas/exflds/xtradbrowusers';
if (is_dir($exfld_dir)) {
    // Рекурсивное удаление директории
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($exfld_dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $fileinfo) {
        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
        $todo($fileinfo->getRealPath());
    }
    rmdir($exfld_dir);
}

 */
