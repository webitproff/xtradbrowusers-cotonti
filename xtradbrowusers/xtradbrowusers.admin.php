<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * ============================================================
 * ДОКУМЕНТАЦИЯ ПО ХУКУ `tools` И ФАЙЛУ xtradbrowusers.admin.php
 * ============================================================
 *
 * Хук `tools` в Cotonti используется для подключения административных страниц
 * плагинов через раздел «Администрирование» (admin.php?m=other&p=<код_плагина>).
 *
 * В файле system/extensions/ExtensionsService.php метод getAdminPageUrl()
 * проверяет наличие активных обработчиков хука `tools` для конкретного плагина
 * и, если они есть, возвращает URL:
 *   admin.php?m=other&p=<код_плагина>
 *
 * В файле system/router/Router.php метод routeAdminOther() обрабатывает маршрут
 * для `admin.php?m=other` и подключает файл с хуком `tools`, если он
 * зарегистрирован для данного плагина.
 *
 * Наш файл xtradbrowusers.admin.php зарегистрирован с хуком `tools` через заголовок:
 *   [BEGIN_COT_EXT]
 *   Hooks=tools
 *   [END_COT_EXT]
 *
 * Это означает, что при переходе по URL админки плагина Cotonti найдёт наш файл
 * через cot_getextplugins('tools', ...) и выполнит его код, который формирует
 * интерфейс администрирования плагина (вкладки, таблицы, обработку сохранения).
 *
 * Таким образом, xtradbrowusers.admin.php является точкой входа в админ-панель
 * плагина и обрабатывает все действия, связанные с управлением экстраполями
 * пользователей и их переводами.
 * ============================================================
 */
 

/**
 * Admin panel for xtradbrowusers – Statistics, Edit extrafields, Edit with i18n
 *
 * Filename: xtradbrowusers.admin.php
 * Purpose:   Предоставляет главный интерфейс администрирования плагина.
 *            Реализует три вкладки: «Статистика», «Редактирование», «Редактирование + Переводы».
 *            Обеспечивает поиск, фильтрацию, массовое редактирование и сохранение
 *            экстраполей пользователей, а также управление мультиязычными переводами.
 *
 *            Вкладка «Статистика»:
 *              - общее количество пользователей;
 *              - количество записей в таблице cot_xtradbrowusers;
 *              - количество записей с хотя бы одним заполненным экстраполем;
 *              - таблица всех зарегистрированных экстраполей с их параметрами
 *                (имя, тип, описание, варианты, параметры, значение по умолчанию,
 *                обязательность, активность).
 *
 *            Вкладка «Редактирование»:
 *              - список пользователей с возможностью массового редактирования;
 *              - фильтры: текстовый поиск (по имени/email/обоим), по ID,
 *                по группе, по категории пользователей (если активен usercategories);
 *              - сохранение только реально изменённых полей;
 *              - корректная обработка новых записей: для checkbox и datetime
 *                начальное значение 0, для select — field_default, для остальных — пустая строка;
 *              - нормализация значений для checklistbox (сортировка, удаление служебного nullval)
 *                и datetime (преобразование массива в timestamp);
 *              - сравнение значений с учётом сортировки для checklistbox и приведения
 *                datetime к строке Y-m-d H:i;
 *              - ссылка на публичный профиль пользователя.
 *
 *            Вкладка «Редактирование + Переводы (i18n)»:
 *              - доступна только если включена мультиязычность в настройках плагина;
 *              - редактирование основных значений разрешено только для типов input и textarea;
 *              - для каждого разрешённого поля выводятся поля переводов для активных
 *                дополнительных языков; для textarea перевод также является многострочным;
 *              - остальные типы полей отображаются как читаемые значения:
 *                  * select, radio, range — через языковые ключи (если есть);
 *                  * checklistbox — элементы через запятую с локализацией через $L;
 *                  * country — название страны из файла countries.lang.php;
 *                  * datetime — форматированная дата, нулевые даты скрываются;
 *                  * checkbox — «Да»/«Нет»;
 *              - для новых записей редактируемые поля показываются с дефолтными значениями,
 *                нередактируемые — пустыми;
 *              - сохранение переводов выполняется только для input/textarea.
 *
 *            Мультиязычность в админ-панели:
 *              - переводы сохраняются только для input и textarea;
 *              - select, radio, checklistbox локализуются через языковой массив $L;
 *              - checkbox хранит 1/0, локализация — в шаблоне;
 *              - inputint, double, datetime, range, file, country не имеют полей перевода
 *                в админке, их оригинальные значения отображаются как есть.
 *
 *            Загрузка файла стран: используется $_SERVER['DOCUMENT_ROOT'] . '/lang/{lang}/countries.{lang}.lang.php',
 *            чтобы получить локализованные названия стран для поля country.
 *
 * Path:     plugins/xtradbrowusers/xtradbrowusers.admin.php
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

require_once cot_langfile('xtradbrowusers', 'plug');
require_once cot_incfile('xtradbrowusers', 'plug');
require_once cot_incfile('extrafields');

// Подключаем usercategories, если плагин активен
if (cot_plugin_active('usercategories')) {
    require_once cot_incfile('usercategories', 'plug');
}

$tab = cot_import('tab', 'G', 'ALP') ?: 'stats';
$a   = cot_import('a',   'G', 'ALP');

$t = new XTemplate(cot_tplfile('xtradbrowusers.admin', 'plug', true));

$t->assign([
    'TAB_STATS_ACTIVE' => $tab === 'stats' ? 'active' : '',
    'TAB_EDIT_ACTIVE'  => $tab === 'edit'  ? 'active' : '',
    'TAB_I18N_ACTIVE'  => $tab === 'i18n'  ? 'active' : '',
    'URL_STATS'        => cot_url('admin', ['m'=>'other','p'=>'xtradbrowusers','tab'=>'stats']),
    'URL_EDIT'         => cot_url('admin', ['m'=>'other','p'=>'xtradbrowusers','tab'=>'edit']),
    'URL_I18N'         => cot_url('admin', ['m'=>'other','p'=>'xtradbrowusers','tab'=>'i18n']),
]);

$perPage = (int) (Cot::$cfg['plugin']['xtradbrowusers']['perpage'] ?? 20);
if ($perPage < 1) $perPage = 20;

/* ========== ВКЛАДКА СТАТИСТИКА ========== */
if ($tab === 'stats') {
    $totalUsers = Cot::$db->query(
        "SELECT COUNT(*) FROM $db_users WHERE user_id > 0"
    )->fetchColumn();

    $totalXtraRows = Cot::$db->query(
        "SELECT COUNT(*) FROM " . Cot::$db->xtradbrowusers
    )->fetchColumn();

    $extrafields = xtradbrowusers_getExtrafields();
    $filledCount = 0;
    if (!empty($extrafields)) {
        $nonEmpty = [];
        foreach ($extrafields as $exfld) {
            $fname = $exfld['field_name'];
            $nonEmpty[] = "$fname IS NOT NULL AND $fname != ''";
        }
        if (!empty($nonEmpty)) {
            $where = implode(' OR ', $nonEmpty);
            $filledCount = Cot::$db->query(
                "SELECT COUNT(*) FROM " . Cot::$db->xtradbrowusers . " WHERE $where"
            )->fetchColumn();
        }
    }

    $t->assign([
        'STATS_TOTAL_USERS'       => $totalUsers,
        'STATS_TOTAL_XTRA_ROWS'   => $totalXtraRows,
        'STATS_FILLED_COUNT'      => $filledCount,
    ]);

    if (!empty($extrafields)) {
        foreach ($extrafields as $exfld) {
            $t->assign([
                'FIELD_NAME'        => htmlspecialchars($exfld['field_name']),
                'FIELD_TYPE'        => htmlspecialchars($exfld['field_type']),
                'FIELD_DESCRIPTION' => htmlspecialchars($exfld['field_description'] ?? ''),
                'FIELD_VARIANTS'    => htmlspecialchars($exfld['field_variants'] ?? ''),
                'FIELD_PARAMS'      => htmlspecialchars($exfld['field_params'] ?? ''),
                'FIELD_DEFAULT'     => htmlspecialchars($exfld['field_default'] ?? ''),
                'FIELD_REQUIRED'    => $exfld['field_required'] ? Cot::$L['Yes'] : Cot::$L['No'],
                'FIELD_ENABLED'     => $exfld['field_enabled'] ? Cot::$L['Yes'] : Cot::$L['No'],
            ]);
            $t->parse('MAIN.STATS_EXTRAFIELDS_ROW');
        }
    } else {
        $t->parse('MAIN.STATS_NO_EXTRAFIELDS');
    }
}


/* ========== ВКЛАДКА РЕДАКТИРОВАНИЕ (основные данные) ========== */
if ($tab === 'edit') {
    list($pg, $d, $durl) = cot_import_pagenav('d', $perPage);

    // Параметры поиска – из POST при сохранении, иначе из GET
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sq        = cot_import('sq', 'P', 'TXT');
        $search_in = cot_import('search_in', 'P', 'ALP');
        $filter_id = cot_import('filter_id', 'P', 'INT');
        $filter    = cot_import('filter', 'P', 'ALP');
        $ucat      = cot_import('ucat', 'P', 'TXT');
    } else {
        $sq        = cot_import('sq', 'G', 'TXT');
        $search_in = cot_import('search_in', 'G', 'ALP', 8);
        $filter_id = cot_import('filter_id', 'G', 'INT');
        $filter    = cot_import('filter', 'G', 'ALP');
        $ucat      = cot_import('ucat', 'G', 'TXT');
    }
    $sq = ($sq !== null) ? trim($sq) : '';
    if (!in_array($search_in, ['name', 'email', 'both'])) {
        $search_in = 'name';
    }
    $filter = empty($filter) ? 'all' : $filter;
    $ucat = $ucat ?? '';

    // Сохраняем все параметры для URL
    $urlParams = [
        'm'         => 'other',
        'p'         => 'xtradbrowusers',
        'tab'       => 'edit',
        'sq'        => $sq,
        'search_in' => $search_in,
        'filter_id' => $filter_id,
        'filter'    => $filter,
        'ucat'      => $ucat,
    ];

    $showAllItems = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_showallitems']);

    // ========================
    // Сохранение изменений
    // ========================
    if ($a === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $ids = isset($_POST['ids']) ? array_map('intval', $_POST['ids']) : [];
        $updatedCount = 0;

        foreach ($ids as $id) {
            $oldData = xtradbrowusers_load($id);
            $isNewRecord = empty($oldData);
            if ($isNewRecord) {
                $oldData = [];
            }

            $data = [];
            $changed = false;
            $extrafields = xtradbrowusers_getExtrafields();

            foreach ($extrafields as $exfld) {
                $fname = $exfld['field_name'];
                $postKey = 'rxtra_' . $fname;

                // Определяем старое значение
                if ($isNewRecord) {
                    switch ($exfld['field_type']) {
                        case 'checkbox':
                            $oldValue = 0;
                            break;
                        case 'datetime':
                            $oldValue = 0;
                            break;
                        case 'select':
                            // Для select форма автоматически подставляет дефолт при пустом значении
                            $oldValue = $exfld['field_default'] ?? '';
                            break;
                        default:
                            $oldValue = '';
                            break;
                    }
                } else {
                    $oldValue = $oldData[$fname] ?? '';
                }

                $newValue = $oldValue; // по умолчанию не меняем
                $isPosted = isset($_POST[$postKey][$id]);

                // Обработка в зависимости от типа
                if ($exfld['field_type'] == 'checkbox') {
                    $newValue = $isPosted ? 1 : 0;
                } elseif ($exfld['field_type'] == 'checklistbox') {
                    if ($isPosted && is_array($_POST[$postKey][$id])) {
                        $raw = $_POST[$postKey][$id];
                        unset($raw['nullval']);
                        $filtered = array_filter($raw, 'strlen');
                        sort($filtered);
                        $newValue = implode(',', $filtered);
                    } else {
                        $newValue = '';
                    }
                } elseif ($exfld['field_type'] == 'datetime') {
                    if ($isPosted && is_array($_POST[$postKey][$id])) {
                        $raw = $_POST[$postKey][$id];
                        $year   = isset($raw['year'])   ? (int)$raw['year']   : 0;
                        $month  = isset($raw['month'])  ? (int)$raw['month']  : 0;
                        $day    = isset($raw['day'])    ? (int)$raw['day']    : 0;
                        $hour   = isset($raw['hour'])   ? (int)$raw['hour']   : 0;
                        $minute = isset($raw['minute']) ? (int)$raw['minute'] : 0;
                        if ($year && $month && $day) {
                            $newValue = mktime($hour, $minute, 0, $month, $day, $year);
                        } else {
                            $newValue = 0;
                        }
                    } elseif ($isPosted) {
                        $newValue = (int)$_POST[$postKey][$id];
                    }
                } else {
                    if ($isPosted) {
                        $raw = $_POST[$postKey][$id];
                        $newValue = is_array($raw) ? implode(',', $raw) : trim($raw);
                    }
                }

                // Сравнение с учётом типа
                if ($exfld['field_type'] == 'checklistbox') {
                    $newCompare = $newValue;
                    if (!empty($newCompare)) {
                        $newArray = explode(',', $newCompare);
                        sort($newArray);
                        $newCompare = implode(',', $newArray);
                    }
                    $oldCompare = $oldValue;
                    if (!empty($oldCompare)) {
                        $oldArray = explode(',', $oldCompare);
                        sort($oldArray);
                        $oldCompare = implode(',', $oldArray);
                    }
                    if ($newCompare != $oldCompare) {
                        $data[$fname] = $newValue;
                        $changed = true;
                    }
                } elseif ($exfld['field_type'] == 'datetime') {
                    $newCompare = is_numeric($newValue) ? date('Y-m-d H:i', (int)$newValue) : $newValue;
                    $oldCompare = is_numeric($oldValue) ? date('Y-m-d H:i', (int)$oldValue) : $oldValue;
                    if ($newCompare != $oldCompare) {
                        $data[$fname] = $newValue;
                        $changed = true;
                    }
                } else {
                    if ($newValue != $oldValue) {
                        $data[$fname] = $newValue;
                        $changed = true;
                    }
                }
            }

            if ($changed) {
                xtradbrowusers_save($id, $data);
                $updatedCount++;
            }
        }

        $msg = '';
        if ($updatedCount > 0) {
            $msg .= sprintf(Cot::$L['xtradbrowusers_updated'], $updatedCount);
        }
        if (!empty($msg)) {
            cot_message($msg);
        }

        $backUrl = cot_url('admin', array_merge($urlParams, ['d' => $durl]));
        $backUrl = str_replace('&amp;', '&', $backUrl);
        cot_redirect($backUrl);
    }

    // ========================
    // Условия WHERE для пользователей
    // ========================
    $sqlwhere = "u.user_id > 0";
    $params = [];

    if (!empty($sq)) {
        $sq_escaped = "%$sq%";
        if ($search_in == 'name') {
            $sqlwhere .= " AND u.user_name LIKE :sq";
        } elseif ($search_in == 'email') {
            $sqlwhere .= " AND u.user_email LIKE :sq";
        } else {
            $sqlwhere .= " AND (u.user_name LIKE :sq OR u.user_email LIKE :sq)";
        }
        $params['sq'] = $sq_escaped;
    }

    if (!empty($filter_id)) {
        $sqlwhere .= " AND u.user_id = :fid";
        $params['fid'] = $filter_id;
    }

    if ($filter != 'all') {
        $sqlwhere .= " AND u.user_maingrp = :grp";
        $params['grp'] = $filter;
    }

    if (!empty($ucat) && !empty(Cot::$structure['usercategories'])) {
        $cats = cot_structure_children('usercategories', $ucat);
        $cats[] = $ucat;
        $catConditions = [];
        foreach ($cats as $cat) {
            $catConditions[] = "FIND_IN_SET('" . Cot::$db->prep($cat) . "', u.user_cats)";
        }
        if (!empty($catConditions)) {
            $sqlwhere .= " AND (" . implode(" OR ", $catConditions) . ")";
        }
    }

    // Подсчёт количества записей
    if ($showAllItems) {
        $total = Cot::$db->query(
            "SELECT COUNT(*) FROM $db_users AS u WHERE $sqlwhere", $params
        )->fetchColumn();
    } else {
        $total = Cot::$db->query(
            "SELECT COUNT(*) FROM " . Cot::$db->xtradbrowusers . " AS t
             LEFT JOIN $db_users AS u ON u.user_id = t.id
             WHERE $sqlwhere", $params
        )->fetchColumn();
    }

    $searchMsg = '';
    if (!empty($sq) || !empty($filter_id) || !empty($ucat)) {
        $totalFound = (int)$total;
        $queryDesc = [];
        if (!empty($sq)) $queryDesc[] = '«'.htmlspecialchars($sq).'»';
        if (!empty($filter_id)) $queryDesc[] = 'ID '.$filter_id;
        if (!empty($ucat)) $queryDesc[] = Cot::$structure['usercategories'][$ucat]['title'] ?? $ucat;
        if ($totalFound > 0) {
            $searchMsg = sprintf(Cot::$L['xtradbrowusers_search_result_msg'], cot_declension($totalFound, Cot::$L['xtradbrowusers_search_declen']), implode(', ', $queryDesc));
        } else {
            $searchMsg = sprintf(Cot::$L['xtradbrowusers_search_result_none'], implode(', ', $queryDesc));
        }
    }

    // Получение данных
    if ($showAllItems) {
        $items = Cot::$db->query(
            "SELECT u.user_id, u.user_name, u.user_email, t.*
             FROM $db_users AS u
             LEFT JOIN " . Cot::$db->xtradbrowusers . " AS t ON t.id = u.user_id
             WHERE $sqlwhere
             ORDER BY u.user_id DESC
             LIMIT $d, $perPage",
            $params
        )->fetchAll();
    } else {
        $items = Cot::$db->query(
            "SELECT t.*, u.user_name, u.user_email
             FROM " . Cot::$db->xtradbrowusers . " AS t
             LEFT JOIN $db_users AS u ON u.user_id = t.id
             WHERE $sqlwhere
             ORDER BY t.id DESC
             LIMIT $d, $perPage",
            $params
        )->fetchAll();
    }

    // Список групп для фильтра
    $groups = [];
    $grpRes = Cot::$db->query("SELECT grp_id, grp_title FROM $db_groups ORDER BY grp_id")->fetchAll();
    foreach ($grpRes as $grp) {
        $groups[$grp['grp_id']] = $grp['grp_title'];
    }

    // Выпадающий список категорий пользователей
    $ucatSelect = '';
    if (cot_plugin_active('usercategories') && function_exists('cot_xtradbrowusers_usercategories_selectcat2')) {
        $ucatSelect = cot_xtradbrowusers_usercategories_selectcat2($ucat, 'ucat');
    }

    $t->assign([
        'SEARCH_ACTION_URL'       => cot_url('admin'),
        'SEARCH_SQ'               => cot_inputbox('text', 'sq', !empty($sq) ? htmlspecialchars($sq) : '', 'class="form-control" autofocus'),
        'SEARCH_FILTER_ID'        => cot_inputbox('number', 'filter_id', !empty($filter_id) ? $filter_id : '', 'class="form-control" placeholder="ID"'),
        'FILTER_GROUP_SELECT'     => cot_selectbox($filter, 'filter', array_merge(['all'], array_keys($groups)), array_merge([Cot::$L['All']], array_values($groups)), false),
        'SEARCH_CAT_SELECT2'      => $ucatSelect,
        'SEARCH_RESULT_MSG'       => $searchMsg,
        'SEARCH_IN_NAME_CHECKED'  => ($search_in == 'name') ? 'checked="checked"' : '',
        'SEARCH_IN_EMAIL_CHECKED' => ($search_in == 'email')? 'checked="checked"' : '',
        'SEARCH_IN_BOTH_CHECKED'  => ($search_in == 'both') ? 'checked="checked"' : '',
        'SEARCH_SQ_VALUE'         => htmlspecialchars($sq ?? ''),
        'SEARCH_IN_VALUE'         => htmlspecialchars($search_in ?? ''),
        'SEARCH_FILTER_ID_VALUE'  => htmlspecialchars($filter_id ?? ''),
        'FILTER_VALUE'            => htmlspecialchars($filter),
        'SEARCH_UCAT_VALUE'       => htmlspecialchars($ucat),
    ]);

    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        foreach ($extrafields as $exfld) {
            $t->assign('FIELD_HEADER_TITLE', htmlspecialchars(cot_extrafield_title($exfld, 'xtra_')));
            $t->parse('MAIN.EDIT_FIELDS_HEADER');
        }
    }

    if (!empty($items)) {
        foreach ($items as $row) {
            $id = $row['user_id'] ?? $row['id'];
            $itemUrl = cot_url('users', ['m' => 'details', 'id' => $id]); 
            $t->assign([
                'MANAGE_ID'    => $id,
                'MANAGE_USER'  => htmlspecialchars($row['user_name'] ?? ''),
                'MANAGE_URL'   => $itemUrl,
            ]);

            foreach ($extrafields as $exfld) {
                $fname = $exfld['field_name'];
                // Для новых записей значение пустое (не показываем дефолты)
                $value = $row[$fname] ?? '';
                $inputName = 'rxtra_' . $fname . '[' . $id . ']';
                $fieldHtml = cot_build_extrafields($inputName, $exfld, $value);
                $t->assign('FIELD_HTML', $fieldHtml);
                $t->parse('MAIN.EDIT_ROW.FIELD_CELL');
            }
            $t->parse('MAIN.EDIT_ROW');
        }
    } else {
        $t->parse('MAIN.EDIT_EMPTY');
    }

    $pagenav = cot_pagenav('admin', $urlParams, $d, $total, $perPage, 'd');
    $t->assign(cot_generatePaginationTags($pagenav));
    $t->assign('EDIT_FORM_URL', cot_url('admin', ['m'=>'other','p'=>'xtradbrowusers','tab'=>'edit','a'=>'update','d'=>$durl]));
}

/* ========== ВКЛАДКА РЕДАКТИРОВАНИЕ С ПЕРЕВОДАМИ (i18n) ========== */
if ($tab === 'i18n') {
    list($pg, $d, $durl) = cot_import_pagenav('d', $perPage);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sq        = cot_import('sq', 'P', 'TXT');
        $search_in = cot_import('search_in', 'P', 'ALP');
        $filter_id = cot_import('filter_id', 'P', 'INT');
        $filter    = cot_import('filter', 'P', 'ALP');
        $ucat      = cot_import('ucat', 'P', 'TXT');
    } else {
        $sq        = cot_import('sq', 'G', 'TXT');
        $search_in = cot_import('search_in', 'G', 'ALP', 8);
        $filter_id = cot_import('filter_id', 'G', 'INT');
        $filter    = cot_import('filter', 'G', 'ALP');
        $ucat      = cot_import('ucat', 'G', 'TXT');
    }
    $sq = ($sq !== null) ? trim($sq) : '';
    if (!in_array($search_in, ['name', 'email', 'both'])) {
        $search_in = 'name';
    }
    $filter = empty($filter) ? 'all' : $filter;
    $ucat = $ucat ?? '';

    $urlParams = [
        'm'         => 'other',
        'p'         => 'xtradbrowusers',
        'tab'       => 'i18n',
        'sq'        => $sq,
        'search_in' => $search_in,
        'filter_id' => $filter_id,
        'filter'    => $filter,
        'ucat'      => $ucat,
    ];

    $showAllItems = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_showallitems']);

    // Языковые настройки
    $i18nActive = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_use']);
    $activeLangs = [];
    $langDefault = !empty(Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default'])
        ? Cot::$cfg['plugin']['xtradbrowusers']['xtradbrowusers_i18n_lang_code_default']
        : Cot::$cfg['defaultlang'];

    if ($i18nActive) {
        $pairs = [
            ['use' => 'xtradbrowusers_i18n_lang_code_first_use',  'code' => 'xtradbrowusers_i18n_lang_code_first'],
            ['use' => 'xtradbrowusers_i18n_lang_code_second_use', 'code' => 'xtradbrowusers_i18n_lang_code_second'],
        ];
        foreach ($pairs as $pair) {
            if (!empty(Cot::$cfg['plugin']['xtradbrowusers'][$pair['use']])
                && !empty(Cot::$cfg['plugin']['xtradbrowusers'][$pair['code']])) {
                $lang = Cot::$cfg['plugin']['xtradbrowusers'][$pair['code']];
                if ($lang !== $langDefault) {
                    $activeLangs[] = $lang;
                }
            }
        }
    }

    // Типы полей, которые можно редактировать и сохранять
    $i18nEditableTypes = ['input', 'textarea'];
    // Загружаем названия стран (для поля типа country)
	$userLang = !empty(Cot::$usr['lang']) ? Cot::$usr['lang'] : 'ru';
	$countryFile = $_SERVER['DOCUMENT_ROOT'] . '/lang/' . $userLang . '/countries.' . $userLang . '.lang.php';
	if (file_exists($countryFile)) {
		include $countryFile;
	}
    // Функция форматирования значения для просмотра
    // Функция форматирования значения для просмотра
    $formatValue = function($exfld, $value) {
        if ($value === null || $value === '') {
            return '';
        }
        switch ($exfld['field_type']) {
            case 'checkbox':
                return $value ? Cot::$L['Yes'] : Cot::$L['No'];

			case 'datetime':
				if ((int)$value === 0) {
					return '';
				}
				return cot_date('datetime_medium', (int)$value);
				
            case 'country':
                // Используем глобальный массив $cot_countries из языкового файла стран
                global $cot_countries;
                return isset($cot_countries[$value]) ? $cot_countries[$value] : htmlspecialchars($value);

            case 'checklistbox':
                // Значение хранится как строка "значение1,значение2,..."
                $parts = explode(',', $value);
                $localized = [];
                foreach ($parts as $part) {
                    $part = trim($part);
                    if ($part === '') continue;
                    // Пытаемся найти языковой ключ: имя_поля_значение
                    $langKey = $exfld['field_name'] . '_' . $part;
                    $localized[] = isset(Cot::$L[$langKey]) ? Cot::$L[$langKey] : $part;
                }
                return htmlspecialchars(implode(', ', $localized));

            default:
                // Для select, radio, range и прочих пробуем локализовать через $L
                $langKey = $exfld['field_name'] . '_' . $value;
                if (isset(Cot::$L[$langKey])) {
                    return Cot::$L[$langKey];
                }
                return htmlspecialchars($value);
        }
    };

    // ========================
    // Сохранение изменений
    // ========================
    if ($a === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $ids = isset($_POST['ids']) ? array_map('intval', $_POST['ids']) : [];
        $updatedCount = 0;

        foreach ($ids as $id) {
            $oldData = xtradbrowusers_load($id);
            $isNewRecord = empty($oldData);
            if ($isNewRecord) {
                $oldData = [];
            }

            $data = [];
            $changed = false;
            $extrafields = xtradbrowusers_getExtrafields();

            // 1. Обрабатываем основные поля (только input и textarea)
            foreach ($extrafields as $exfld) {
                if (!in_array($exfld['field_type'], $i18nEditableTypes)) {
                    continue;
                }

                $fname = $exfld['field_name'];
                $postKey = 'rxtra_' . $fname;

                if ($isNewRecord) {
                    $oldValue = $exfld['field_default'] ?? '';
                } else {
                    $oldValue = $oldData[$fname] ?? '';
                }

                $newValue = $oldValue;
                if (isset($_POST[$postKey][$id])) {
                    $raw = $_POST[$postKey][$id];
                    $newValue = is_array($raw) ? implode(',', $raw) : trim($raw);
                }

                if ($newValue != $oldValue) {
                    $data[$fname] = $newValue;
                    $changed = true;
                }
            }

            if ($changed) {
                xtradbrowusers_save($id, $data);
                $updatedCount++;
            }

            // 2. Обрабатываем переводы (только input и textarea)
            if ($i18nActive && !empty($activeLangs)) {
                $i18nChanged = false;
                foreach ($extrafields as $exfld) {
                    if (!in_array($exfld['field_type'], $i18nEditableTypes)) {
                        continue;
                    }
                    $fname = $exfld['field_name'];
                    foreach ($activeLangs as $lang) {
                        if ($lang === $langDefault) {
                            continue;
                        }
                        $i18nKey = 'rxtra_' . $fname . '_' . $lang;
                        if (isset($_POST[$i18nKey][$id])) {
                            $newI18nValue = trim($_POST[$i18nKey][$id]);
                            $oldI18nValue = xtradbrowusers_i18n_load($id, $fname, $lang) ?? '';
                            if ($newI18nValue != $oldI18nValue) {
                                xtradbrowusers_i18n_save($id, $fname, $lang, $newI18nValue);
                                $i18nChanged = true;
                            }
                        }
                    }
                }
                if ($i18nChanged && !$changed) {
                    $updatedCount++;
                }
            }
        }

        $msg = '';
        if ($updatedCount > 0) {
            $msg .= sprintf(Cot::$L['xtradbrowusers_updated'], $updatedCount);
        }
        if (!empty($msg)) {
            cot_message($msg);
        }

        $backUrl = cot_url('admin', array_merge($urlParams, ['d' => $durl]));
        $backUrl = str_replace('&amp;', '&', $backUrl);
        cot_redirect($backUrl);
    }

    // ========================
    // WHERE для пользователей
    // ========================
    $sqlwhere = "u.user_id > 0";
    $params = [];

    if (!empty($sq)) {
        $sq_escaped = "%$sq%";
        if ($search_in == 'name') {
            $sqlwhere .= " AND u.user_name LIKE :sq";
        } elseif ($search_in == 'email') {
            $sqlwhere .= " AND u.user_email LIKE :sq";
        } else {
            $sqlwhere .= " AND (u.user_name LIKE :sq OR u.user_email LIKE :sq)";
        }
        $params['sq'] = $sq_escaped;
    }

    if (!empty($filter_id)) {
        $sqlwhere .= " AND u.user_id = :fid";
        $params['fid'] = $filter_id;
    }

    if ($filter != 'all') {
        $sqlwhere .= " AND u.user_maingrp = :grp";
        $params['grp'] = $filter;
    }

    if (!empty($ucat) && !empty(Cot::$structure['usercategories'])) {
        $cats = cot_structure_children('usercategories', $ucat);
        $cats[] = $ucat;
        $catConditions = [];
        foreach ($cats as $cat) {
            $catConditions[] = "FIND_IN_SET('" . Cot::$db->prep($cat) . "', u.user_cats)";
        }
        if (!empty($catConditions)) {
            $sqlwhere .= " AND (" . implode(" OR ", $catConditions) . ")";
        }
    }

    // Подсчёт количества записей
    if ($showAllItems) {
        $total = Cot::$db->query(
            "SELECT COUNT(*) FROM $db_users AS u WHERE $sqlwhere", $params
        )->fetchColumn();
    } else {
        $total = Cot::$db->query(
            "SELECT COUNT(*) FROM " . Cot::$db->xtradbrowusers . " AS t
             LEFT JOIN $db_users AS u ON u.user_id = t.id
             WHERE $sqlwhere", $params
        )->fetchColumn();
    }

    $searchMsg = '';
    if (!empty($sq) || !empty($filter_id) || !empty($ucat)) {
        $totalFound = (int)$total;
        $queryDesc = [];
        if (!empty($sq)) $queryDesc[] = '«'.htmlspecialchars($sq).'»';
        if (!empty($filter_id)) $queryDesc[] = 'ID '.$filter_id;
        if (!empty($ucat)) $queryDesc[] = Cot::$structure['usercategories'][$ucat]['title'] ?? $ucat;
        if ($totalFound > 0) {
            $searchMsg = sprintf(Cot::$L['xtradbrowusers_search_result_msg'], cot_declension($totalFound, Cot::$L['xtradbrowusers_search_declen']), implode(', ', $queryDesc));
        } else {
            $searchMsg = sprintf(Cot::$L['xtradbrowusers_search_result_none'], implode(', ', $queryDesc));
        }
    }

    // Получение данных
    if ($showAllItems) {
        $items = Cot::$db->query(
            "SELECT u.user_id, u.user_name, u.user_email, t.*
             FROM $db_users AS u
             LEFT JOIN " . Cot::$db->xtradbrowusers . " AS t ON t.id = u.user_id
             WHERE $sqlwhere
             ORDER BY u.user_id DESC
             LIMIT $d, $perPage",
            $params
        )->fetchAll();
    } else {
        $items = Cot::$db->query(
            "SELECT t.*, u.user_name, u.user_email
             FROM " . Cot::$db->xtradbrowusers . " AS t
             LEFT JOIN $db_users AS u ON u.user_id = t.id
             WHERE $sqlwhere
             ORDER BY t.id DESC
             LIMIT $d, $perPage",
            $params
        )->fetchAll();
    }

    $groups = [];
    $grpRes = Cot::$db->query("SELECT grp_id, grp_title FROM $db_groups ORDER BY grp_id")->fetchAll();
    foreach ($grpRes as $grp) {
        $groups[$grp['grp_id']] = $grp['grp_title'];
    }

    $ucatSelect = '';
    if (cot_plugin_active('usercategories') && function_exists('cot_xtradbrowusers_usercategories_selectcat2')) {
        $ucatSelect = cot_xtradbrowusers_usercategories_selectcat2($ucat, 'ucat');
    }

    $t->assign([
        'SEARCH_ACTION_URL'       => cot_url('admin'),
        'SEARCH_SQ'               => cot_inputbox('text', 'sq', !empty($sq) ? htmlspecialchars($sq) : '', 'class="form-control" autofocus'),
        'SEARCH_FILTER_ID'        => cot_inputbox('number', 'filter_id', !empty($filter_id) ? $filter_id : '', 'class="form-control" placeholder="ID"'),
        'FILTER_GROUP_SELECT'     => cot_selectbox($filter, 'filter', array_merge(['all'], array_keys($groups)), array_merge([Cot::$L['All']], array_values($groups)), false),
        'SEARCH_CAT_SELECT2'      => $ucatSelect,
        'SEARCH_RESULT_MSG'       => $searchMsg,
        'SEARCH_IN_NAME_CHECKED'  => ($search_in == 'name') ? 'checked="checked"' : '',
        'SEARCH_IN_EMAIL_CHECKED' => ($search_in == 'email')? 'checked="checked"' : '',
        'SEARCH_IN_BOTH_CHECKED'  => ($search_in == 'both') ? 'checked="checked"' : '',
        'I18N_ACTIVE'             => $i18nActive,
        'SEARCH_SQ_VALUE'         => htmlspecialchars($sq ?? ''),
        'SEARCH_IN_VALUE'         => htmlspecialchars($search_in ?? ''),
        'SEARCH_FILTER_ID_VALUE'  => htmlspecialchars($filter_id ?? ''),
        'FILTER_VALUE'            => htmlspecialchars($filter),
        'SEARCH_UCAT_VALUE'       => htmlspecialchars($ucat),
    ]);

    $extrafields = xtradbrowusers_getExtrafields();
    if (!empty($extrafields)) {
        foreach ($extrafields as $exfld) {
            $t->assign('FIELD_HEADER_TITLE', htmlspecialchars(cot_extrafield_title($exfld, 'xtra_')));
            if ($i18nActive && in_array($exfld['field_type'], $i18nEditableTypes)) {
                foreach ($activeLangs as $lang) {
                    $t->assign('LANG_HEADER', strtoupper($lang));
                    $t->parse('MAIN.I18N_FIELDS_HEADER.LANG_HEADER_ROW');
                }
            }
            $t->parse('MAIN.I18N_FIELDS_HEADER');
        }
    }

    if (!empty($items)) {
        foreach ($items as $row) {
            $id = $row['user_id'] ?? $row['id'];
            $itemUrl = cot_url('users', ['m' => 'details', 'id' => $id]); 
            $t->assign([
                'MANAGE_ID'   => $id,
                'MANAGE_USER' => htmlspecialchars($row['user_name'] ?? ''),
                'MANAGE_URL'  => $itemUrl,
            ]);

            foreach ($extrafields as $exfld) {
                $fname = $exfld['field_name'];
                $isEditable = in_array($exfld['field_type'], $i18nEditableTypes);
                $isNew = (!isset($row['id']) || $row['id'] === null); // В таблице xtradbrowusers первичный ключ id

                if ($isNew) {
                    $value = $isEditable ? ($exfld['field_default'] ?? '') : '';
                } else {
                    $value = $row[$fname] ?? '';
                }

                if ($isEditable) {
                    $inputName = 'rxtra_' . $fname . '[' . $id . ']';
                    $fieldHtml = cot_build_extrafields($inputName, $exfld, $value);
                } else {
                    $fieldHtml = $formatValue($exfld, $value);
                }
                $t->assign('FIELD_HTML', $fieldHtml);

                if ($i18nActive && $isEditable) {
                    foreach ($activeLangs as $lang) {
                        $langValue = xtradbrowusers_i18n_load($id, $fname, $lang) ?? '';
                        $langInputName = 'rxtra_' . $fname . '_' . $lang . '[' . $id . ']';
						// Если основное поле — textarea, используем textarea, иначе input
						if ($exfld['field_type'] === 'textarea') {
							$langHtml = cot_textarea($langInputName, $langValue, 5, 40);
						} else {
							$langHtml = cot_inputbox('text', $langInputName, $langValue);
						}
                        $t->assign('LANG_FIELD', $langHtml);
                        $t->parse('MAIN.I18N_ROW.FIELD_CELL.LANG_ROW');
                    }
                }
                $t->parse('MAIN.I18N_ROW.FIELD_CELL');
            }
            $t->parse('MAIN.I18N_ROW');
        }
    } else {
        $t->parse('MAIN.I18N_EMPTY');
    }

    $pagenav = cot_pagenav('admin', $urlParams, $d, $total, $perPage, 'd');
    $t->assign(cot_generatePaginationTags($pagenav));
    $t->assign('I18N_FORM_URL', cot_url('admin', ['m'=>'other','p'=>'xtradbrowusers','tab'=>'i18n','a'=>'update','d'=>$durl]));
}
cot_display_messages($t);
$t->parse('MAIN');
$pluginBody = $t->text('MAIN');