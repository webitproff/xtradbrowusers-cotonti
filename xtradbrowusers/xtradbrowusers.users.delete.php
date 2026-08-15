<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.delete
[END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.delete.php – Очистка данных до удаления пользователя
 *
 * Purpose:   Подключается к хуку `users.delete`, который вызывается в методе
 *            UsersControlService::delete() до удаления пользователя из cot_users.
 *            Благодаря этому мы можем загрузить запись экстраполей, удалить файлы
 *            (тип file) через API extrafields и затем удалить строку из
 *            cot_xtradbrowusers. Если бы мы использовали users.delete.done,
 *            запись уже была бы удалена каскадным внешним ключом.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.delete.php
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
 * @version 1.2.9
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');
require_once cot_incfile('xtradbrowusers', 'plug');

// ID удаляемого пользователя доступен в $id
$userId = (int)($id ?? 0);
if ($userId > 0) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        // Получаем данные до удаления пользователя
        $xtra_data = xtradbrowusers_load($userId);
        if ($xtra_data) {
            foreach ($extrafields as $exfld) {
                $fieldValue = $xtra_data[$exfld['field_name']] ?? null;
                cot_extrafield_unlinkfiles($fieldValue, $exfld);
            }
        }
    }

    // Удаляем нашу запись до каскадного удаления
    Cot::$db->delete(Cot::$db->xtradbrowusers, 'id = :userId', ['userId' => $userId]);
}