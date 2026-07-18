<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.profile.update.done
  [END_COT_EXT]
==================== */

/**
 * Файл xtradbrowusers.users.profile.update.done.php - Сохранение данных после обновления профиля пользователем
 * Хук users.profile.update.done. Сохраняет значения extrafields в cot_xtradbrowusers,
 * включая мультиязычные переводы, если они включены.
 *
 *
 * Custom Extrafields Users i18n plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
 *
 * Date: Jul 18, 2026
 * @package xtradbrowusers
 * @version 1.1.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
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
