<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.delete.done
  [END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.delete.done.php – Удаление связанных данных при удалении пользователя
 * Хук users.delete.done. Вызывается после удаления пользователя из таблицы cot_users.
 * Файл с расположением хука: modules/users/inc/UsersControlService.php
 *             foreach (cot_getextplugins('users.delete.done') as $pl) {
 *                 include $pl;
 *             }
 * Через наш объявленный хук в заголовке xtradbrowusers.users.delete.done.php 
 * подключаем наш код к файлу UsersControlService.php
 * Он удаляет соответствующую запись в таблице cot_xtradbrowusers, 
 * а также файлы, загруженные через экстраполя.
 *
 * Purpose:   Подключается к хуку `users.delete.done` и выполняет код очистки после удаления пользователя.
 *            Загружает запись экстраполей пользователя, удаляет связанные файлы (тип `file`)
 *            через API extrafields, затем удаляет строку из `cot_xtradbrowusers`.
 *            Благодаря внешнему ключу `ON DELETE CASCADE` переводы из `cot_xtradbrowusers_i18n`
 *            удаляются автоматически.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.delete.done.php
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
