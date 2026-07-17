<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.delete.done
  [END_COT_EXT]
==================== */

/**
 * Файл xtradbrowusers.users.delete.done.php. Удаление связанных данных при удалении пользователя
 * Хук users.delete.done. Вызывается после удаления пользователя из таблицы cot_users.
 * Удаляет соответствующую запись в таблице cot_xtradbrowusers, а также файлы, загруженные
 * через экстраполя.
 *
 * Date: Jul 17, 2026
 * @package xtradbrowusers
 * @version 1.0.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');
require_once cot_incfile('xtradbrowusers', 'plug');

if (isset($id) && $id > 0) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        // Загружаем данные записи, чтобы удалить файлы перед удалением строки
        $xtra_data = xtradbrowusers_load($id);
        if ($xtra_data) {
            foreach ($extrafields as $exfld) {
                $fieldValue = $xtra_data[$exfld['field_name']] ?? null;
                cot_extrafield_unlinkfiles($fieldValue, $exfld);
            }
        }
    }
    // Удаляем запись по первичному ключу "id" (каскадно удалит переводы из _i18n)
    Cot::$db->delete(Cot::$db->xtradbrowusers, "id = ?", [$id]);
}
