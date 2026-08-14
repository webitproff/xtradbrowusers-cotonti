<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.edit.tags
  [END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.edit.tags.php – Вывод полей в форме админского редактирования пользователя
 *
 * Purpose:   Подключается к хуку `users.edit.tags`, который вызывается в файле
 *            /modules/users/inc/users.edit.php перед парсингом шаблона.
 *            Отображает все экстраполя плагина в форме редактирования пользователя администратором.
 *            Назначает теги вида:
 *            {USERS_EDIT_XTRA_ИМЯПОЛЯ}, {USERS_EDIT_XTRA_ИМЯПОЛЯ_TITLE},
 *            а также общий тег {USERS_EDIT_XTRA_EXTRAFLD} и
 *            {USERS_EDIT_XTRA_EXTRAFLD_TITLE}.
 *            Если включена мультиязычность, для полей input и textarea добавляются
 *            поля ввода переводов для каждого активного ДОПОЛНИТЕЛЬНОГО языка
 *            с тегами {USERS_EDIT_XTRA_ИМЯПОЛЯ_ЯЗЫК} и {USERS_EDIT_XTRA_ИМЯПОЛЯ_ЯЗЫК_TITLE},
 *            где вместо "_ЯЗЫК" подставляем зарегистрированный код такого языка, например "_RU", "_EN" и т.д.
 *
 * Мультиязычность при выводе формы:
 *   - select, radio, checklistbox: локализуются через языковой массив $L,
 *     переводы в таблицу i18n не загружаются.
 *   - checkbox: хранит 1/0, локализация в шаблоне.
 *   - input, textarea: при включённой опции мультиязычности выводятся поля
 *     для перевода на каждый активный дополнительный язык. Для textarea
 *     перевод также отображается как многострочное поле.
 *   - inputint, double, datetime, range, file, country: поля переводов не выводятся,
 *     работает только оригинальное значение.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.edit.tags.php
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
    
    // Проверяем, включена ли мультиязычность
    $i18nEnabled = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use']);
    $activeLangs = [];
    if ($i18nEnabled) {
        $defaultLang = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default'] ?? Cot::$cfg['defaultlang'];
        // Собираем активные дополнительные языки
        $firstCode  = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_first'] ?? '';
        $firstUse   = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_first_use'] ?? 0;
        $secondCode = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_second'] ?? '';
        $secondUse  = Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_second_use'] ?? 0;

        if ($firstUse && !empty($firstCode) && $firstCode !== $defaultLang) {
            $activeLangs[] = $firstCode;
        }
        if ($secondUse && !empty($secondCode) && $secondCode !== $defaultLang) {
            $activeLangs[] = $secondCode;
        }
    }

    // Типы полей, для которых имеет смысл мультиязычный ввод: только произвольный текст
    $i18nAllowedTypes = ['input', 'textarea'];

    foreach ($extrafields as $exfld) {
        $fieldName = 'rxtra_' . $exfld['field_name'];
        $value = $xtra_data[$exfld['field_name']] ?? null;
        $element = cot_build_extrafields($fieldName, $exfld, $value);
        $title = cot_extrafield_title($exfld, 'xtra_');

        // Основные теги (как раньше)
        $t->assign([
            'USERS_EDIT_XTRA_' . strtoupper($exfld['field_name'])             => $element,
            'USERS_EDIT_XTRA_' . strtoupper($exfld['field_name']) . '_TITLE'  => $title,
            'USERS_EDIT_XTRA_EXTRAFLD'                                        => $element,
            'USERS_EDIT_XTRA_EXTRAFLD_TITLE'                                  => $title,
        ]);
        $t->parse('MAIN.XTRA_EXTRAFLD');

        // Если мультиязычность активна – добавляем поля переводов ТОЛЬКО для разрешённых типов
        if ($i18nEnabled && !empty($activeLangs) && in_array($exfld['field_type'], $i18nAllowedTypes)) {
            foreach ($activeLangs as $lang) {
                $i18nFieldName = 'rxtra_' . $exfld['field_name'] . '_' . $lang;
                $i18nValue = xtradbrowusers_i18n_load($urr['user_id'], $exfld['field_name'], $lang);
                //$i18nElement = cot_inputbox('text', $i18nFieldName, $i18nValue, 'class="form-control"');
				// если оригинальное поле — textarea, то и поле для перевода должно быть многострочным.
				if ($exfld['field_type'] === 'textarea') {
					$i18nElement = cot_textarea($i18nFieldName, $i18nValue, 5, 40, 'class="form-control"');
				} else {
					$i18nElement = cot_inputbox('text', $i18nFieldName, $i18nValue, 'class="form-control"');
				}
                $i18nTitle = $title . ' (' . strtoupper($lang) . ')';

                $t->assign([
                    'USERS_EDIT_XTRA_' . strtoupper($exfld['field_name']) . '_' . strtoupper($lang) => $i18nElement,
                    'USERS_EDIT_XTRA_' . strtoupper($exfld['field_name']) . '_' . strtoupper($lang) . '_TITLE' => $i18nTitle,
                ]);
            }
        }
    }
}
