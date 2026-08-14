<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.loop
[END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.loop.php – Вывод полей в списке пользователей (users.tpl)
 *
 * Purpose:   Подключается к хуку `users.loop`, который вызывается в файле
 *            /modules/users/inc/users.main.php на каждой итерации цикла вывода списка пользователей.
 *            Добавляет в шаблон users.tpl теги для каждого экстраполя:
 *            {USERS_ROW_XTRA_ИМЯПОЛЯ}, {USERS_ROW_XTRA_ИМЯПОЛЯ_TITLE},
 *            {USERS_ROW_XTRA_ИМЯПОЛЯ_VALUE}, а также универсальные теги
 *            {USERS_ROW_XTRA_EXTRAFLD} и {USERS_ROW_XTRA_EXTRAFLD_TITLE},
 *            которые позволяют выводить все поля через блок <!-- BEGIN: XTRA_EXTRAFLD -->.
 *            Для полей типа country дополнительно назначается тег _NAME
 *            с локализованным названием страны из файла стран.
 *
 * Мультиязычность в списке пользователей:
 *   - select, radio, checklistbox:
 *       локализуются через языковой массив $L (ключи вида $L[{field_name}_{value}]).
 *       Таблица xtradbrowusers_i18n не используется.
 *   - checkbox:
 *       хранит 1 или 0, локализация отображения («Да»/«Нет») выполняется в шаблоне.
 *   - input, textarea:
 *       при включённой мультиязычности значение может быть заменено переводом
 *       из таблицы xtradbrowusers_i18n, если перевод для текущего языка был сохранён.
 *   - inputint, double, datetime, range, file, country:
 *       код пытается подменить через xtradbrowusers_i18n_get_value(),
 *       но переводы для этих типов в админке не сохраняются, поэтому обычно
 *       выводится оригинальное значение.
 *   - country дополнительно получает локализованное название через массив
 *       $cot_countries (файл стран), независимо от таблицы i18n.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.loop.php
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
if (!empty($extrafields) && !empty($urr['user_id'])) {
    $xtra_data = xtradbrowusers_load($urr['user_id']);
    if ($xtra_data) {
        // Типы, для которых встроенная локализация уже работает через $L
        $builtInI18nTypes = ['select', 'radio', 'checklistbox', 'checkbox'];

        foreach ($extrafields as $exfld) {
            $tag = 'XTRA_' . strtoupper($exfld['field_name']);
            $value = $xtra_data[$exfld['field_name']] ?? null;

            // Подмена значения на перевод, если мультиязычность включена и тип поля не
            // поддерживает собственную языковую локализацию
            $displayValue = $value;
            if (!empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use'])
                && !in_array($exfld['field_type'], $builtInI18nTypes)) {
                $displayValue = xtradbrowusers_i18n_get_value($urr['user_id'], $exfld['field_name'], $value);
            }

            // Индивидуальные теги для каждого поля
            $t->assign([
                'USERS_ROW_' . $tag             => cot_build_extrafields_data('xtra', $exfld, $displayValue),
                'USERS_ROW_' . $tag . '_TITLE'  => cot_extrafield_title($exfld, 'xtra_'),
                'USERS_ROW_' . $tag . '_VALUE'  => $displayValue,
            ]);

            // === Универсальные теги для группового цикла ===
            // Чтобы работал блок <!-- BEGIN: XTRA_EXTRAFLD --> в users.tpl,
            // присваиваем значения тегам и вызываем parse() на каждой итерации.
            $t->assign([
                'USERS_ROW_XTRA_EXTRAFLD'       => cot_build_extrafields_data('xtra', $exfld, $displayValue),
                'USERS_ROW_XTRA_EXTRAFLD_TITLE' => cot_extrafield_title($exfld, 'xtra_'),
            ]);
            $t->parse('MAIN.USERS_ROW.XTRA_EXTRAFLD');
            // === Конец группового цикла ===

            // Название страны, если поле — country (используем оригинальный код страны)
            if ($exfld['field_type'] === 'country') {
                $country_lang = cot_langfile('countries', 'core');
                if (file_exists($country_lang)) {
                    include $country_lang;
                }
                // $value содержит код страны (ua, us), а не переведённое название
                $t->assign('USERS_ROW_' . $tag . '_NAME', isset($cot_countries[$value]) ? $cot_countries[$value] : $value);
            }
        }
    } else {
        // Если данных в xtradbrowusers нет, очищаем все теги
        foreach ($extrafields as $exfld) {
            $tag = 'XTRA_' . strtoupper($exfld['field_name']);
            $t->assign([
                'USERS_ROW_' . $tag             => '',
                'USERS_ROW_' . $tag . '_TITLE'  => '',
                'USERS_ROW_' . $tag . '_VALUE'  => '',
            ]);
            if ($exfld['field_type'] === 'country') {
                $t->assign('USERS_ROW_' . $tag . '_NAME', '');
            }
        }
        // Групповой блок XTRA_EXTRAFLD в этом случае не получит итераций
        // и не выведется — это корректно, пользователь не увидит пустых строк.
    }
}
