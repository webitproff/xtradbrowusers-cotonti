<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.tags
[END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.details.tags.php – Вывод на странице публичного профиля пользователя
 *
 * Purpose:   Подключается к хуку `users.details.tags`, который находится в файле
 *            /modules/users/inc/users.details.php. Через этот хук наш код
 *            добавляет экстраполя пользователя в шаблон users.details.tpl.
 *            Назначает индивидуальные теги:
 *            {USERS_DETAILS_XTRA_ИМЯПОЛЯ}, {USERS_DETAILS_XTRA_ИМЯПОЛЯ_TITLE},
 *            {USERS_DETAILS_XTRA_ИМЯПОЛЯ_VALUE}, а также дополнительные теги
 *            {USERS_DETAILS_XTRA_EXTRAFIELD_TITLE}, {USERS_DETAILS_XTRA_EXTRAFIELD_VALUE},
 *            {USERS_DETAILS_XTRA_EXTRAFIELD_NAME} и блок-цикл
 *            <!-- BEGIN: XTRA_EXTRAFLD --> для вывода всех полей.
 *
 *  Мультиязычность на публичной странице профиля:
 *   - select, radio, checklistbox:
 *       локализуются через языковые ключи вида $L[{field_name}_{value}].
 *       При наличии перевода в языковом файле плагина/темы сайта выводится он,
 *       иначе — исходное значение. Таблица xtradbrowusers_i18n не используется.
 *   - checkbox:
 *       хранит 1 или 0; локализация отображения («Да»/«Нет») выполняется
 *       в шаблоне отдельно.
 *   - input, textarea:
 *       при включённой опции мультиязычности (xtradbrowusers_i18n_use)
 *       значение может быть заменено переводом из xtradbrowusers_i18n,
 *       если перевод для текущего языка был сохранён.
 *   - inputint, double, datetime, range, file, country:
 *       код вызывает xtradbrowusers_i18n_get_value(), но поскольку
 *       интерфейс админки позволяет сохранять переводы только для input и textarea,
 *       в стандартном сценарии для этих типов возвращается оригинальное значение.
 *   - country дополнительно получает локализованное название через массив
 *       $cot_countries (файл стран), независимо от таблицы i18n.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.details.tags.php
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

if (!empty($urr['user_id'])) {
    // Загрузка стран
    $country_lang = cot_langfile('countries', 'core');
    if (file_exists($country_lang)) {
        include $country_lang;
    }

    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        $xtra_data = xtradbrowusers_load($urr['user_id']);
        if ($xtra_data) {
            // Типы, для которых встроенная локализация уже работает через $L
            $builtInI18nTypes = ['select', 'radio', 'checklistbox', 'checkbox'];

            foreach ($extrafields as $exfld) {
                $tag = mb_strtoupper($exfld['field_name']);
                $value = $xtra_data[$exfld['field_name']] ?? null;

                // Если мультиязычность включена и тип поля не имеет собственного перевода,
                // пытаемся подставить перевод из xtradbrowusers_i18n
                $displayValue = $value;
                if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use'])
                    && !in_array($exfld['field_type'], $builtInI18nTypes)) {
                    $displayValue = xtradbrowusers_i18n_get_value($urr['user_id'], $exfld['field_name'], $value);
                }

                $t->assign([
                    'USERS_DETAILS_XTRA_' . $tag             => cot_build_extrafields_data('xtra', $exfld, $displayValue),
                    'USERS_DETAILS_XTRA_' . $tag . '_TITLE'  => cot_extrafield_title($exfld, 'xtra_'),
                    'USERS_DETAILS_XTRA_' . $tag . '_VALUE'  => $displayValue,
                    'USERS_DETAILS_XTRA_EXTRAFIELD_TITLE'    => cot_extrafield_title($exfld, 'xtra_'),
                    'USERS_DETAILS_XTRA_EXTRAFIELD_VALUE'    => cot_build_extrafields_data('xtra', $exfld, $displayValue),
                    'USERS_DETAILS_XTRA_EXTRAFIELD_NAME'     => $exfld['field_name'],
                ]);

                // Название страны, если поле — country
                if ($exfld['field_type'] === 'country') {
                    $t->assign('USERS_DETAILS_XTRA_' . $tag . '_NAME', isset($cot_countries[$displayValue]) ? $cot_countries[$displayValue] : $displayValue);
                }

                $t->parse('MAIN.XTRA_EXTRAFLD');
            }
        } else {
            // Нет записи в xtradbrowusers – очищаем теги, чтобы избежать ошибок в шаблоне
            foreach ($extrafields as $exfld) {
                $tag = mb_strtoupper($exfld['field_name']);
                $t->assign([
                    'USERS_DETAILS_XTRA_' . $tag => '',
                    'USERS_DETAILS_XTRA_' . $tag . '_TITLE' => '',
                    'USERS_DETAILS_XTRA_' . $tag . '_VALUE' => '',
                    'USERS_DETAILS_XTRA_EXTRAFIELD_TITLE'   => '',
                    'USERS_DETAILS_XTRA_EXTRAFIELD_VALUE'   => '',
                    'USERS_DETAILS_XTRA_EXTRAFIELD_NAME'    => '',
                ]);
                if ($exfld['field_type'] === 'country') {
                    $t->assign('USERS_DETAILS_XTRA_' . $tag . '_NAME', '');
                }
                $t->parse('MAIN.XTRA_EXTRAFLD');
            }
        }
    }
}
