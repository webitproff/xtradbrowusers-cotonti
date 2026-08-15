<!--
/**
 * Filename: xtradbrowusers.admin.tpl – Шаблон админ-панели плагина
 *
 * Purpose:   Главный шаблон интерфейса администрирования плагина xtradbrowusers.
 *            Содержит навигацию по трём вкладкам: «Статистика», «Редактирование»
 *            и «Редактирование + Переводы (i18n)».
 *
 *            Вкладка «Статистика»:
 *              - выводит карточки с общим количеством пользователей,
 *                числом записей в cot_xtradbrowusers и количеством заполненных записей;
 *              - показывает таблицу всех зарегистрированных экстраполей:
 *                имя, тип, описание, варианты, параметры, значение по умолчанию,
 *                обязательность и активность.
 *
 *            Вкладка «Редактирование»:
 *              - предоставляет форму поиска и фильтрации:
 *                  * текстовый поиск (по имени/email/обоим);
 *                  * фильтр по ID пользователя;
 *                  * фильтр по категории пользователей (Select2 с отступами);
 *                  * фильтр по группе;
 *              - содержит таблицу пользователей с колонками экстраполей;
 *              - для каждого пользователя выводится ссылка на публичный профиль;
 *              - поддерживает массовое редактирование и сохранение изменений.
 *
 *            Вкладка «Редактирование + Переводы (i18n)»:
 *              - отображается только при включённой мультиязычности;
 *              - для каждого редактируемого поля (input/textarea) показывает
 *                оригинальное поле и поля переводов для активных языков;
 *              - для textarea перевод также является многострочным;
 *              - остальные типы полей выводятся как читаемые значения
 *                (select, radio, checklistbox, country, datetime, checkbox);
 *              - включает фильтры, аналогичные вкладке «Редактирование».
 *
 *            В нижней части шаблона добавлены стили для горизонтальной прокрутки
 *            широких таблиц и скрипт инициализации Select2 с поддержкой
 *            плейсхолдера из data-placeholder и отступов вложенности через data-depth.
 *
 * Path:     plugins/xtradbrowusers/tpl/xtradbrowusers.admin.tpl
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
-->
<!-- BEGIN: MAIN -->
<div class="container-fluid py-4">
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {TAB_STATS_ACTIVE}" href="{URL_STATS}">{PHP.L.xtradbrowusers_tab_stats}</a>
		</li>
        <li class="nav-item">
            <a class="nav-link {TAB_EDIT_ACTIVE}" href="{URL_EDIT}">{PHP.L.xtradbrowusers_tab_edit}</a>
		</li>
        <li class="nav-item">
            <a class="nav-link {TAB_I18N_ACTIVE}" href="{URL_I18N}">{PHP.L.xtradbrowusers_tab_i18n}</a>
		</li>
	</ul>
	
    <!-- STATISTICS TAB -->
    <!-- IF {PHP.tab} == 'stats' -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_TOTAL_USERS}</h5>
                    <p class="card-text">{PHP.L.xtradbrowusers_stats_total_users}</p>
				</div>
			</div>
		</div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_TOTAL_XTRA_ROWS}</h5>
                    <p class="card-text">{PHP.L.xtradbrowusers_stats_xtra_rows}</p>
				</div>
			</div>
		</div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_FILLED_COUNT}</h5>
                    <p class="card-text">{PHP.L.xtradbrowusers_stats_filled}</p>
				</div>
			</div>
		</div>
	</div>
	
    <h4>{PHP.L.xtradbrowusers_extrafields_info}</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{PHP.L.xtradbrowusers_field_name}</th>
                    <th>{PHP.L.xtradbrowusers_field_type}</th>
                    <th>{PHP.L.xtradbrowusers_field_description}</th>
                    <th>{PHP.L.xtradbrowusers_field_variants}</th>
                    <th>{PHP.L.xtradbrowusers_field_params}</th>
                    <th>{PHP.L.xtradbrowusers_field_default}</th>
                    <th>{PHP.L.xtradbrowusers_field_required}</th>
                    <th>{PHP.L.xtradbrowusers_field_enabled}</th>
				</tr>
			</thead>
            <tbody>
                <!-- BEGIN: STATS_EXTRAFIELDS_ROW -->
                <tr>
                    <td><code class="fs-5">{FIELD_NAME}</code></td>
                    <td>{FIELD_TYPE}</td>
                    <td>{FIELD_DESCRIPTION}</td>
                    <td>{FIELD_VARIANTS}</td>
                    <td>{FIELD_PARAMS}</td>
                    <td>{FIELD_DEFAULT}</td>
                    <td>{FIELD_REQUIRED}</td>
                    <td>{FIELD_ENABLED}</td>
				</tr>
                <!-- END: STATS_EXTRAFIELDS_ROW -->
                <!-- BEGIN: STATS_NO_EXTRAFIELDS -->
                <tr><td colspan="8" class="text-center">{PHP.L.xtradbrowusers_no_extrafields}</td></tr>
                <!-- END: STATS_NO_EXTRAFIELDS -->
			</tbody>
		</table>
	</div>
    <!-- ENDIF -->
	
    <!-- EDIT TAB -->
    <!-- IF {PHP.tab} == 'edit' -->
    <div class="card filter-section p-3 mb-4" style="border: 5px var(--bs-dark-border-subtle) solid">
        <form method="get" action="{SEARCH_ACTION_URL}" class="mb-3">
            <input type="hidden" name="m" value="other">
            <input type="hidden" name="p" value="xtradbrowusers">
            <input type="hidden" name="tab" value="edit">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-lg-3">
                    <label class="form-label">{PHP.L.xtradbrowusers_search_sq}</label>
                    {SEARCH_SQ}
				</div>
                <div class="col-12 col-lg-2">
                    <label class="form-label">{PHP.L.xtradbrowusers_filter_id}</label>
                    {SEARCH_FILTER_ID}
				</div>
                <div class="col-12 col-lg-3">
                    <label class="form-label">{PHP.L.xtradbrowusers_search_cat}</label>
                    {SEARCH_CAT_SELECT2}
				</div>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_in" value="name" {SEARCH_IN_NAME_CHECKED}>
                        <label>{PHP.L.xtradbrowusers_search_in_name}</label>
					</div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_in" value="email" {SEARCH_IN_EMAIL_CHECKED}>
                        <label>{PHP.L.xtradbrowusers_search_in_email}</label>
					</div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_in" value="both" {SEARCH_IN_BOTH_CHECKED}>
                        <label>{PHP.L.xtradbrowusers_search_in_both}</label>
					</div>
				</div>
                <div class="col-12 col-lg-2">
                    <label class="form-label">{PHP.L.xtradbrowusers_filter_group}</label>
                    {FILTER_GROUP_SELECT}
				</div>
                <div class="col-12 col-lg-2">
                    <button type="submit" class="btn btn-outline-primary w-100"><i class="fa-solid fa-filter me-1"></i>{PHP.L.xtradbrowusers_search_btn}</button>
				</div>
                <div class="col-12 col-lg-2">
                    <a class="btn btn-outline-danger w-100" href="{URL_EDIT}"><i class="fa-solid fa-broom me-1"></i>{PHP.L.xtradbrowusers_search_reset}</a>
				</div>
			</div>
		</form>
        <!-- IF {SEARCH_RESULT_MSG} -->
        <div class="alert alert-info">{SEARCH_RESULT_MSG}</div>
        <!-- ENDIF -->
	</div>
	
    <form action="{EDIT_FORM_URL}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="sq" value="{SEARCH_SQ_VALUE}">
        <input type="hidden" name="search_in" value="{SEARCH_IN_VALUE}">
        <input type="hidden" name="filter_id" value="{SEARCH_FILTER_ID_VALUE}">
        <input type="hidden" name="filter" value="{FILTER_VALUE}">
        <input type="hidden" name="ucat" value="{SEARCH_UCAT_VALUE}">
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{PHP.L.xtradbrowusers_username}</th>
                        <!-- BEGIN: EDIT_FIELDS_HEADER -->
                        <th>{FIELD_HEADER_TITLE}</th>
                        <!-- END: EDIT_FIELDS_HEADER -->
					</tr>
				</thead>
                <tbody>
                    <!-- BEGIN: EDIT_ROW -->
                    <tr>
                        <td><a href="{MANAGE_URL}" target="_blank">{MANAGE_ID}</a><input type="hidden" name="ids[]" value="{MANAGE_ID}"></td>
                        <td>{MANAGE_USER}</td>
                        <!-- BEGIN: FIELD_CELL -->
                        <td>{FIELD_HTML}</td>
                        <!-- END: FIELD_CELL -->
					</tr>
                    <!-- END: EDIT_ROW -->
                    <!-- BEGIN: EDIT_EMPTY -->
                    <tr><td colspan="10" class="text-center">{PHP.L.xtradbrowusers_no_records}</td></tr>
                    <!-- END: EDIT_EMPTY -->
				</tbody>
			</table>
		</div>
        <!-- IF {PAGINATION} -->
        <nav class="my-3">
            <div class="text-center mb-2">{PHP.L.Total}: {TOTAL_ENTRIES}, {PHP.L.Onpage}: {ENTRIES_ON_CURRENT_PAGE}</div>
            <ul class="pagination justify-content-center">{PREVIOUS_PAGE} {PAGINATION} {NEXT_PAGE}</ul>
		</nav>
        <!-- ENDIF -->
		<div class="my-3">
			<button type="submit" class="btn btn-lg btn-success">{PHP.L.Update}</button>
		</div>
	</form>
    <!-- ENDIF -->
	
    <!-- I18N EDIT TAB -->
    <!-- IF {PHP.tab} == 'i18n' -->
    <!-- IF {I18N_ACTIVE} -->
    <div class="alert alert-info">{PHP.L.xtradbrowusers_i18n_active}</div>
    <!-- ELSE -->
    <div class="alert alert-warning">{PHP.L.xtradbrowusers_i18n_disabled}</div>
    <!-- ENDIF -->
	
    <div class="card filter-section p-3 mb-4" style="border: 5px var(--bs-dark-border-subtle) solid">
        <form method="get" action="{SEARCH_ACTION_URL}" class="mb-3">
            <input type="hidden" name="m" value="other">
            <input type="hidden" name="p" value="xtradbrowusers">
            <input type="hidden" name="tab" value="i18n">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-lg-3">
                    <label class="form-label">{PHP.L.xtradbrowusers_search_sq}</label>
                    {SEARCH_SQ}
				</div>
                <div class="col-12 col-lg-2">
                    <label class="form-label">{PHP.L.xtradbrowusers_filter_id}</label>
                    {SEARCH_FILTER_ID}
				</div>
                <div class="col-12 col-lg-3">
                    <label class="form-label">{PHP.L.xtradbrowusers_search_cat}</label>
                    {SEARCH_CAT_SELECT2}
				</div>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_in" value="name" {SEARCH_IN_NAME_CHECKED}>
                        <label>{PHP.L.xtradbrowusers_search_in_name}</label>
					</div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_in" value="email" {SEARCH_IN_EMAIL_CHECKED}>
                        <label>{PHP.L.xtradbrowusers_search_in_email}</label>
					</div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_in" value="both" {SEARCH_IN_BOTH_CHECKED}>
                        <label>{PHP.L.xtradbrowusers_search_in_both}</label>
					</div>
				</div>
                <div class="col-12 col-lg-2">
                    <label class="form-label">{PHP.L.xtradbrowusers_filter_group}</label>
                    {FILTER_GROUP_SELECT}
				</div>
                <div class="col-12 col-lg-2">
                    <button type="submit" class="btn btn-outline-primary w-100"><i class="fa-solid fa-filter me-1"></i>{PHP.L.xtradbrowusers_search_btn}</button>
				</div>
                <div class="col-12 col-lg-2">
                    <a class="btn btn-outline-danger w-100" href="{URL_I18N}"><i class="fa-solid fa-broom me-1"></i>{PHP.L.xtradbrowusers_search_reset}</a>
				</div>
			</div>
		</form>
        <!-- IF {SEARCH_RESULT_MSG} -->
        <div class="alert alert-info">{SEARCH_RESULT_MSG}</div>
        <!-- ENDIF -->
	</div>
	
    <form method="post" action="{I18N_FORM_URL}">
        <input type="hidden" name="sq" value="{SEARCH_SQ_VALUE}">
        <input type="hidden" name="search_in" value="{SEARCH_IN_VALUE}">
        <input type="hidden" name="filter_id" value="{SEARCH_FILTER_ID_VALUE}">
        <input type="hidden" name="filter" value="{FILTER_VALUE}">
        <input type="hidden" name="ucat" value="{SEARCH_UCAT_VALUE}">
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{PHP.L.xtradbrowusers_username}</th>
                        <!-- BEGIN: I18N_FIELDS_HEADER -->
                        <th>
                            {FIELD_HEADER_TITLE}
                            <!-- BEGIN: LANG_HEADER_ROW -->
                            <small class="d-block text-muted">{LANG_HEADER}</small>
                            <!-- END: LANG_HEADER_ROW -->
						</th>
                        <!-- END: I18N_FIELDS_HEADER -->
					</tr>
				</thead>
                <tbody>
                    <!-- BEGIN: I18N_ROW -->
                    <tr>
                        <td><a href="{MANAGE_URL}" target="_blank">{MANAGE_ID}</a><input type="hidden" name="ids[]" value="{MANAGE_ID}"></td>
                        <td>{MANAGE_USER}</td>
                        <!-- BEGIN: FIELD_CELL -->
                        <td>
                            {FIELD_HTML}
                            <!-- BEGIN: LANG_ROW -->
                            <div class="mt-1">{LANG_FIELD}</div>
                            <!-- END: LANG_ROW -->
						</td>
                        <!-- END: FIELD_CELL -->
					</tr>
                    <!-- END: I18N_ROW -->
                    <!-- BEGIN: I18N_EMPTY -->
                    <tr><td colspan="10" class="text-center">{PHP.L.xtradbrowusers_no_records}</td></tr>
                    <!-- END: I18N_EMPTY -->
				</tbody>
			</table>
		</div>
        <!-- IF {PAGINATION} -->
        <nav class="my-3">
            <div class="text-center mb-2">{PHP.L.Total}: {TOTAL_ENTRIES}, {PHP.L.Onpage}: {ENTRIES_ON_CURRENT_PAGE}</div>
            <ul class="pagination justify-content-center">{PREVIOUS_PAGE} {PAGINATION} {NEXT_PAGE}</ul>
		</nav>
        <!-- ENDIF -->
		<div class="my-3">
			<button type="submit" class="btn btn-success">{PHP.L.Update}</button>
		</div>
	</form>
    <!-- ENDIF -->
</div>
<style>
    .table-responsive {
	overflow-x: auto !important;
	display: block !important;
	width: 100% !important;
    }
    .table {
	width: max-content !important;
	min-width: 100% !important;
	table-layout: auto !important;
	white-space: nowrap !important;
    }
    .table th,
    .table td {
	white-space: nowrap !important;
    }
</style>
<script>
  $(document).ready(function() {
    $('select.select2').select2({
        placeholder: function() {
            return $(this).data('placeholder') || 'Все категории';
        },
        width: '100%',
        templateResult: function(state) {
            if (!state.id) return state.text;
            var depth = parseInt($(state.element).data('depth') || '0', 10);
            var indent = '\u00A0'.repeat(depth * 3);
            return depth === 0
                ? $('<span><strong>' + state.text + '</strong></span>')
                : $('<span>' + indent + state.text + '</span>');
        },
        templateSelection: function(state) {
            return state.text;
        }
    });
  });
</script>
<!-- END: MAIN -->
