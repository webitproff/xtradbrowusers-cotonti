<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
[END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.usertags.php – Overrides user tags in cot_generate_usertags() function
 *
 * Purpose:   Подключается к хуку `usertags.main`, который вызывается внутри функции
 *            cot_generate_usertags() (system/functions.php). Добавляет в массив $temp_array
 *            теги для всех экстраполей плагина. После обработки они становятся доступны
 *            с любым префиксом (например, {PAGE_OWNER_XTRA_ИМЯПОЛЯ}, {FORUMS_POSTS_ROW_USER_XTRA_ИМЯПОЛЯ}
 *            и т.п.) в зависимости от вызова cot_generate_usertags().
 *            Также добавляются теги _TITLE и _VALUE, а для поля country — _NAME.
 *
 * Мультиязычность:
 *   - select, radio, checklistbox: локализуются через языковой массив $L
 *     (ключи вида $L[{field_name}_{value}]). Таблица xtradbrowusers_i18n не используется.
 *   - checkbox: хранит 1/0, локализация отображения выполняется в шаблоне.
 *   - input, textarea: при включённой мультиязычности значение может быть заменено
 *     переводом из таблицы xtradbrowusers_i18n, если перевод для текущего языка был сохранён.
 *   - inputint, double, datetime, range, file, country: вызывается
 *     xtradbrowusers_i18n_get_value(), но переводы для этих типов в админке не сохраняются,
 *     поэтому в стандартном сценарии возвращается оригинальное значение.
 *   - country дополнительно получает локализованное название через массив $cot_countries
 *     (файл стран), независимо от таблицы i18n.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.usertags.php
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
 * @version 1.2.9.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 *
 * @see cot_generate_usertags()
 * Хук usertags.main вызывается внутри функции cot_generate_usertags().
 * Переменные $temp_array и $user_data доступны напрямую, без объявления global.
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('xtradbrowusers', 'plug');
$extrafields = xtradbrowusers_getExtrafields();
if (!empty($extrafields) && !empty($user_data['user_id'])) {
    $xtra_data = xtradbrowusers_load($user_data['user_id']);
    if ($xtra_data) {
        // Типы, для которых встроенная локализация уже работает через $L
        $builtInI18nTypes = ['select', 'radio', 'checklistbox', 'checkbox'];

        foreach ($extrafields as $exfld) {
            $tag = strtoupper($exfld['field_name']);
            $value = $xtra_data[$exfld['field_name']] ?? null;

            // Подмена значения на перевод, если мультиязычность включена и тип поля не
            // поддерживает собственную языковую локализацию
            $displayValue = $value;
            if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use'])
                && !in_array($exfld['field_type'], $builtInI18nTypes)) {
                $displayValue = xtradbrowusers_i18n_get_value($user_data['user_id'], $exfld['field_name'], $value);
            }

            $temp_array['XTRA_' . $tag] = cot_build_extrafields_data('xtra', $exfld, $displayValue);
            $temp_array['XTRA_' . $tag . '_TITLE'] = cot_extrafield_title($exfld, 'xtra_');
            $temp_array['XTRA_' . $tag . '_VALUE'] = $displayValue;

            // Название страны, если поле — country (используем оригинальный код страны)
            if ($exfld['field_type'] === 'country') {
                $country_lang = cot_langfile('countries', 'core');
                if (file_exists($country_lang)) {
                    include $country_lang;
                }
                // $value содержит код страны (ua, us), а не переведённое название
                $temp_array['XTRA_' . $tag . '_NAME'] = isset($cot_countries[$value]) ? $cot_countries[$value] : $value;
            }
        }
    } else {
        foreach ($extrafields as $exfld) {
            $tag = strtoupper($exfld['field_name']);
            $temp_array['XTRA_' . $tag] = '';
            $temp_array['XTRA_' . $tag . '_TITLE'] = '';
            $temp_array['XTRA_' . $tag . '_VALUE'] = '';
            if ($exfld['field_type'] === 'country') {
                $temp_array['XTRA_' . $tag . '_NAME'] = '';
            }
        }
    }
}
