<?php
/**
 * File: plugins/xtradbrowusers/lang/xtradbrowusers.ua.lang.php
 * Український мовний файл для плагіна xtradbrowusers
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

$L['xtradbrowusers'] = 'Користувацькі Extrafields';

/**
 * Конфігурація плагіна
 */
$L['cfg_xtradbrowusers_i18n_use'] = 'Увімкнути та використовувати мультимовні поля';
$L['cfg_xtradbrowusers_i18n_use_hint'] = 'Вмикає підтримку перекладів значень екстраполів. При вимкненні всі переклади зберігаються, але не відображаються.';

$L['cfg_xtradbrowusers_i18n_lang_code_default'] = 'Код основної мови сайту';
$L['cfg_xtradbrowusers_i18n_lang_code_default_hint'] = 'Повинен збігатися з глобальним налаштуванням <code>$cfg[\'defaultlang\']</code>. Значення для цієї мови зберігаються в основній таблиці і вважаються оригіналом.';

$L['cfg_xtradbrowusers_i18n_lang_code_first'] = 'Код першої додаткової мови';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use'] = 'Використовувати першу додаткову мову';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use_hint'] = 'Якщо активно, у формах редагування з’являться поля для введення перекладу цією мовою.';

$L['cfg_xtradbrowusers_i18n_lang_code_second'] = 'Код другої додаткової мови';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use'] = 'Використовувати другу додаткову мову';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use_hint'] = 'Якщо активно, у формах редагування з’являться поля для введення перекладу цією мовою.';

/**
 * Інформація про плагін
 */
$L['info_name'] = 'Extrafields Users Custom';

$L['info_desc'] = 'Плагін додає додаткові поля для користувачів у власну таблицю БД';

$L['info_notes'] = 
    'Початківцям ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Вступ. Опис і принципи роботи ExtraFields в Cotonti" class="initialism">' .
    '<strong>обов’язково прочитайте розділ форуму про API ExtraFields</strong></abbr></a>. <br>' . 
    'Після встановлення плагіна відкрийте екстраполя плагіна ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';
    
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Редагування профілю</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Публічний профіль</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Адміністратору, для картки користувача, рекомендується використовувати індивідуальний вивід додаткових полів для їх гнучкого налаштування';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Адмін-редагування</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Список користувачів</span>';
$L['xtradbrowusers_details_tpl_show_hidden_content'] = '<span class="fw-semibold" style="letter-spacing: 1px;">Показати</span>';

// Приклади локалізації заголовків (_TITLE) для всіх демонстраційних полів
$L['xtra_phone_extra_title'] = 'Додатковий телефон';
$L['xtra_about_extra_title'] = 'Про себе';
$L['xtra_hire_date_title'] = 'Дата найму';
$L['xtra_salary_title'] = 'Зарплата';
$L['xtra_department_title'] = 'Відділ';
$L['xtra_experience_years_title'] = 'Стаж (років)';
$L['xtra_skill_level_title'] = 'Рівень кваліфікації';
$L['xtra_has_car_title'] = 'Наявність автомобіля';
$L['xtra_last_promotion_title'] = 'Дата останнього підвищення';
$L['xtra_resume_file_title'] = 'Резюме (файл)';
$L['xtra_residence_country_title'] = 'Країна проживання';
$L['xtra_english_level_title'] = 'Рівень англійської';
$L['xtra_interests_title'] = 'Інтереси';
$L['xtra_work_schedule_title'] = 'Графік роботи';
$L['xtra_emergency_contact_title'] = 'Екстрений контакт';

// Приклади локалізації значень для select, radio, checklistbox
$L['department_not_specified'] = 'Не вказано';
$L['department_it'] = 'IT-відділ';
$L['department_marketing'] = 'Маркетинг';
$L['department_sales'] = 'Продажі';
$L['department_support'] = 'Підтримка';

$L['skill_level_junior'] = 'Молодший';
$L['skill_level_middle'] = 'Середній';
$L['skill_level_senior'] = 'Старший';
$L['skill_level_lead'] = 'Провідний';

$L['has_car_yes'] = 'Так';
$L['has_car_no'] = 'Ні';

$L['interests_sport'] = 'Спорт';
$L['interests_music'] = 'Музика';
$L['interests_it'] = 'IT';
$L['interests_travel'] = 'Подорожі';

$L['work_schedule_full_time'] = 'Повний день';
$L['work_schedule_shift'] = 'Змінний';
$L['work_schedule_remote'] = 'Віддалена робота';
$L['work_schedule_flexible'] = 'Гнучкий графік';
