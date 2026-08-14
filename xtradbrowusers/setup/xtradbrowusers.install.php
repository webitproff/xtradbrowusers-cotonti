<?php
/**
 * Filename: xtradbrowusers.install.php – Демонстрационные экстраполя при первичной установке
 *
 * Purpose: создаёт для таблицы cot_xtradbrowusers полный комплект демо-полей всех типов,
 *            поддерживаемых Cotonti Extrafields. Каждое поле сразу готово к работе,
 *            а в админке можно посмотреть живые примеры оформления экстраполей.
 *
 * Note:    Экстраполя типа = ['first_name', 'firstname', 'last_name', 'lastname', 'middle_name', 'middlename'];
 *          намерено не создавал, в силу их множества вариаций и возможного наличия на работающих сайтах
 *
 * Path:     plugins/xtradbrowusers/setup/xtradbrowusers.install.php
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


defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('xtradbrowusers', 'plug');

global $db_xtradbrowusers;

// ====================================================================
// 1. Текстовое поле (input) — Контактный телефон
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x010_phone_vendor_orders',
    'input',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" maxlength="255" />{$error}',
    '',
    '',
    0,
    'HTML',
    'Контактный телефон'
);

// ====================================================================
// 2. Текстовое поле (input) — Телеграм для сообщений
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x011_tg_vendor_orders',
    'input',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" maxlength="255" />{$error}',
    '',
    '',
    0,
    'HTML',
    'Телеграм для сообщений'
);

// ====================================================================
// 3. Текстовое поле (input) — Телеграм канал
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x012_tg_chanel_vendor',
    'input',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" maxlength="255" />{$error}',
    '',
    '',
    0,
    'HTML',
    'Телеграм канал'
);

// ====================================================================
// 4. Многострочный текст (textarea) — Обо мне
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x020_about_vendor_text',
    'textarea',
    '<textarea class="form-control" name="{$name}" rows="{$rows}" cols="{$cols}">{$value}</textarea>{$error}',
    '',
    '',
    0,
    'HTML',
    'Обо мне'
);

// ====================================================================
// 5. Простое текстовое поле (input) — Дополнительный телефон
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_phone_extra',
    'input',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" maxlength="255" />',
    '',
    '',
    0,
    'HTML',
    'Дополнительный телефон'
);

// ====================================================================
// 6. Многострочный текст (textarea) — О чем-то для текста
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_about_extra',
    'textarea',
    '<textarea class="form-control" name="{$name}" rows="5" cols="40">{$value}</textarea>',
    '',
    '',
    0,
    'HTML',
    'О себе'
);

// ====================================================================
// 7. Дата и время (datetime) — Дата найма
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_hire_date',
    'datetime',
    '<div class="row g-2">
        <div class="col-2">{$day}</div>
        <div class="col-3">{$month}</div>
        <div class="col-2">{$year}</div>
        <div class="col-2">{$hour}</div>
        <div class="col-1 text-center">:</div>
        <div class="col-2">{$minute}</div>
    </div>',
    '',
    '1714060800', // 26.04.2024 00:00
    0,
    'HTML',
    'Дата найма',
    '2010,2030,d.m.Y H:i'
);

// ====================================================================
// 8. Число с плавающей точкой (double) — Зарплата
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_salary',
    'double',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" />',
    '',
    '0.00',
    0,
    'HTML',
    'Зарплата'
);

// ====================================================================
// 9. Выпадающий список (select) — Отдел (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_department',
    'select',
    '<select class="form-select" name="{$name}">{$options}</select>',
    'not_specified,it,marketing,sales,support',
    'not_specified',
    0,
    'HTML',
    'Отдел'
);

// ====================================================================
// 10. Целое число (inputint) — Стаж (лет)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_experience_years',
    'inputint',
    '<input class="form-control" type="number" name="{$name}" value="{$value}" />',
    '',
    '0',
    false,
    'HTML',
    'Стаж (лет)',
    '',
    1,
    false,
    'INT UNSIGNED NOT NULL DEFAULT 0'
);

// ====================================================================
// 11. Выпадающий список (select) — Уровень квалификации (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_skill_level',
    'select',
    '<select class="form-select" name="{$name}">{$options}</select>',
    'junior,middle,senior,lead',
    'junior',
    false,
    'HTML',
    'Уровень квалификации'
);

// ====================================================================
// 12. Радиокнопки (radio) — Наличие автомобиля (варианты оставлены Yes/No)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_has_car',
    'radio',
    '<div class="form-check">
       <input class="form-check-input" type="radio" name="{$name}" value="{$value}" {$checked} />
       <label class="form-check-label">{$title}</label>
     </div>',
    'yes,no',
    'no',
    false,
    'HTML',
    'Наличие автомобиля'
);

// ====================================================================
// 13. Дата и время (datetime) — Дата последнего повышения
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_last_promotion',
    'datetime',
    '<div class="row g-2">
      <div class="col-2">{$day}</div>
      <div class="col-3">{$month}</div>
      <div class="col-2">{$year}</div>
      <div class="col-2">{$hour}</div>
      <div class="col-1 text-center">:</div>
      <div class="col-2">{$minute}</div>
    </div>',
    '',
    '1714060800',
    false,
    'HTML',
    'Дата последнего повышения',
    '2020,2030,d.m.Y H:i'
);

// ====================================================================
// 14. Загрузка файла (file) — Резюме
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_resume_file',
    'file',
    '<div class="list-group mb-3">
       <div class="list-group-item list-group-item-secondary">
         <strong>Текущий файл:</strong> <span class="text-primary">{$value}</span>
       </div>
       <div class="list-group-item">
         <label class="form-label">Заменить файл</label>
         <input type="file" class="form-control" name="{$name}" {$attrs}>
       </div>
       <div class="list-group-item list-group-item-danger">
         <div class="form-check">
           <input class="form-check-input" type="checkbox" name="{$delname}" value="1" id="delete_{$name}">
           <label class="form-check-label text-danger" for="delete_{$name}">
             Удалить текущий файл
           </label>
         </div>
       </div>
     </div>',
    'jpg,png,pdf,zip',
    '',
    false,
    '',
    'Резюме (файл)',
    'datas/exflds/xtradbrowusers'
);

// ====================================================================
// 15. Страна (country) — Страна проживания
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_residence_country',
    'country',
    '<select class="form-select" name="{$name}" size="1">
       <option value="">Выберите страну</option>{$options}
     </select>',
    '',
    'ua', // Украина
    false,
    '',
    'Страна проживания'
);

// ====================================================================
// 16. Ползунок (range) — Уровень английского
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_english_level',
    'range',
    '<select class="form-select" name="{$name}">{$options}</select>',
    '',
    '50',
    false,
    '',
    'Уровень английского (range)',
    '0,100'
);

// ====================================================================
// 17. Список с множественным выбором (checklistbox) — Интересы (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_interests',
    'checklistbox',
    '<div class="form-check">
       <input class="form-check-input" type="checkbox" name="{$name}" value="{$value}" {$checked} />
       <label class="form-check-label">{$title}</label>
     </div>',
    'sport,music,it,travel',
    'it',
    false,
    'HTML',
    'Интересы (checklistbox)'
);

// ====================================================================
// 18. Выпадающий список (select) — График работы (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_work_schedule',
    'select',
    '<select class="form-select" name="{$name}">{$options}</select>',
    'full_time,shift,remote,flexible',
    'full_time',
    false,
    'HTML',
    'График работы'
);

// ====================================================================
// 19. Текстовое поле (input) — Экстренный контакт
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'x200_emergency_contact',
    'input',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" maxlength="255" />',
    '',
    '',
    false,
    'HTML',
    'Экстренный контакт'
);

// ====================================================================
// Создание папки для файлов экстраполей
// ====================================================================
if (!is_dir('datas/exflds/xtradbrowusers')) {
    mkdir('datas/exflds/xtradbrowusers', 0777, true);
    // Защита от прямого доступа
    // file_put_contents('datas/exflds/xtradbrowusers/.htaccess', "Order deny,allow\nDeny from all");
}
