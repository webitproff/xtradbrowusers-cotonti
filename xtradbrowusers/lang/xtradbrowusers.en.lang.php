<?php
/**
 * File: plugins/xtradbrowusers/lang/xtradbrowusers.en.lang.php
 * English Language File for xtradbrowusers Plugin
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
$L['cfg_xtradbrowusers_i18n_use'] = 'Enable and use multilingual fields';
$L['cfg_xtradbrowusers_i18n_use_hint'] = 'Enables translation support for extra field values. When disabled, all translations are preserved but not displayed.';

$L['cfg_xtradbrowusers_i18n_lang_code_default'] = 'Primary site language code';
$L['cfg_xtradbrowusers_i18n_lang_code_default_hint'] = 'Must match the global setting <code>$cfg[\'defaultlang\']</code>. Values for this language are stored in the main table and considered original.';

$L['cfg_xtradbrowusers_i18n_lang_code_first'] = 'Code of the first additional language';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use'] = 'Use the first additional language';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use_hint'] = 'If active, editing forms will display fields for entering translations into this language.';

$L['cfg_xtradbrowusers_i18n_lang_code_second'] = 'Code of the second additional language';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use'] = 'Use the second additional language';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use_hint'] = 'If active, editing forms will display fields for entering translations into this language.';

/**
 * Plugin Info
 */
$L['info_name'] = 'Extrafields Users Custom';

$L['info_desc'] = 'The plugin adds extra fields for users into its own database table';

$L['info_notes'] = 
    'For beginners, ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Introduction. Description and principles of ExtraFields in Cotonti" class="initialism">' .
    '<strong>be sure to read the forum section about ExtraFields API</strong></abbr></a>. <br>' . 
    'After installing the plugin, open the plugin\'s extra fields ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';
    
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extra fields <code>xtradbrowusers</code>. Profile editing</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extra fields <code>xtradbrowusers</code>. Public profile</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'For the user card, the administrator is advised to use individual output of extra fields for flexible customization';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extra fields <code>xtradbrowusers</code>. Admin editing</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extra fields <code>xtradbrowusers</code>. User list</span>';
$L['xtradbrowusers_details_tpl_show_hidden_content'] = '<span class="fw-semibold" style="letter-spacing: 1px;">Show</span>';

// Localization examples for titles (_TITLE) for all demo fields
$L['xtra_phone_extra_title'] = 'Additional phone';
$L['xtra_about_extra_title'] = 'About myself';
$L['xtra_hire_date_title'] = 'Hire date';
$L['xtra_salary_title'] = 'Salary';
$L['xtra_department_title'] = 'Department';
$L['xtra_experience_years_title'] = 'Experience (years)';
$L['xtra_skill_level_title'] = 'Skill level';
$L['xtra_has_car_title'] = 'Has a car';
$L['xtra_last_promotion_title'] = 'Date of last promotion';
$L['xtra_resume_file_title'] = 'Resume (file)';
$L['xtra_residence_country_title'] = 'Country of residence';
$L['xtra_english_level_title'] = 'English level';
$L['xtra_interests_title'] = 'Interests';
$L['xtra_work_schedule_title'] = 'Work schedule';
$L['xtra_emergency_contact_title'] = 'Emergency contact';

// Localization examples for select, radio, checklistbox values
$L['department_not_specified'] = 'Not specified';
$L['department_it'] = 'IT department';
$L['department_marketing'] = 'Marketing';
$L['department_sales'] = 'Sales';
$L['department_support'] = 'Support';

$L['skill_level_junior'] = 'Junior';
$L['skill_level_middle'] = 'Middle';
$L['skill_level_senior'] = 'Senior';
$L['skill_level_lead'] = 'Lead';

$L['has_car_yes'] = 'Yes';
$L['has_car_no'] = 'No';

$L['interests_sport'] = 'Sport';
$L['interests_music'] = 'Music';
$L['interests_it'] = 'IT';
$L['interests_travel'] = 'Travel';

$L['work_schedule_full_time'] = 'Full-time';
$L['work_schedule_shift'] = 'Shift';
$L['work_schedule_remote'] = 'Remote work';
$L['work_schedule_flexible'] = 'Flexible schedule';
