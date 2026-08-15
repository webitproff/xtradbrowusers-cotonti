<?php
/* ====================
[BEGIN_COT_EXT]
Code=xtradbrowusers
Name=Extrafields Users Custom i18n
Description=Custom Extrafields for Users module stored in own database table.
Category=administration-management
Version=1.2.9.1
Date=Aug 15, 2026
Author=webitproff
Copyright=Copyright (c) 2026 webitproff https://github.com/webitproff/
Notes=BSD License
Auth_members=RW
Lock_members=
Auth_guests=R
Lock_guests=12345A
Requires_modules=users
Requires_plugins=
Recommends_modules=
Recommends_plugins=usercategories
[END_COT_EXT]


[BEGIN_COT_EXT_CONFIG]
xtradbrowusers_i18n_use=01:radio::1:Мультиязычность полей активировать и использовать
xtradbrowusers_i18n_lang_code_default=02:string::ru:Код основного языка сайта (должен совпадать с <code>$cfg['defaultlang']</code>)
xtradbrowusers_i18n_lang_code_first=03:string::en:Код первого дополнительного языка
xtradbrowusers_i18n_lang_code_first_use=04:radio::1:Использовать первый дополнительный язык
xtradbrowusers_i18n_lang_code_second=05:string::ua:Код второго дополнительного языка
xtradbrowusers_i18n_lang_code_second_use=06:radio::0:Использовать второй дополнительный язык
perpage=09:string::5:Items per page in admin list
xtradbrowusers_showallitems=10:radio::1:Show all users (even without extrafields) in admin list
help_info=11:custom:xtradbrowusers_setup_help_block()::the reference information block
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');


/**
 * Filename: xtradbrowusers.setup.php 
 * Purpose: Register data in $db_core, $db_plugins and $db_config. Setup & Config File for the Plugin xtradbrowusers
 * Path: plugins/xtradbrowusers/xtradbrowusers.setup.php
 *
 * Extrafields Users Custom i18n plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4 
 *
 * Source and updates   https://github.com/webitproff/xtradbrowusers-cotonti
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/extrafields-users-custom 
 * Support:             https://abuyfile.com/ru/forums/cotonti/original/extrafields
 * API Extrafields:     https://github.com/Cotonti/Cotonti/blob/master/system/extrafields.php
 *
 * Date: Aug 15, 2026
 *
 * @package xtradbrowusers
 * @version 1.2.9.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */
 
 
