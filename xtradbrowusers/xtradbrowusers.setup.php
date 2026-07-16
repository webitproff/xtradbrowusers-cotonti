<?php
/* ====================
[BEGIN_COT_EXT]
Code=xtradbrowusers
Name=Custom Extrafields Users
Description=Custom Extrafields for Users module stored in own table. Дополнительные поля пользователей в собственной таблице.
Version=1.0.0
Date=Jul 16, 2026
Author=webitproff
Copyright=Copyright (c) 2026 webitproff
Notes=BSD License
Auth_guests=R
Lock_guests=12345A
Auth_members=RW
Lock_members=
Requires_modules=users
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

/**
 * xtradbrowusers.setup.php - Register data in $db_core and $db_config. Setup & Config File for the Plugin xtradbrowusers
 *
 * xtradbrowusers plugin for Cotonti 0.9.26+, PHP 8.4+
 * Filename: xtradbrowusers.setup.php
 *
 * Date: Jul 16, 2026
 * @package xtradbrowusers
 * @version 1.0.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
 * @license BSD
 */

Cot::$db->registerTable('xtradbrowusers');