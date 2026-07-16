<?php
/**
 * xtradbrowusers API — центральные функции плагина
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
 * Date: Jul 16, 2026
 * @package xtradbrowusers
 * @version 1.0.1
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