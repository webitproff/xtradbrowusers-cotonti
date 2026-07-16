<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=header.tags
  [END_COT_EXT]
==================== */

/**
 * Добавление тегов XTRA в header.tpl для страниц профиля/редактирования пользователя
 * Хук header.tags. Присваивает теги {USERS_HEADER_XTRA_XXXXX} и {USERS_HEADER_XTRA_XXXXX_TITLE}
 * для использования в <title>, мета-описании и т.д. на страницах, где определён $urr.
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
            foreach ($extrafields as $exfld) {
                $tag = mb_strtoupper($exfld['field_name']);
                $value = $xtra_data[$exfld['field_name']] ?? null;

                $t->assign([
                    'USERS_HEADER_XTRA_' . $tag              => cot_build_extrafields_data('xtra', $exfld, $value),
                    'USERS_HEADER_XTRA_' . $tag . '_TITLE'   => cot_extrafield_title($exfld, 'xtra_'),
                    'USERS_HEADER_XTRA_' . $tag . '_VALUE'   => $value,
                ]);

                // Название страны, если поле — country
                if ($exfld['field_type'] === 'country') {
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