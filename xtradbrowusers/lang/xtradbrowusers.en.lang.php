<?php
/**
 * English Language File for xtradbrowusers Plugin with i18n support
 *
 * Filename: xtradbrowusers.en.lang.php
 *
 * Path:    plugins/xtradbrowusers/lang/xtradbrowusers.en.lang.php
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

// Use the global variable $db_x, which is defined in datas/config.php 
// and is available absolutely always, even before any plugins are loaded.
// $db_x is not a deprecated global variable, but a little-known, 
// key variable for tasks such as correctly building links.
// It is set in the config datas/config.php and is passed through 
// Cot::init() in system/common.php using the Cot class from Cot.php.
// It works both before and after the plugin is installed.
// In Cotonti there are no other reliable ways to get the table prefix at the language file loading stage.
// Cot::$db_x and Cot::$db->tablePrefix are not part of the public API and do not guarantee availability at the required moment.
// The variable $db_x, defined in datas/config.php and available via global, is the only correct and documented way.
// Therefore, the expression with $db_x is correct and the only valid one for this situation.

global $db_x;

$main_url = rtrim(Cot::$cfg['mainurl'], '/');
$url = $main_url . '/' . cot_url('admin', 'm=extrafields&n=' . $db_x . 'xtradbrowusers', '', true);
// Set the key and define the variable before it is used in the link in $L['info_notes']!
$L['xtradbrowusers'] = 'Extrafields Users Custom i18n';  


// ========================
// MAIN Plugin Info
// ========================
$L['info_name'] = 'Extrafields Users Custom i18n';

$L['info_desc'] = 'The plugin adds extra fields for the Users module into its own database table with multilingual support.';

$L['info_notes'] = 
    'For beginners ' .
    '<a href="https://abuyfile.com/ru/forums/cotonti/original/extrafields" target="_blank">' .
    '<abbr title="Introduction. Description and principles of Extrafields in Cotonti" class="initialism">' .
    '<strong>it is mandatory to read the forum section about the ExtraFields API</strong></abbr></a>. <br>' . 
    'After installing the plugin, open the plugin extrafields ' .
    '<a href="' . $url . '" target="_blank">' .
    '<strong> ' . $L['xtradbrowusers'] . ' </strong></a>.';

// ========================
// TITLES AND DESCRIPTIONS (same values, pulled by other keys)
// ========================
$L['xtradbrowusers_title'] = $L['info_name'];
$L['xtradbrowusers_desc']  = $L['info_desc'];
$L['xtradbrowusers_name']  = $L['info_name'];

// ========================
// PLUGIN SETTINGS (ADMIN)
// ========================
$L['cfg_perpage']          = 'Users per page';
$L['cfg_perpage_hint']     = 'Items per page in the list/table of the mass editing form';

$L['cfg_xtradbrowusers_showallitems'] = 'Show all users';
$L['cfg_xtradbrowusers_showallitems_hint'] = 'If enabled, the editing tables will display all registered users, even those for whom extra field records have not yet been created.';

$L['cfg_xtradbrowusers_i18n_use'] = 'Activate and use field multilingualism';
$L['cfg_xtradbrowusers_i18n_use_hint'] = 'Enables support for translations of extra field values. When disabled, all translations are preserved but not displayed.';

$L['cfg_xtradbrowusers_i18n_lang_code_default'] = 'Primary site language code';
$L['cfg_xtradbrowusers_i18n_lang_code_default_hint'] = 'Must match the global setting <code>$cfg[\'defaultlang\']</code>. Values for this language are stored in the main table and are considered the original.';

$L['cfg_xtradbrowusers_i18n_lang_code_first'] = 'First additional language code';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use'] = 'Use the first additional language';
$L['cfg_xtradbrowusers_i18n_lang_code_first_use_hint'] = 'If active, editing forms will show fields for entering a translation into this language.';

$L['cfg_xtradbrowusers_i18n_lang_code_second'] = 'Second additional language code';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use'] = 'Use the second additional language';
$L['cfg_xtradbrowusers_i18n_lang_code_second_use_hint'] = 'If active, editing forms will show fields for entering a translation into this language.';

$L['cfg_help_info'] = 'Developer help';   
$L['xtradbrowusers_setup_help_text'] = 'Detailed guide, links to related materials, or request help: <a href="https://github.com/webitproff/xtradbrowusers-cotonti" target="_blank" title="Opens in a new tab"><strong><u>plugin repository page</u></strong></a> on GitHub.com';

// ===========================
// PLUGIN INTERFACE (ADMIN)
// ===========================
$L['xtradbrowusers_tab_stats'] = 'Statistics';
$L['xtradbrowusers_tab_edit'] = 'Edit';
$L['xtradbrowusers_tab_i18n'] = 'Edit + Translations';
$L['xtradbrowusers_stats_total_users'] = 'Total users';
$L['xtradbrowusers_stats_xtra_rows'] = 'Records in xtradbrowusers';
$L['xtradbrowusers_stats_filled'] = 'Filled records';
$L['xtradbrowusers_extrafields_info'] = 'Extrafields parameters';
$L['xtradbrowusers_field_name'] = 'Field name';
$L['xtradbrowusers_field_type'] = 'Type';
$L['xtradbrowusers_field_description'] = 'Description';
$L['xtradbrowusers_field_variants'] = 'Variants';
$L['xtradbrowusers_field_params'] = 'Parameters';
$L['xtradbrowusers_field_default'] = 'Default';
$L['xtradbrowusers_field_required'] = 'Required';
$L['xtradbrowusers_field_enabled'] = 'Enabled';
$L['xtradbrowusers_username'] = 'User';
$L['xtradbrowusers_no_extrafields'] = 'No registered extrafields';
$L['xtradbrowusers_no_records'] = 'No records';
$L['xtradbrowusers_saved'] = 'Changes saved';
$L['xtradbrowusers_i18n_active'] = 'Multilingualism enabled';
$L['xtradbrowusers_i18n_disabled'] = 'Multilingualism disabled';
$L['xtradbrowusers_search_sq'] = 'Search by name/email';
$L['xtradbrowusers_filter_id'] = 'User ID';
$L['xtradbrowusers_filter_group'] = 'Group';
$L['xtradbrowusers_search_btn'] = 'Filter';
$L['xtradbrowusers_search_reset'] = 'Reset';
$L['xtradbrowusers_search_in_name'] = 'Name';
$L['xtradbrowusers_search_in_email'] = 'Email';
$L['xtradbrowusers_search_in_both'] = 'Name and email';
$L['xtradbrowusers_search_result_msg'] = 'Found %s for query %s';
$L['xtradbrowusers_search_result_none'] = 'Nothing found for query %s';
$L['xtradbrowusers_search_declen'] = 'records,record,records';
$L['xtradbrowusers_search_cat'] = 'User category';
$L['xtradbrowusers_all_categories'] = 'Without a category';
$L['xtradbrowusers_updated'] = 'Updated records: %d';

// ===========================
// Usage in template titles
// ===========================
$L['xtradbrowusers_profile_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Profile editing</span>'; 
$L['xtradbrowusers_details_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Public profile</span>';
$L['xtradbrowusers_details_tpl_desc'] = 'Administrator, for the user card it is recommended to use individual output of additional fields for their flexible customization';
$L['xtradbrowusers_edit_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Admin editing</span>';
$L['xtradbrowusers_list_tpl_title'] = '<span class="fw-semibold text-danger" style="letter-spacing: 1px;">Extrafields <code>xtradbrowusers</code>. Users list</span>';
$L['xtradbrowusers_details_tpl_show_hidden_content'] = '<span class="fw-semibold" style="letter-spacing: 1px;">Show</span>';

// ===========================
// Examples of title localization (_TITLE) for all demonstration fields
// ===========================
$L['xtra_x200_phone_extra_title'] = 'Additional phone';
$L['xtra_x200_about_extra_title'] = 'About me';
$L['xtra_x200_hire_date_title'] = 'Hire date';
$L['xtra_x200_salary_title'] = 'Salary';
$L['xtra_x200_department_title'] = 'Department';
$L['xtra_x200_experience_years_title'] = 'Experience (years)';
$L['xtra_x200_skill_level_title'] = 'Qualification level';
$L['xtra_x200_has_car_title'] = 'Has a car';
$L['xtra_x200_last_promotion_title'] = 'Last promotion date';
$L['xtra_x200_resume_file_title'] = 'Resume (file)';
$L['xtra_x200_residence_country_title'] = 'Country of residence';
$L['xtra_x200_english_level_title'] = 'English level';
$L['xtra_x200_interests_title'] = 'Interests';
$L['xtra_x200_work_schedule_title'] = 'Work schedule';
$L['xtra_x200_emergency_contact_title'] = 'Emergency contact';

// ===========================
// Examples of value localization for select, radio, checklistbox
// ===========================
$L['x200_department_not_specified'] = 'Not specified';
$L['x200_department_it'] = 'IT department';
$L['x200_department_marketing'] = 'Marketing';
$L['x200_department_sales'] = 'Sales';
$L['x200_department_support'] = 'Support';

$L['x200_skill_level_junior'] = 'Junior';
$L['x200_skill_level_middle'] = 'Middle';
$L['x200_skill_level_senior'] = 'Senior';
$L['x200_skill_level_lead'] = 'Lead';

$L['x200_has_car_yes'] = 'Yes';
$L['x200_has_car_no'] = 'No';

$L['x200_interests_sport'] = 'Sport';
$L['x200_interests_music'] = 'Music';
$L['x200_interests_it'] = 'IT';
$L['x200_interests_travel'] = 'Travel';

$L['x200_work_schedule_full_time'] = 'Full time';
$L['x200_work_schedule_shift'] = 'Shift';
$L['x200_work_schedule_remote'] = 'Remote work';
$L['x200_work_schedule_flexible'] = 'Flexible schedule';

// ===========================
// My title localizations (_TITLE)
// Can be left here if the plugin is not updated, but it is strongly recommended to move them to the theme/template localization file strings
// ===========================
$L['xtra_x010_phone_vendor_orders_title'] = 'Contact phone for calls';
$L['xtra_x011_tg_vendor_orders_title'] = 'Telegram for messages';
$L['xtra_x012_tg_chanel_vendor_title'] = 'Telegram channel';
$L['xtra_x020_about_vendor_text_title'] = 'About me briefly';
