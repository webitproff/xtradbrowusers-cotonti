<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
==================== */

/**
 * xtradbrowusers Plugin: Register custom table in Extrafields administration
 *
 * Date: Jul 16, 2026
 * @package xtradbrowusers
 * @version 1.0.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
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