<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=header.tags
  [END_COT_EXT]
==================== */

/**
 * Файл plugins/xtradbrowusers/xtradbrowusers.header.tags.php - Добавление тегов XTRA в header.tpl
 * Хук header.tags. Присваивает теги {USERS_HEADER_XTRA_XXXXX} и {USERS_HEADER_XTRA_XXXXX_TITLE}
 * для использования в <title>, мета-описании и т.д. на страницах, где определён $urr.
 *
 * С версии 1.1.1 добавлена поддержка мультиязычности:
 *  - для типов без встроенной локализации (input, textarea, double, inputint и т.д.)
 *    значение подменяется переводом из xtradbrowusers_i18n, если он существует для текущего языка.
 *  - для select, radio, checklistbox по‑прежнему используется языковой массив $L.
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

// Работаем только если есть переменная $urr (пользователь на странице профиля/редактирования)
if (!empty($urr['user_id'])) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        $xtra_data = xtradbrowusers_load($urr['user_id']);
        if ($xtra_data) {
            // Загрузка названий стран
            $country_lang = cot_langfile('countries', 'core');
            if (file_exists($country_lang)) {
                include $country_lang;
            }

            // Типы, для которых встроенная локализация уже работает через $L
            $builtInI18nTypes = ['select', 'radio', 'checklistbox', 'checkbox'];

            foreach ($extrafields as $exfld) {
                $tag = mb_strtoupper($exfld['field_name']);
                $value = $xtra_data[$exfld['field_name']] ?? null;

                // Подмена значения на перевод, если мультиязычность включена и тип поля не
                // поддерживает собственную языковую локализацию
                $displayValue = $value;
                if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use'])
                    && !in_array($exfld['field_type'], $builtInI18nTypes)) {
                    $displayValue = xtradbrowusers_i18n_get_value($urr['user_id'], $exfld['field_name'], $value);
                }

                $t->assign([
                    'USERS_HEADER_XTRA_' . $tag              => cot_build_extrafields_data('xtra', $exfld, $displayValue),
                    'USERS_HEADER_XTRA_' . $tag . '_TITLE'   => cot_extrafield_title($exfld, 'xtra_'),
                    'USERS_HEADER_XTRA_' . $tag . '_VALUE'   => $displayValue,
                ]);

                // Название страны, если поле — country (используем оригинальный код страны)
                if ($exfld['field_type'] === 'country') {
                    // $value содержит код страны (ua, us), а не переведённое название
                    $countryName = isset($cot_countries[$value]) ? $cot_countries[$value] : $value;
                    $t->assign('USERS_HEADER_XTRA_' . $tag . '_NAME', $countryName);
                }
            }
        } else {
            // Нет данных в нашей таблице — сбрасываем теги, чтобы избежать неопределённых
            foreach ($extrafields as $exfld) {
                $tag = mb_strtoupper($exfld['field_name']);
                $t->assign([
                    'USERS_HEADER_XTRA_' . $tag              => '',
                    'USERS_HEADER_XTRA_' . $tag . '_TITLE'   => '',
                    'USERS_HEADER_XTRA_' . $tag . '_VALUE'   => '',
                ]);
                if ($exfld['field_type'] === 'country') {
                    $t->assign('USERS_HEADER_XTRA_' . $tag . '_NAME', '');
                }
            }
        }
    }
}
