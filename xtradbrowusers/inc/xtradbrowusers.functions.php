<?php
/**
 * Функции плагина (v1.2.9 с админкой, поддержкой i18n)
 *
 * Filename: xtradbrowusers.functions.php
 * Назначение: предоставляет базовые операции чтения/записи в таблицу `cot_xtradbrowusers`
 *            и `cot_xtradbrowusers_i18n`, функции для вывода справочного блока,
 *            работы с экстраполями, а также генерации селекта категорий пользователей.
 *
 * Path:     plugins/xtradbrowusers/inc/xtradbrowusers.functions.php
 *
 * Важные замечания по архитектуре:
 *   - Таблица `cot_xtradbrowusers` намеренно создана с первичным ключом `id` (не `user_id`).
 *     Это гарантирует, что при вызове `cot_extrafield_add()` для этой таблицы Cotonti НЕ
 *     добавляет префикс `user_` к именам создаваемых колонок. Физические имена колонок
 *     точно совпадают с именами экстраполей (`phone_extra`, `interests` и т.д.).
 *   - Связь с пользователем осуществляется через значение `id`, которое всегда равно
 *     `user_id` из таблицы `cot_users`. Благодаря ON DELETE CASCADE удаление пользователя
 *     автоматически удаляет строку из нашей таблицы на уровне БД.
 *
 * Функции, определённые в этом файле:
 *   - xtradbrowusers_setup_help_block(): возвращает HTML справки для настроек.
 *   - xtradbrowusers_setup_help_block_filter(): фильтр для custom-поля help_info.
 *   - xtradbrowusers_getExtrafields(): возвращает отсортированный массив экстраполей.
 *   - xtradbrowusers_load($userId): загружает запись экстраполей пользователя.
 *   - xtradbrowusers_save($userId, $data): сохраняет/обновляет запись.
 *   - xtradbrowusers_i18n_load($userId, $fieldName, $lang): возвращает перевод.
 *   - xtradbrowusers_i18n_save($userId, $fieldName, $lang, $value): сохраняет перевод.
 *   - xtradbrowusers_i18n_get_value($userId, $fieldName, $originalValue): получает значение с учётом перевода.
 *   - cot_xtradbrowusers_usercategories_selectcat2($check, $name, ...): генерирует селект категорий для Select2.
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

// Подключаем языковой файл плагина и стандартный API экстраполей
require_once cot_langfile('xtradbrowusers', 'plug');
require_once cot_incfile('extrafields');

// Регистрируем таблицу в реестре Cotonti, чтобы можно было обращаться
// через Cot::$db->xtradbrowusers
Cot::$db->registerTable('xtradbrowusers');
Cot::$db->registerTable('xtradbrowusers_i18n');

// Регистрируем таблицу в реестре экстраполей,
// чтобы Cot::$extrafields[Cot::$db->xtradbrowusers] был гарантированно массивом
cot_extrafields_register_table('xtradbrowusers');


/* 
 * ============================================================
 * НАЧАЛО | СЕКЦИЯ: ВЫВОД СПРАВОЧНОГО БЛОКА В НАСТРОЙКАХ ПЛАГИНА
 * ============================================================ 
*/

/**
 * Callback-функция для вывода справочного блока в настройках плагина.
 *
 * Используется в секции [BEGIN_COT_EXT_CONFIG] файла setup.php
 * при указании типа `custom`:
 *   help_info=11:custom:xtradbrowusers_setup_help_block()::Справка
 *
 * Возвращает HTML-код блока с подсказкой.
 * Текст берется из языкового файла по ключу 'xtradbrowusers_setup_help_text'.
 *
 * @return string HTML-код блока подсказки
 */
function xtradbrowusers_setup_help_block()
{
    // Делаем глобальный массив языковых строк доступным внутри функции
    global $L;

    // Ключ в массиве $L, содержащий текст подсказки
    $langKey = 'xtradbrowusers_setup_help_text';

    // Инициализируем переменную для текста подсказки
    $helpText = '';

    // По умолчанию используем красный алерт (danger) для случая, если строка не найдена
    $alertClass = 'alert-danger';

    // Если ключ существует, является строкой и не пустой
    if (isset($L[$langKey]) && is_string($L[$langKey]) && $L[$langKey] !== '') {
        // Используем значение из языкового файла
        $helpText = $L[$langKey];
        // Меняем класс на синий информационный алерт
        $alertClass = 'alert-info';
    }
    // Во всех остальных случаях
    else {
        // Определяем текущий язык пользователя 
        $currentLang = isset(Cot::$usr['lang']) && !empty(Cot::$usr['lang'])
            ? Cot::$usr['lang']
            : (isset(Cot::$cfg['defaultlang']) ? Cot::$cfg['defaultlang'] : 'en');

        // Если язык русский, выводим русское сообщение
        if ($currentLang === 'ru') {
            $helpText = 'Документация не найдена, потому что строки '
                      . '<code>$L[\'' . $langKey . '\']</code> '
                      . 'нет в файле переводов вашей текущей локализации интерфейса.';
        } else {
            // Для английского и всех остальных языков используем английский текст
            $helpText = 'Documentation is missing because the '
                      . '<code>$L[\'' . $langKey . '\']</code> '
                      . 'string is not present in your current interface translation file.';
        }
    }

    // Оборачиваем текст в HTML-блок с выбранным CSS-классом Bootstrap (alert-info или alert-danger).
    // НЕ используем htmlspecialchars, так как $helpText может содержать
    // разрешенные HTML-теги (например, ссылки).
    $html = '<div class="alert ' . $alertClass . '">'
          . $helpText
          . '</div>';

    // Возвращаем готовый HTML-код
    return $html;
}

/**
 * Функция-фильтр для custom-поля help_info.
 *
 * Вызывается Cotonti автоматически при сохранении настроек плагина.
 * Поскольку справочный блок не предназначен для сохранения значения,
 * возвращаем null, чтобы система не пыталась записать данные в БД.
 *
 * @param mixed $newValue  Входное значение, переданное из формы (обычно пустое)
 * @param array $cfgVar    Массив с данными конфигурационной переменной
 * @return null            Всегда возвращает null
 */
function xtradbrowusers_setup_help_block_filter($new_value, $cfg_var)
{
    // Ничего не сохраняем, просто возвращаем null
    return null;
}

/* 
 * ============================================================
 * КОНЕЦ | СЕКЦИЯ: ВЫВОД СПРАВОЧНОГО БЛОКА В НАСТРОЙКАХ ПЛАГИНА
 * ============================================================ 
*/


/**
 * Возвращает массив зарегистрированных экстраполей для таблицы cot_xtradbrowusers
 *
 * Данные берутся из глобального реестра Cot::$extrafields, который заполняется
 * системой при загрузке.
 *
 * @return array Ассоциативный массив, где ключ — имя поля, значение — конфигурация поля.
 */
function xtradbrowusers_getExtrafields()
{
    $fields = Cot::$extrafields[Cot::$db->xtradbrowusers] ?? [];
    ksort($fields);
    return $fields;
}

/**
 * Загружает запись дополнительных полей пользователя из таблицы cot_xtradbrowusers
 *
 * @param int $userId ID пользователя (совпадает с первичным ключом `id` в нашей таблице)
 * @return array|null Ассоциативный массив всех полей строки или null, если запись не найдена.
 */
function xtradbrowusers_load($userId)
{
    $res = Cot::$db->query(
        "SELECT * FROM " . Cot::$db->xtradbrowusers . " WHERE id = ?",
        [$userId]
    );
    return $res->fetch();
}

/**
 * Сохраняет (INSERT или UPDATE) запись дополнительных полей пользователя
 *
 * Логика работы:
 *   1. Проверяет, существует ли уже запись для данного `$userId`.
 *   2. Если существует — выполняет UPDATE по первичному ключу `id`.
 *   3. Если не существует — выполняет INSERT, вручную задавая значение `id`.
 *
 * Обратите внимание: массив `$data` должен содержать ключи, соответствующие
 * физическим именам колонок в таблице (без префикса `user_`). Например:
 * `['phone_extra' => '+123456789', 'interests' => 'IT,Спорт']`.
 *
 * @param int   $userId ID пользователя (будет записан в колонку `id`)
 * @param array $data   Ассоциативный массив значений экстраполей
 */
 
function xtradbrowusers_save($userId, $data)
{
    // Нормализуем значения: если массив, преобразуем в строку через запятую.
    // Это необходимо для полей типа checklistbox, которые отправляют массив выбранных значений.
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            // Преобразуем массив в строку с разделителем ","
            $data[$key] = implode(',', $value);
        }
    }

    // Проверяем, есть ли уже запись
    $exists = Cot::$db->query(
        "SELECT COUNT(*) FROM " . Cot::$db->xtradbrowusers . " WHERE id = ?",
        [$userId]
    )->fetchColumn() > 0;

    if ($exists) {
        // Обновляем существующую запись
        Cot::$db->update(Cot::$db->xtradbrowusers, $data, "id = ?", [$userId]);
    } else {
        // Вставляем новую запись, обязательно указываем id
        $data['id'] = $userId;
        Cot::$db->insert(Cot::$db->xtradbrowusers, $data);
    }
}


/**
 * Загружает перевод значения экстраполя для указанного языка
 * @return string|null
 */
function xtradbrowusers_i18n_load($userId, $fieldName, $lang)
{
    return Cot::$db->query(
        "SELECT value FROM " . Cot::$db->xtradbrowusers_i18n . " WHERE id = ? AND field_name = ? AND lang = ?",
        [$userId, $fieldName, $lang]
    )->fetchColumn() ?: null;
}

/**
 * Сохраняет или удаляет перевод значения экстраполя для конкретного языка
 * Если $value === null или '', запись удаляется.
 */
function xtradbrowusers_i18n_save($userId, $fieldName, $lang, $value)
{
    if ($value === null || $value === '') {
        Cot::$db->delete(Cot::$db->xtradbrowusers_i18n, "id = ? AND field_name = ? AND lang = ?", [$userId, $fieldName, $lang]);
    } else {
        Cot::$db->query(
            "INSERT INTO " . Cot::$db->xtradbrowusers_i18n . " (id, field_name, lang, value)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE value = VALUES(value)",
            [$userId, $fieldName, $lang, $value]
        );
    }
}


/**
 * Возвращает значение экстраполя с учётом мультиязычного перевода
 *
 * Если в настройках плагина включена мультиязычность (`xtradbrowusers_i18n_use`) и
 * текущий язык пользователя отличается от основного языка сайта, пытается найти перевод
 * в таблице `cot_xtradbrowusers_i18n`. Если перевод не найден, возвращается исходное значение.
 *
 * Если текущий язык совпадает с основным, но оригинальное значение пустое,
 * функция пытается вернуть первый доступный перевод из активных дополнительных языков
 * (первый непустой) в качестве запасного варианта. Это позволяет избежать
 * пустых полей при просмотре на основном языке, если заполнены переводы.
 *
 * @param int    $userId        ID пользователя
 * @param string $fieldName     Имя экстраполя
 * @param mixed  $originalValue Исходное значение (из основной таблицы)
 * @return mixed Значение на нужном языке или оригинал
 */
function xtradbrowusers_i18n_get_value($userId, $fieldName, $originalValue)
{
    // Выходим сразу, если мультиязычность отключена
    if (empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use'])) {
        return $originalValue;
    }

    // Определяем основной язык (тот, для которого переводы не хранятся)
    $defaultLang = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default'])
        ? Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default']
        : Cot::$cfg['defaultlang'];

    // Язык текущего посетителя
    $currentLang = Cot::$usr['lang'] ?? $defaultLang;

    // Если язык НЕ основной — пытаемся загрузить прямой перевод
    if ($currentLang !== $defaultLang) {
        $translated = xtradbrowusers_i18n_load($userId, $fieldName, $currentLang);
        return $translated !== null ? $translated : $originalValue;
    }

    // Основной язык, но основное значение не пустое — возвращаем его
    if ($originalValue !== null && $originalValue !== '') {
        return $originalValue;
    }

    // Основной язык и оригинал пуст — ищем первый непустой перевод среди активных языков
    $activeLangs = [];
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

    foreach ($activeLangs as $lang) {
        $fallback = xtradbrowusers_i18n_load($userId, $fieldName, $lang);
        if ($fallback !== null && $fallback !== '') {
            return $fallback;
        }
    }

    // Ничего не нашли — возвращаем оригинал (пустую строку)
    return $originalValue;
}
/**
 * Генерация селекта категорий пользователей для формы поиска.
 * Поддерживает Select2: отступы вложенности, плейсхолдер «Все категории».
 *
 * @global array $structure Структура категорий
 * @global array $cfg      Конфигурация Cotonti
 * @param string $check      Код выбранной категории (например, 'admins')
 * @param string $name       Имя атрибута name у селекта (обычно 'ucat')
 * @param string $subcat     Код родительской категории для ограничения списка
 * @param bool   $hideprivate Скрывать категории без права чтения
 * @return string HTML-код селекта с опциями
 */
function cot_xtradbrowusers_usercategories_selectcat2($check, $name, $subcat = '', $hideprivate = true)
{
    global $structure, $cfg;

    // Получаем чёрный список категорий из настроек плагина
    $blacklist_cfg = Cot::$cfg['usercategories']['usercategoriesblacktreecatspage'] ?? '';
    $blacklist = array_map('trim', explode(',', $blacklist_cfg));

    // Гарантируем, что массив категорий существует
    $structure['usercategories'] = is_array($structure['usercategories']) ? $structure['usercategories'] : [];

    // Начинаем накапливать опции.
    // ВАЖНО: первая опция с пустым value обязательна.
    // Если она не будет добавлена, Select2 при открытии списка
    // может автоматически выбрать первую категорию,
    // и в $ucat уйдёт её код, что включит ненужный фильтр.
	
    // Получаем перевод для "Все категории" из языкового файла.
    // Если ключа нет, используем стандартное "All".
    $allCategories = isset(Cot::$L['xtradbrowusers_all_categories'])
        ? Cot::$L['xtradbrowusers_all_categories']
        : Cot::$L['All'];

	$options = '<option value=""' . (empty($check) ? ' selected' : '') . '>' . htmlspecialchars($allCategories) . '</option>';

    // Перебираем категории
    foreach ($structure['usercategories'] as $i => $x) {
        // Пропускаем категории из чёрного списка
        if (in_array($i, $blacklist)) {
            continue;
        }

        // Проверка права на чтение
        $display = $hideprivate ? cot_auth('usercategories', $i, 'R') : true;

        // Если указана родительская категория, оставляем только её подкатегории
        if ($display && !empty($subcat) && isset($structure['usercategories'][$subcat])) {
            $mtch = $structure['usercategories'][$subcat]['path'] . ".";
            $mtchlen = mb_strlen($mtch);
            $display = (mb_substr($x['path'], 0, $mtchlen) == $mtch || $i === $subcat);
        }

        // Пропускаем системную категорию 'all'
        if ($display && $i !== 'all') {
            // Название категории
            $title = $x['title'];

            // Глубина вложенности (для отступов в Select2)
            $depth = substr_count($x['path'], '.');

            // Отметка выбранной категории
            $selected = ($i == $check) ? ' selected' : '';

            // Добавляем опцию с data-depth для отступов
            $options .= '<option value="' . htmlspecialchars($i) . '" data-depth="' . $depth . '"' . $selected . '>' .
                        htmlspecialchars($title) . '</option>';
        }
    }

    // Возвращаем селект.
    // Класс select2 включает Select2, data-placeholder подставляет текст,
    // когда ничего не выбрано.
    // Формируем селект с data-placeholder из языковой переменной
    return '<select name="' . htmlspecialchars($name) . '" class="form-select select2" data-placeholder="' .
           htmlspecialchars($allCategories) . '">' . $options . '</select>';
}
