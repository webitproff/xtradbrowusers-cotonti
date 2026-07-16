<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.add.done
  [END_COT_EXT]
==================== */

/**
 * Сохранение данных после регистрации пользователя
 * Хук users.register.add.done. Сохраняет значения extrafields плагина xtradbrowusers
 * в таблицу cot_xtradbrowusers после успешной регистрации.
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

if (isset($userid) && $userid > 0) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        $data = [];
        foreach ($extrafields as $exfld) {
            $fieldName = $exfld['field_name'];
            $inputName = 'rxtra_' . $fieldName;
            $oldValue = '';
            $data[$fieldName] = cot_import_extrafields($inputName, $exfld, 'P', $oldValue, 'xtra_');
        }
        xtradbrowusers_save($userid, $data);
        // Перемещаем загруженные файлы в целевую папку
        cot_extrafield_movefiles();
    }
}