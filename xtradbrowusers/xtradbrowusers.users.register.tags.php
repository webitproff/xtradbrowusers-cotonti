<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.tags
  [END_COT_EXT]
==================== */

/**
 * Вывод полей в форме регистрации пользователя
 * Хук users.register.tags. Отображает все extrafields плагина xtradbrowusers
 * с их пустыми или предзаполненными значениями в форме регистрации.
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

$extrafields = xtradbrowusers_getExtrafields();

if (!empty($extrafields)) {
    foreach ($extrafields as $exfld) {
        $fieldName = 'rxtra_' . $exfld['field_name'];
        $value = isset($ruser['xtra_' . $exfld['field_name']]) ? $ruser['xtra_' . $exfld['field_name']] : null;
        $element = cot_build_extrafields($fieldName, $exfld, $value);
        $title = cot_extrafield_title($exfld, 'xtra_');

        $t->assign([
            'USERS_REGISTER_XTRA_' . strtoupper($exfld['field_name'])             => $element,
            'USERS_REGISTER_XTRA_' . strtoupper($exfld['field_name']) . '_TITLE'  => $title,
            'USERS_REGISTER_XTRA_EXTRAFLD'                                        => $element,
            'USERS_REGISTER_XTRA_EXTRAFLD_TITLE'                                  => $title,
        ]);
        $t->parse('MAIN.XTRA_EXTRAFLD');
    }
}