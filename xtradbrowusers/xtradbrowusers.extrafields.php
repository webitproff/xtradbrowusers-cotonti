<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.extrafields.php – Register custom table in Extrafields administration
 *
 * Purpose:   регистрирует таблицу `cot_xtradbrowusers` в списке доступных таблиц
 *            для управления экстраполями через админ-панель Cotonti.
 *            Файл выполняется на хуке `admin.extrafields.first` и добавляет
 *            запись в `$extra_whitelist`, после чего таблица появляется
 *            в интерфейсе «Extrafields» как объект для добавления/редактирования полей.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.extrafields.php
 *
 * Extrafields Users Custom i18n plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
 *
 * Source and updates   https://github.com/webitproff/xtradbrowusers-cotonti
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/extrafields-users-custom
 * Support:             https://abuyfile.com/ru/forums/cotonti/original/extrafields
 * API Extrafields:     https://github.com/Cotonti/Cotonti/blob/master/system/extrafields.php
 *
 * Date: Aug 14, 2026
 *
 * @package xtradbrowusers
 * @version 1.2.9
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */
 
defined('COT_CODE') or die('Wrong URL.');
require_once cot_incfile('xtradbrowusers', 'plug');

$extra_whitelist[$db_xtradbrowusers] = [
    'name'    => $db_xtradbrowusers,
    'caption' => $L['xtradbrowusers'],
    'type'    => 'plug',
    'code'    => 'xtradbrowusers',
    'tags'    => [
        'users.profile.tpl'  => '{USERS_PROFILE_XTRA_XXXXX}, {USERS_PROFILE_XTRA_XXXXX_TITLE}',
        'users.edit.tpl'     => '{USERS_EDIT_XTRA_XXXXX}, {USERS_EDIT_XTRA_XXXXX_TITLE}',
        'users.details.tpl'  => '{USERS_DETAILS_XTRA_XXXXX}, {USERS_DETAILS_XTRA_XXXXX_TITLE}',
        'users.register.tpl' => '{USERS_REGISTER_XTRA_XXXXX}, {USERS_REGISTER_XTRA_XXXXX_TITLE}',
        'users.tpl'          => '{USERS_ROW_XTRA_XXXXX}, {USERS_ROW_XTRA_XXXXX_TITLE}',
        'header.tpl'         => '{USERS_HEADER_XTRA_XXXXX}, {USERS_HEADER_XTRA_TITLE}',
    ]
];
