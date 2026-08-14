<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.tags
  [END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.register.tags.php – Вывод полей в форме регистрации пользователя
 *
 * Purpose:   Подключается к хуку `users.register.tags`, который вызывается в файле
 *            /modules/users/inc/users.register.php перед парсингом шаблона регистрации.
 *            Отображает все экстраполя плагина в форме регистрации пользователя.
 *            Назначает теги вида:
 *            {USERS_REGISTER_XTRA_ИМЯПОЛЯ}, {USERS_REGISTER_XTRA_ИМЯПОЛЯ_TITLE},
 *            а также общий тег {USERS_REGISTER_XTRA_EXTRAFLD} и
 *            {USERS_REGISTER_XTRA_EXTRAFLD_TITLE}.
 *            Значения полей берутся из $ruser (если есть) или null.
 *
 * Мультиязычность на этапе регистрации:
 *   - Данный файл не выводит поля для переводов.
 *   - Сохраняются только основные значения экстраполей.
 *   - Локализация select, radio, checklistbox осуществляется через языковой массив $L;
 *     i18n-переводы из таблицы xtradbrowusers_i18n на этом этапе не используются.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.register.tags.php
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
