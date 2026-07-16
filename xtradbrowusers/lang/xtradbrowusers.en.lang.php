<?php
/**
 * English Language File for xtradbrowusers Plugin
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

$L['info_desc'] = 'Plugin adds extra fields for users stored in its own database table';

$L['info_notes'] = 
    'Beginners are advised to study the ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Introduction. Description and principles of extra fields in Cotonti" class="initialism">' .
    '<strong>forum section about the ExtraFields API</strong></abbr></a>. <br>' . 
    'After installing the plugin, open the extra fields of the plugin ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';

$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Profile editing</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Public profile</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Administrator, for the user card, it is recommended to use individual output of additional fields for flexible customization';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Admin edit</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. User list</span>';