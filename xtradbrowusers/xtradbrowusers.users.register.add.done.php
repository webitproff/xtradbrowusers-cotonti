<?php
/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.add.done
  [END_COT_EXT]
==================== */

/**
 * Filename: xtradbrowusers.users.register.add.done.php – Сохранение данных после успешной регистрации пользователя
 *
 * Purpose:   Подключается к хуку `users.register.add.done`, который вызывается в файле
 *            /modules/users/inc/users.register.php после успешного создания пользователя.
 *            Получает ID нового пользователя из переменной $userid, затем импортирует
 *            и сохраняет все значения экстраполей плагина в таблицу `cot_xtradbrowusers`.
 *            Для полей типа file дополнительно вызывает `cot_extrafield_movefiles()` (перемещение файла).
 *
 * Мультиязычность на этапе регистрации:
 *   - Сохраняются только основные значения экстраполей.
 *   - Переводы в таблицу xtradbrowusers_i18n не записываются.
 *   - i18n-переводы для новых пользователей могут быть добавлены позже через админ-панель.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.users.register.add.done.php
 *
 * Extrafields Users Custom i18n plugin for Cotonti v1.+, PHP 8.5+, MySQL 8.4
 *
 * Source and updates   https://github.com/webitproff/xtradbrowusers-cotonti
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/extrafields-users-custom
 * Support:             https://abuyfile.com/ru/forums/cotonti/original/extrafields
 * API Extrafields:     https://github.com/Cotonti/Cotonti/blob/master/system/extrafields.php
 *
 * Date: Aug 15, 2026
 *
 * @package xtradbrowusers
 * @version 1.2.9.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */
 
 
defined('COT_CODE') or die('Wrong URL.');
require_once cot_incfile('xtradbrowusers', 'plug');

if (isset($userid) && $userid > 0) {
    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        $data = [];
			foreach ($extrafields as $exfld) {
				$fieldName = $exfld['field_name'];
				$inputName = 'rxtra_' . $fieldName;
				$oldValue = '';

				// Проверяем, было ли отправлено поле (или загружен файл)
				if (isset($_POST[$inputName]) || (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] !== UPLOAD_ERR_NO_FILE)) {
					$data[$fieldName] = cot_import_extrafields($inputName, $exfld, 'P', $oldValue, 'xtra_');
				} else {
					// Поле не отправлено — сохраняем пустое значение
					// Для checklistbox это корректно, для одиночного checkbox нужно было бы 0,
					// но в текущем наборе демо-полей таких нет.
					$data[$fieldName] = '';
				}
			}
			xtradbrowusers_save($userid, $data);
        // Перемещаем загруженные файлы в целевую папку
        cot_extrafield_movefiles();
    }
}



