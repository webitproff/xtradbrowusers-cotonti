<?php
/**
 * Russian Language File for xtradbrowusers Plugin with i18n support
 *
 * Filename: xtradbrowusers.ru.lang.php
 *
 * Path:    plugins/xtradbrowusers/lang/xtradbrowusers.ru.lang.php
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
$url = $main_url . '/' . cot_url('admin', 'm=extrafields&n=' . $db_x . 'xtradbrowusers', '', true);
// устанавливаем ключ и определяем перевенную до вызова в ссылке в $L['info_notes']!
$L['xtradbrowusers'] = 'Extrafields Users Custom i18n';  


// ========================
// MAIN Plugin Info
// ========================
$L['info_name'] = 'Extrafields Users Custom i18n';
$L['info_desc'] = 'Плагин добавляет экстраполя для модуля Users в свою таблицу БД с поддержкой мультиязычности.';
$L['info_notes'] = 
    'Новичкам ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Введение. Описание и принципы работы экстраполей в Cotonti" class="initialism">' .
    '<strong>обязательно читать раздел форума об API ExtraFields</strong></abbr></a>. <br>' . 
    'После установки плагина, открыть экстраполя плагина ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';

// ========================
// TITLES AND DESCRIPTIONS (same values, pulled by other keys)
// ========================
$L['xtradbrowusers_title'] = $L['info_name'];
$L['xtradbrowusers_desc']  = $L['info_desc'];
$L['xtradbrowusers_name']  = $L['info_name'];

// ========================
// НАСТРОЙКИ ПЛАГИНА (АДМИНКА)
// ========================
$L['cfg_perpage']          = 'Пользователей на страницу';
$L['cfg_perpage_hint']     = 'Элементы на странице в списке/таблице формы массового редактирования';

$L['cfg_xtradbrowusers_showallitems'] = 'Показывать всех пользователей';
$L['cfg_xtradbrowusers_showallitems_hint'] = 'Если включено, в таблицах редактирования будут отображаться все зарегистированные пользователи, даже те, для которых ещё не созданы записи дополнительных полей.';

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

$L['cfg_help_info'] = 'Справка разработчика';   
$L['xtradbrowusers_setup_help_text'] = 'Подробное руководство, ссылки на сопряженные материалы или попросить помощь: <a href="https://github.com/webitproff/xtradbrowusers-cotonti" target="_blank" title="Откроется в новой вкладке"><strong><u>страница репозитория плагина</u></strong></a> на GitHub.com';

// ===========================
// ИНТЕРФЕЙС (АДМИНКА) ПЛАГИНА
// ===========================
$L['xtradbrowusers_tab_stats'] = 'Статистика';
$L['xtradbrowusers_tab_edit'] = 'Редактировать';
$L['xtradbrowusers_tab_i18n'] = 'Редактировать + Переводы';
$L['xtradbrowusers_stats_total_users'] = 'Всего пользователей';
$L['xtradbrowusers_stats_xtra_rows'] = 'Записей в xtradbrowusers';
$L['xtradbrowusers_stats_filled'] = 'Заполненных записей';
$L['xtradbrowusers_extrafields_info'] = 'Параметры экстраполей';
$L['xtradbrowusers_field_name'] = 'Имя поля';
$L['xtradbrowusers_field_type'] = 'Тип';
$L['xtradbrowusers_field_description'] = 'Описание';
$L['xtradbrowusers_field_variants'] = 'Варианты';
$L['xtradbrowusers_field_params'] = 'Параметры';
$L['xtradbrowusers_field_default'] = 'По умолчанию';
$L['xtradbrowusers_field_required'] = 'Обязательное';
$L['xtradbrowusers_field_enabled'] = 'Включено';
$L['xtradbrowusers_username'] = 'Пользователь';
$L['xtradbrowusers_no_extrafields'] = 'Нет зарегистрированных экстраполей';
$L['xtradbrowusers_no_records'] = 'Нет записей';
$L['xtradbrowusers_saved'] = 'Изменения сохранены';
$L['xtradbrowusers_i18n_active'] = 'Мультиязычность включена';
$L['xtradbrowusers_i18n_disabled'] = 'Мультиязычность отключена';
$L['xtradbrowusers_search_sq'] = 'Поиск по имени/email';
$L['xtradbrowusers_filter_id'] = 'ID пользователя';
$L['xtradbrowusers_filter_group'] = 'Группа';
$L['xtradbrowusers_search_btn'] = 'Фильтр';
$L['xtradbrowusers_search_reset'] = 'Сброс';
$L['xtradbrowusers_search_in_name'] = 'Имя';
$L['xtradbrowusers_search_in_email'] = 'Email';
$L['xtradbrowusers_search_in_both'] = 'Имя и email';
$L['xtradbrowusers_search_result_msg'] = 'Найдено %s по запросу %s';
$L['xtradbrowusers_search_result_none'] = 'Ничего не найдено по запросу %s';
$L['xtradbrowusers_search_declen'] = 'записей,запись,записи';
$L['xtradbrowusers_search_cat'] = 'Категория пользователя';
$L['xtradbrowusers_all_categories'] = 'Без категории';
$L['xtradbrowusers_updated'] = 'Обновлено записей: %d';

// ===========================
// использование в заголовках в шаблонах 
// ===========================
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Редактирование профиля</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Публичный профиль</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Администратор, для карточки пользователя, рекомендуется использовать именно индивидуальный вывод дополнительных полей для их гибкой кастомизации';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Админ-редактирование</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Экстраполя <code>xtradbrowusers</code>. Список пользователей</span>';
$L['xtradbrowusers_details_tpl_show_hidden_content'] = '<span class="fw-semibold" style="letter-spacing: 1px;">Показать</span>';

// ===========================
// Примеры локализации заголовков (_TITLE) для всех демонстрационных полей
// ===========================
$L['xtra_x200_phone_extra_title'] = 'Дополнительный телефон';
$L['xtra_x200_about_extra_title'] = 'О себе';
$L['xtra_x200_hire_date_title'] = 'Дата найма';
$L['xtra_x200_salary_title'] = 'Зарплата';
$L['xtra_x200_department_title'] = 'Отдел';
$L['xtra_x200_experience_years_title'] = 'Стаж (лет)';
$L['xtra_x200_skill_level_title'] = 'Уровень квалификации';
$L['xtra_x200_has_car_title'] = 'Наличие автомобиля';
$L['xtra_x200_last_promotion_title'] = 'Дата последнего повышения';
$L['xtra_x200_resume_file_title'] = 'Резюме (файл)';
$L['xtra_x200_residence_country_title'] = 'Страна проживания';
$L['xtra_x200_english_level_title'] = 'Уровень английского';
$L['xtra_x200_interests_title'] = 'Интересы';
$L['xtra_x200_work_schedule_title'] = 'График работы';
$L['xtra_x200_emergency_contact_title'] = 'Экстренный контакт';

// ===========================
// Примеры локализации значений для select, radio, checklistbox
// ===========================
$L['x200_department_not_specified'] = 'Не указан';
$L['x200_department_it'] = 'IT-отдел';
$L['x200_department_marketing'] = 'Маркетинг';
$L['x200_department_sales'] = 'Продажи';
$L['x200_department_support'] = 'Поддержка';

$L['x200_skill_level_junior'] = 'Младший';
$L['x200_skill_level_middle'] = 'Средний';
$L['x200_skill_level_senior'] = 'Старший';
$L['x200_skill_level_lead'] = 'Ведущий';

$L['x200_has_car_yes'] = 'Да';
$L['x200_has_car_no'] = 'Нет';

$L['x200_interests_sport'] = 'Спорт';
$L['x200_interests_music'] = 'Музыка';
$L['x200_interests_it'] = 'IT';
$L['x200_interests_travel'] = 'Путешествия';

$L['x200_work_schedule_full_time'] = 'Полный день';
$L['x200_work_schedule_shift'] = 'Сменный';
$L['x200_work_schedule_remote'] = 'Удалённая работа';
$L['x200_work_schedule_flexible'] = 'Гибкий график';

// ===========================
// Мои локализации заголовков (_TITLE)
// Можно оставить здесь, если не обновлять плагин, но настойчиво советую вынести в строки файла локализации темы/шаблона
// ===========================

$L['xtra_x010_phone_vendor_orders_title'] = 'Контактная звонилка';
$L['xtra_x011_tg_vendor_orders_title'] = 'Телеграм для сообщений';
$L['xtra_x012_tg_chanel_vendor_title'] = 'Телеграм-канал';
$L['xtra_x020_about_vendor_text_title'] = 'Обо мне кратко';
