<?php
/**
 * File: plugins/xtradbrowusers/lang/xtradbrowusers.ru.lang.php
 * Russian Language File for xtradbrowusers Plugin
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

// использовать глобальную переменную $db_x, которая определена в datas/config.php 
// и доступна абсолютно всегда, ещё до загрузки любых плагинов 
// $db_x — это не устаревшая глобальная переменная, а малоизвестная, 
// ключевая переменная для например таких задач для корректно ссылки.
// задаётся в конфиге datas/config.php и пробрасывается через 
// Cot::init() в system/common.php используя class Cot из Cot.php . 
// Она работает и до установки плагина, и после.
// В Cotonti нет других надёжных способов получить префикс таблиц на этапе загрузки языкового файла. 
// Cot::$db_x и Cot::$db->tablePrefix не являются частью публичного API и не гарантируют доступность в нужный момент. 
// Переменная $db_x, определённая в datas/config.php и доступная через global, — это единственный корректный и документированный способ. 
// Поэтому выражение с $db_x является правильным и единственно верным для данной ситуации.

global $db_x;

$main_url = rtrim(Cot::$cfg['mainurl'], '/');
$url = $main_url . '/' . cot_url('admin', 'm=extrafields&n=' . $db_x . 'xtradbrowmarket', '', true);

$L['xtradbrowusers'] = 'Custom Extrafields Users';
/**
 * Plugin Config
 */
$L['cfg_xtradbrowusers_i18n_use'] = 'Мультиязычность полей активировать и использовать';
$L['cfg_xtradbrowusers_i18n_use_hint'] = 'Включает поддержку переводов значений экстраполей. При отключении все переводы сохраняются, но не отображаются.';

$L['cfg_xtradbrowusers_i18n_lang_code_default'] = 'Код основного языка сайта';
$L['cfg_xtradbrowusers_i18n_lang_code_default_hint'] = 'Должен совпадать с глобальной настройкой <code>$cfg[\'defaultlang\']</code>. Значения для этого языка хранятся в основной таблице и считаются оригиналом.';

$L['cfg_xtradbrowusers_i18n_lang_code_first'] = 'Код первого дополнительного языка';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use'] = 'Использовать первый дополнительный язык';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use_hint'] = 'Если активно, в формах редактирования появятся поля для ввода перевода на этот язык.';

$L['cfg_xtradbrowusers_i18n_lang_code_second'] = 'Код второго дополнительного языка';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use'] = 'Использовать второй дополнительный язык';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use_hint'] = 'Если активно, в формах редактирования появятся поля для ввода перевода на этот язык.';
/**
 * Plugin Info
 */
$L['info_name'] = 'Extrafields Users Custom';

$L['info_desc'] = 'Плагин добавляет дополнительные поля для пользователей в собственную таблицу БД';

$L['info_notes'] = 
    'Новичкам ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Введение. Описание и принципы работы экстраполей в Cotonti" class="initialism">' .
    '<strong>обязательно читать раздел форума об API ExtraFields</strong></abbr></a>. <br>' . 
    'После установки плагина, открыть экстраполя плагина ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';
    
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Редактирование профиля</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Публичный профиль</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Администратор, для карточки пользователя, рекомендуется использовать именно индивидуальный вывод дополнительных полей для их гибкой кастомизации';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Админ-редактирование</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Список пользователей</span>';
$L['xtradbrowusers_details_tpl_show_hidden_content'] = '<span class="fw-semibold" style="letter-spacing: 1px;">Показать</span>';

// Примеры локализации заголовков (_TITLE) для всех демонстрационных полей
$L['xtra_phone_extra_title'] = 'Дополнительный телефон';
$L['xtra_about_extra_title'] = 'О себе';
$L['xtra_hire_date_title'] = 'Дата найма';
$L['xtra_salary_title'] = 'Зарплата';
$L['xtra_department_title'] = 'Отдел';
$L['xtra_experience_years_title'] = 'Стаж (лет)';
$L['xtra_skill_level_title'] = 'Уровень квалификации';
$L['xtra_has_car_title'] = 'Наличие автомобиля';
$L['xtra_last_promotion_title'] = 'Дата последнего повышения';
$L['xtra_resume_file_title'] = 'Резюме (файл)';
$L['xtra_residence_country_title'] = 'Страна проживания';
$L['xtra_english_level_title'] = 'Уровень английского';
$L['xtra_interests_title'] = 'Интересы';
$L['xtra_work_schedule_title'] = 'График работы';
$L['xtra_emergency_contact_title'] = 'Экстренный контакт';

// Примеры локализации значений для select, radio, checklistbox
$L['department_not_specified'] = 'Не указан';
$L['department_it'] = 'IT-отдел';
$L['department_marketing'] = 'Маркетинг';
$L['department_sales'] = 'Продажи';
$L['department_support'] = 'Поддержка';

$L['skill_level_junior'] = 'Младший';
$L['skill_level_middle'] = 'Средний';
$L['skill_level_senior'] = 'Старший';
$L['skill_level_lead'] = 'Ведущий';

$L['has_car_yes'] = 'Да';
$L['has_car_no'] = 'Нет';

$L['interests_sport'] = 'Спорт';
$L['interests_music'] = 'Музыка';
$L['interests_it'] = 'IT';
$L['interests_travel'] = 'Путешествия';

$L['work_schedule_full_time'] = 'Полный день';
$L['work_schedule_shift'] = 'Сменный';
$L['work_schedule_remote'] = 'Удалённая работа';
$L['work_schedule_flexible'] = 'Гибкий график';
