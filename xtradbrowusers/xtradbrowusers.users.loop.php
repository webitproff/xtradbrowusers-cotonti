<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.loop
[END_COT_EXT]
==================== */

/**
 * Файл plugins/xtradbrowusers/xtradbrowusers.users.loop.php
 * Вывод полей в списке пользователей (users.tpl)
 * Хук users.loop. Добавляет теги {USERS_ROW_XTRA_XXXXX} и {USERS_ROW_XTRA_XXXXX_TITLE} для каждой строки списка.
 *
 * Date: Jul 16, 2026
 * @package xtradbrowusers
 * @version 1.0.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('xtradbrowusers', 'plug');

$extrafields = xtradbrowusers_getExtrafields();
if (!empty($extrafields) && !empty($urr['user_id'])) {
    $xtra_data = xtradbrowusers_load($urr['user_id']);
    if ($xtra_data) {
        foreach ($extrafields as $exfld) {
            $tag = 'XTRA_' . strtoupper($exfld['field_name']);
            $value = $xtra_data[$exfld['field_name']] ?? null;

            // Индивидуальные теги для каждого поля
            $t->assign([
                'USERS_ROW_' . $tag             => cot_build_extrafields_data('xtra', $exfld, $value),
                'USERS_ROW_' . $tag . '_TITLE'  => cot_extrafield_title($exfld, 'xtra_'),
                'USERS_ROW_' . $tag . '_VALUE'  => $value,
            ]);

            // === Универсальные теги для группового цикла ===
            // Чтобы работал блок <!-- BEGIN: XTRA_EXTRAFLD --> в users.tpl,
            // присваиваем значения тегам и вызываем parse() на каждой итерации.
            $t->assign([
                'USERS_ROW_XTRA_EXTRAFLD'       => cot_build_extrafields_data('xtra', $exfld, $value),
                'USERS_ROW_XTRA_EXTRAFLD_TITLE' => cot_extrafield_title($exfld, 'xtra_'),
            ]);
            $t->parse('MAIN.USERS_ROW.XTRA_EXTRAFLD');
            // === Конец группового цикла ===

            // Название страны, если поле — country
            if ($exfld['field_type'] === 'country') {
                $country_lang = cot_langfile('countries', 'core');
                if (file_exists($country_lang)) {
                    include $country_lang;
                }
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