<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
[END_COT_EXT]
==================== */

/**
 * Overrides user tags in cot_generate_usertags() function
 * Теги для использования в cot_generate_usertags() (списки, карточки, форум, etc.)
 * Хук usertags.main. Добавляет в общий массив тегов переменные $temp_array + XTRA + ИМЯПОЛЯ
 * например {USERS_ROW_XTRA_XXXXX} и {USERS_ROW_XTRA_XXXXX_TITLE}
 *
 * Date: Jul 16, 2026
 * @package xtradbrowusers
 * @version 1.0.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff/xtradbrowusers-cotonti
 * @license BSD
 * @see cot_generate_usertags()
 * Хук usertags.main вызывается внутри функции cot_generate_usertags().
 * Переменная $temp_array доступна напрямую, без объявления global.
 * @var array<string, mixed> $user_data
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('xtradbrowusers', 'plug');

$extrafields = xtradbrowusers_getExtrafields();
if (!empty($extrafields) && !empty($user_data['user_id'])) {
    $xtra_data = xtradbrowusers_load($user_data['user_id']);
    if ($xtra_data) {
        foreach ($extrafields as $exfld) {
            $tag = 'XTRA_' . strtoupper($exfld['field_name']);
            $value = $xtra_data[$exfld['field_name']] ?? null;
            $temp_array[$tag] = cot_build_extrafields_data('xtra', $exfld, $value);
            $temp_array[$tag . '_TITLE'] = cot_extrafield_title($exfld, 'xtra_');
            $temp_array[$tag . '_VALUE'] = $value;

            if ($exfld['field_type'] === 'country') {
                $country_lang = cot_langfile('countries', 'core');
                if (file_exists($country_lang)) {
                    include $country_lang;
                }
                $temp_array[$tag . '_NAME'] = isset($cot_countries[$value]) ? $cot_countries[$value] : $value;
            }
        }
    } else {
        foreach ($extrafields as $exfld) {
            $tag = 'XTRA_' . strtoupper($exfld['field_name']);
            $temp_array[$tag] = '';
            $temp_array[$tag . '_TITLE'] = '';
            $temp_array[$tag . '_VALUE'] = '';
            if ($exfld['field_type'] === 'country') {
                $temp_array[$tag . '_NAME'] = '';
            }
        }
    }
}