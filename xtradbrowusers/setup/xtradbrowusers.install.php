<?php
/**
 * Filename: xtradbrowusers.install.php – Демонстрационные экстраполя при первичной установке
 *
 * Создаёт для таблицы cot_xtradbrowusers полный комплект демо-полей всех типов,
 * поддерживаемых Cotonti Extrafields. Каждое поле сразу готово к работе, а
 * в админке можно посмотреть живые примеры оформления экстраполей.
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

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('xtradbrowusers', 'plug');

global $db_xtradbrowusers;

// ====================================================================
// 1. Простое текстовое поле (input) — Дополнительный телефон
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'phone_extra',
    'input',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" maxlength="255" />',
    '',
    '',
    0,
    'HTML',
    'Дополнительный телефон'
);

// ====================================================================
// 2. Многострочный текст (textarea) — О себе
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'about_extra',
    'textarea',
    '<textarea class="form-control" name="{$name}" rows="5" cols="40">{$value}</textarea>',
    '',
    '',
    0,
    'HTML',
    'О себе'
);

// ====================================================================
// 3. Дата и время (datetime) — Дата найма
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'hire_date',
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
// 4. Число с плавающей точкой (double) — Зарплата
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'salary',
    'double',
    '<input class="form-control" type="text" name="{$name}" value="{$value}" />',
    '',
    '0.00',
    0,
    'HTML',
    'Зарплата'
);

// ====================================================================
// 5. Выпадающий список (select) — Отдел (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'department',
    'select',
    '<select class="form-select" name="{$name}">{$options}</select>',
    'not_specified,it,marketing,sales,support',
    'not_specified',
    0,
    'HTML',
    'Отдел'
);

// ====================================================================
// 6. Целое число (inputint) — Стаж (лет)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'experience_years',
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
// 7. Выпадающий список (select) — Уровень квалификации (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'skill_level',
    'select',
    '<select class="form-select" name="{$name}">{$options}</select>',
    'junior,middle,senior,lead',
    'junior',
    false,
    'HTML',
    'Уровень квалификации'
);

// ====================================================================
// 8. Радиокнопки (radio) — Наличие автомобиля (варианты оставлены Yes/No)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'has_car',
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
// 9. Дата и время (datetime) — Дата последнего повышения
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'last_promotion',
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
// 10. Загрузка файла (file) — Резюме
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'resume_file',
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
// 11. Страна (country) — Страна проживания
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'residence_country',
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
// 12. Ползунок (range) — Уровень английского
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'english_level',
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
// 13. Список с множественным выбором (checklistbox) — Интересы (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'interests',
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
// 14. Выпадающий список (select) — График работы (варианты на латинице)
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'work_schedule',
    'select',
    '<select class="form-select" name="{$name}">{$options}</select>',
    'full_time,shift,remote,flexible',
    'full_time',
    false,
    'HTML',
    'График работы'
);

// ====================================================================
// 15. Текстовое поле (input) — Экстренный контакт
// ====================================================================
cot_extrafield_add(
    $db_xtradbrowusers,
    'emergency_contact',
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
