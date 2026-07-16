<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.edit.update.done
  [END_COT_EXT]
==================== */

/**
 * Файл plugins/xtradbrowusers/xtradbrowusers.users.edit.update.done.php
 * Сохранение данных после редактирования пользователя администратором
 * Хук users.edit.update.done. Сохраняет значения extrafields в cot_xtradbrowusers.
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

if (isset($id) && $id > 0) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        $xtra_data = xtradbrowusers_load($id) ?: [];
        $data = [];
        foreach ($extrafields as $exfld) {
            $fieldName = $exfld['field_name'];
            $inputName = 'rxtra_' . $fieldName;
            $oldValue = $xtra_data[$fieldName] ?? '';
            $data[$fieldName] = cot_import_extrafields($inputName, $exfld, 'P', $oldValue, 'xtra_');
        }
        xtradbrowusers_save($id, $data);
        // Перемещаем загруженные файлы в целевую папку
        cot_extrafield_movefiles();
    }
}