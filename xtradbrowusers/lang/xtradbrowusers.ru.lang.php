<?php
/**
 * Russian Language File for xtradbrowusers Plugin
 *
 * Date: Jul 16, 2026
 * @package xtradbrowusers
 * @version 1.0.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

global $db_xtradbrowusers;

$main_url = rtrim(Cot::$cfg['mainurl'], '/');
$url = $main_url . '/' . cot_url('admin', 'm=extrafields&n=' . $db_xtradbrowusers, '', true);

$L['xtradbrowusers'] = 'Custom Extrafields Users';

/**
 * Plugin Info
 */
$L['info_name'] = 'Extrafields Users Custom';

$L['info_desc'] = 'Плагин добавляет дополнительные поля для пользователей в собственную таблицу БД';

$L['info_notes'] = 
    'Новичкам ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Введение. Описание и принципы работы экстраполей в Cotonti" class="initialism">' .
    '<strong>обязательно читать раздел форума об API ExtraFields</strong></abbr></a>. <br>' . 
    'После установки плагина, открыть экстраполя плагина ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';
    
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Редактирование профиля</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Публичный профиль</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Администратор, для карточки пользователя, рекомендуется использовать именно индивидуальный вывод дополнительных полей для их гибкой кастомизации';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Админ-редактирование</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Список пользователей</span>';