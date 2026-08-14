<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.profile.update.done
  [END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.profile.update.done.php – Сохранение данных после обновления профиля пользователем
 *
 * Purpose:   Подключается к хуку `users.profile.update.done`, который вызывается после
 *            успешного обновления профиля пользователем в файле
 *            /modules/users/inc/users.profile.php.
 *            Сохраняет значения экстраполей плагина в таблицу `cot_xtradbrowusers`.
 *            Для каждого экстраполя значение импортируется через API extrafields
 *            с учётом типа, после чего вызывается `cot_extrafield_movefiles()`.
 *            Если включена мультиязычность, дополнительно сохраняет переводы
 *            для текстовых полей в таблицу `cot_xtradbrowusers_i18n`.
 *
 * Мультиязычность при сохранении:
 *   - Основные значения всех типов полей сохраняются всегда.
 *   - Переводы из формы сохраняются только для типов `input` и `textarea`.
 *   - Для select, radio, checklistbox, checkbox переводы не сохраняются,
 *     так как их локализация выполняется через языковой массив $L.
 *   - Для остальных типов (inputint, double, datetime, range, file, country)
 *     переводы также не сохраняются; отображается оригинальное значение.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.profile.update.done.php
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

$user_id = Cot::$usr['id'];
if ($user_id > 0) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        $xtra_data = xtradbrowusers_load($user_id) ?: [];
        $data = [];

        // 1. Сохраняем основные значения (оригинал) – с проверкой наличия в запросе
        foreach ($extrafields as $exfld) {
            $fieldName = $exfld['field_name'];
            $inputName = 'rxtra_' . $fieldName;
            $oldValue = $xtra_data[$fieldName] ?? '';
            // Проверяем, был ли отправлен соответствующий элемент формы
            if (isset($_POST[$inputName]) || (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE)) {
                $data[$fieldName] = cot_import_extrafields($inputName, $exfld, 'P', $oldValue, 'xtra_');
            } else {
                $data[$fieldName] = $oldValue; // поле не отправлено — сохраняем прежнее значение
            }
        }
        xtradbrowusers_save($user_id, $data);
        // Перемещаем загруженные файлы в целевую папку
        cot_extrafield_movefiles();

        // 2. Мультиязычные переводы (если включены)
        if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use'])) {
            $langDefault = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default'])
                ? Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default']
                : Cot::$cfg['defaultlang'];

            // Собираем массив активных дополнительных языков
            $activeLangs = [];
            if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_first_use'])
                && !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_first'])) {
                $activeLangs[] = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_first'];
            }
            if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_second_use'])
                && !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_second'])) {
                $activeLangs[] = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_second'];
            }

            // === Исправление (v1.1.1): сохраняем переводы только для текстовых типов ===
            $i18nAllowedTypes = ['input', 'textarea'];

            foreach ($extrafields as $exfld) {
                if (!in_array($exfld['field_type'], $i18nAllowedTypes)) {
                    continue; // пропускаем не-текстовые поля
                }
                $fieldName = $exfld['field_name'];
                foreach ($activeLangs as $lang) {
                    // Пропускаем язык по умолчанию – его значение уже в основной таблице
                    if ($lang === $langDefault) continue;

                    $i18nInputName = 'rxtra_' . $fieldName . '_' . $lang;
                    $i18nValue = cot_import($i18nInputName, 'P', 'HTM');
                    if ($i18nValue === null) continue; // поле не передавалось

                    xtradbrowusers_i18n_save($user_id, $fieldName, $lang, $i18nValue);
                }
            }
        }
    }
}
