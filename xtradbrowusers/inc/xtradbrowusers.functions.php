<?php
/**
 * центральные функции плагина (v1.1.1 с поддержкой i18n)
 *
 * Файл:     plugins/xtradbrowusers/inc/xtradbrowusers.functions.php
 * Назначение: предоставляет базовые операции чтения/записи в таблицу `cot_xtradbrowusers`,
 *            а также инициализирует глобальную переменную таблицы и подключает
 *            языковые файлы и API экстраполей.
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

// Подключаем языковой файл плагина и стандартный API экстраполей
require_once cot_langfile('xtradbrowusers', 'plug');
require_once cot_incfile('extrafields');

// Регистрируем таблицу в реестре Cotonti, чтобы можно было обращаться
// через Cot::$db->xtradbrowusers
Cot::$db->registerTable('xtradbrowusers');
Cot::$db->registerTable('xtradbrowusers_i18n');
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
    return Cot::$extrafields[Cot::$db->xtradbrowusers] ?? [];
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
