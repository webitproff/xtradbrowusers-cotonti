<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.tags
[END_COT_EXT]
==================== */

/**
 * Файл xtradbrowusers.users.details.tags.php - Вывод на странице публичного профиля пользователя (users.details.tpl)
 * Хук users.details.tags. Позволяет вывести все поля через блок <!-- BEGIN: XTRA_EXTRAFLD -->,
 * а также назначает индивидуальные теги {USERS_DETAILS_XTRA_ИМЯПОЛЯ}
 *
 * С версии 1.1.1 добавлена поддержка мультиязычности:
 *  - для типов, не имеющих встроенной локализации (input, textarea, double, inputint,
 *    datetime, range, file, country), значение автоматически подменяется переводом
 *    из таблицы xtradbrowusers_i18n, если он существует для текущего языка.
 *  - для select, radio, checklistbox по‑прежнему используется языковой массив $L.
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
