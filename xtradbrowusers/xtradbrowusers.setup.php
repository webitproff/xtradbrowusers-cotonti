<?php
/* ====================
[BEGIN_COT_EXT]
Code=xtradbrowusers
Name=Custom Extrafields Users i18n
Description=Custom Extrafields for Users module stored in own table.
Date=Jul 18, 2026
Author=webitproff
Copyright=Copyright (c) 2026 webitproff https://github.com/webitproff/
Notes=BSD License
Auth_guests=R
Lock_guests=12345A
Auth_members=RW
Lock_members=
Requires_modules=users
[END_COT_EXT]


[BEGIN_COT_EXT_CONFIG]
xtradbrowusers_i18n_use=01:radio::0:Мультиязычность полей активировать и использовать
xtradbrowusers_i18n_lang_code_default=02:string::ru:Код основного языка сайта (должен совпадать с <code>$cfg['defaultlang']</code>)
xtradbrowusers_i18n_lang_code_first=03:string::en:Код первого дополнительного языка
xtradbrowusers_i18n_lang_code_first_use=04:radio::1:Использовать первый дополнительный язык
xtradbrowusers_i18n_lang_code_second=05:string::ua:Код второго дополнительного языка
xtradbrowusers_i18n_lang_code_second_use=06:radio::1:Использовать второй дополнительный язык
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');


/**
 * xtradbrowusers.setup.php - Register data in $db_core and $db_config. Setup & Config File for the Plugin xtradbrowusers
 *
 * xtradbrowusers plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
 * Filename: xtradbrowusers.setup.php
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


