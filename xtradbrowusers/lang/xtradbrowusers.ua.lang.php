<?php
/**
 * Український мовний файл для плагіна xtradbrowusers з підтримкою i18n
 *
 * Filename: xtradbrowusers.ua.lang.php
 *
 * Path:    plugins/xtradbrowusers/lang/xtradbrowusers.ua.lang.php
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

// Використовуємо глобальну змінну $db_x, яка визначена в datas/config.php 
// і доступна абсолютно завжди, ще до завантаження будь-яких плагінів.
// $db_x — це не застаріла глобальна змінна, а маловідома, 
// ключова змінна для таких завдань, як коректне формування посилань.
// Вона задається в конфігу datas/config.php і прокидається через 
// Cot::init() в system/common.php за допомогою класу Cot з Cot.php.
// Вона працює і до встановлення плагіна, і після.
// У Cotonti немає інших надійних способів отримати префікс таблиць на етапі завантаження мовного файлу.
// Cot::$db_x і Cot::$db->tablePrefix не є частиною публічного API і не гарантують доступність у потрібний момент.
// Змінна $db_x, визначена в datas/config.php і доступна через global, — це єдиний коректний і документований спосіб.
// Тому вираз з $db_x є правильним і єдино вірним для цієї ситуації.

global $db_x;

$main_url = rtrim(Cot::$cfg['mainurl'], '/');
$url = $main_url . '/' . cot_url('admin', 'm=extrafields&n=' . $db_x . 'xtradbrowusers', '', true);
// Встановлюємо ключ і визначаємо змінну до використання в посиланні в $L['info_notes']!
$L['xtradbrowusers'] = 'Extrafields Users Custom i18n';  


// ========================
// MAIN Plugin Info
// ========================
$L['info_name'] = 'Extrafields Users Custom i18n';

$L['info_desc'] = 'Плагін додає екстраполя для модуля Users у власну таблицю БД з підтримкою багатомовності.';

$L['info_notes'] = 
    'Початківцям ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Вступ. Опис і принципи роботи екстраполів у Cotonti" class="initialism">' .
    '<strong>обов’язково прочитати розділ форуму про API ExtraFields</strong></abbr></a>. <br>' . 
    'Після встановлення плагіна відкрийте екстраполя плагіна ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';

// ========================
// TITLES AND DESCRIPTIONS (same values, pulled by other keys)
// ========================
$L['xtradbrowusers_title'] = $L['info_name'];
$L['xtradbrowusers_desc']  = $L['info_desc'];
$L['xtradbrowusers_name']  = $L['info_name'];

// ========================
// НАЛАШТУВАННЯ ПЛАГІНА (АДМІНКА)
// ========================
$L['cfg_perpage']          = 'Користувачів на сторінку';
$L['cfg_perpage_hint']     = 'Елементи на сторінці в списку/таблиці форми масового редагування';

$L['cfg_xtradbrowusers_showallitems'] = 'Показувати всіх користувачів';
$L['cfg_xtradbrowusers_showallitems_hint'] = 'Якщо увімкнено, у таблицях редагування будуть відображатися всі зареєстровані користувачі, навіть ті, для яких ще не створені записи додаткових полів.';

$L['cfg_xtradbrowusers_i18n_use'] = 'Активувати і використовувати багатомовність полів';
$L['cfg_xtradbrowusers_i18n_use_hint'] = 'Вмикає підтримку перекладів значень екстраполів. При вимкненні всі переклади зберігаються, але не відображаються.';

$L['cfg_xtradbrowusers_i18n_lang_code_default'] = 'Код основної мови сайту';
$L['cfg_xtradbrowusers_i18n_lang_code_default_hint'] = 'Має збігатися з глобальним налаштуванням <code>$cfg[\'defaultlang\']</code>. Значення для цієї мови зберігаються в основній таблиці і вважаються оригіналом.';

$L['cfg_xtradbrowusers_i18n_lang_code_first'] = 'Код першої додаткової мови';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use'] = 'Використовувати першу додаткову мову';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use_hint'] = 'Якщо активно, у формах редагування з’являться поля для введення перекладу на цю мову.';

$L['cfg_xtradbrowusers_i18n_lang_code_second'] = 'Код другої додаткової мови';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use'] = 'Використовувати другу додаткову мову';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use_hint'] = 'Якщо активно, у формах редагування з’являться поля для введення перекладу на цю мову.';

$L['cfg_help_info'] = 'Довідка розробника';   
$L['xtradbrowusers_setup_help_text'] = 'Детальний посібник, посилання на пов’язані матеріали або попросити допомогу: <a href="https://github.com/webitproff/xtradbrowusers-cotonti" target="_blank" title="Відкриється в новій вкладці"><strong><u>сторінка репозиторію плагіна</u></strong></a> на GitHub.com';

// ===========================
// ІНТЕРФЕЙС (АДМІНКА) ПЛАГІНА
// ===========================
$L['xtradbrowusers_tab_stats'] = 'Статистика';
$L['xtradbrowusers_tab_edit'] = 'Редагувати';
$L['xtradbrowusers_tab_i18n'] = 'Редагувати + Переклади';
$L['xtradbrowusers_stats_total_users'] = 'Всього користувачів';
$L['xtradbrowusers_stats_xtra_rows'] = 'Записів у xtradbrowusers';
$L['xtradbrowusers_stats_filled'] = 'Заповнених записів';
$L['xtradbrowusers_extrafields_info'] = 'Параметри екстраполів';
$L['xtradbrowusers_field_name'] = 'Ім’я поля';
$L['xtradbrowusers_field_type'] = 'Тип';
$L['xtradbrowusers_field_description'] = 'Опис';
$L['xtradbrowusers_field_variants'] = 'Варіанти';
$L['xtradbrowusers_field_params'] = 'Параметри';
$L['xtradbrowusers_field_default'] = 'За замовчуванням';
$L['xtradbrowusers_field_required'] = 'Обов’язкове';
$L['xtradbrowusers_field_enabled'] = 'Увімкнено';
$L['xtradbrowusers_username'] = 'Користувач';
$L['xtradbrowusers_no_extrafields'] = 'Немає зареєстрованих екстраполів';
$L['xtradbrowusers_no_records'] = 'Немає записів';
$L['xtradbrowusers_saved'] = 'Зміни збережено';
$L['xtradbrowusers_i18n_active'] = 'Багатомовність увімкнено';
$L['xtradbrowusers_i18n_disabled'] = 'Багатомовність вимкнено';
$L['xtradbrowusers_search_sq'] = 'Пошук за ім’ям/email';
$L['xtradbrowusers_filter_id'] = 'ID користувача';
$L['xtradbrowusers_filter_group'] = 'Група';
$L['xtradbrowusers_search_btn'] = 'Фільтр';
$L['xtradbrowusers_search_reset'] = 'Скинути';
$L['xtradbrowusers_search_in_name'] = 'Ім’я';
$L['xtradbrowusers_search_in_email'] = 'Email';
$L['xtradbrowusers_search_in_both'] = 'Ім’я та email';
$L['xtradbrowusers_search_result_msg'] = 'Знайдено %s за запитом %s';
$L['xtradbrowusers_search_result_none'] = 'Нічого не знайдено за запитом %s';
$L['xtradbrowusers_search_declen'] = 'записів,запис,записи';
$L['xtradbrowusers_search_cat'] = 'Категорія користувача';
$L['xtradbrowusers_all_categories'] = 'Without a category';
$L['xtradbrowusers_updated'] = 'Оновлено записів: %d';

// ===========================
// Використання в заголовках у шаблонах
// ===========================
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Редагування профілю</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Публічний профіль</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Адміністратору для картки користувача рекомендується використовувати саме індивідуальний вивід додаткових полів для їх гнучкої кастомізації';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Адмін-редагування</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Екстраполя <code>xtradbrowusers</code>. Список користувачів</span>';
$L['xtradbrowusers_details_tpl_show_hidden_content'] = '<span class="fw-semibold" style="letter-spacing: 1px;">Показати</span>';

// ===========================
// Приклади локалізації заголовків (_TITLE) для всіх демонстраційних полів
// ===========================
$L['xtra_x200_phone_extra_title'] = 'Додатковий телефон';
$L['xtra_x200_about_extra_title'] = 'Про себе';
$L['xtra_x200_hire_date_title'] = 'Дата найму';
$L['xtra_x200_salary_title'] = 'Зарплата';
$L['xtra_x200_department_title'] = 'Відділ';
$L['xtra_x200_experience_years_title'] = 'Стаж (років)';
$L['xtra_x200_skill_level_title'] = 'Рівень кваліфікації';
$L['xtra_x200_has_car_title'] = 'Наявність автомобіля';
$L['xtra_x200_last_promotion_title'] = 'Дата останнього підвищення';
$L['xtra_x200_resume_file_title'] = 'Резюме (файл)';
$L['xtra_x200_residence_country_title'] = 'Країна проживання';
$L['xtra_x200_english_level_title'] = 'Рівень англійської';
$L['xtra_x200_interests_title'] = 'Інтереси';
$L['xtra_x200_work_schedule_title'] = 'Графік роботи';
$L['xtra_x200_emergency_contact_title'] = 'Екстрений контакт';

// ===========================
// Приклади локалізації значень для select, radio, checklistbox
// ===========================
$L['x200_department_not_specified'] = 'Не вказано';
$L['x200_department_it'] = 'IT-відділ';
$L['x200_department_marketing'] = 'Маркетинг';
$L['x200_department_sales'] = 'Продажі';
$L['x200_department_support'] = 'Підтримка';

$L['x200_skill_level_junior'] = 'Молодший';
$L['x200_skill_level_middle'] = 'Середній';
$L['x200_skill_level_senior'] = 'Старший';
$L['x200_skill_level_lead'] = 'Провідний';

$L['x200_has_car_yes'] = 'Так';
$L['x200_has_car_no'] = 'Ні';

$L['x200_interests_sport'] = 'Спорт';
$L['x200_interests_music'] = 'Музика';
$L['x200_interests_it'] = 'IT';
$L['x200_interests_travel'] = 'Подорожі';

$L['x200_work_schedule_full_time'] = 'Повний день';
$L['x200_work_schedule_shift'] = 'Змінний';
$L['x200_work_schedule_remote'] = 'Віддалена робота';
$L['x200_work_schedule_flexible'] = 'Гнучкий графік';

// ===========================
// Мої локалізації заголовків (_TITLE)
// Можна залишити тут, якщо плагін не оновлюватиметься, але наполегливо раджу винести в рядки файлу локалізації теми/шаблону
// ===========================
$L['xtra_x010_phone_vendor_orders_title'] = 'Контактний телефон для дзвінків';
$L['xtra_x011_tg_vendor_orders_title'] = 'Телеграм для повідомлень';
$L['xtra_x012_tg_chanel_vendor_title'] = 'Телеграм-канал';
$L['xtra_x020_about_vendor_text_title'] = 'Про мене коротко';
