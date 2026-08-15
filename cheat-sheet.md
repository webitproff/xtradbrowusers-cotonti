# Плагин 'xtradbrowusers' - Руководство по тегам в шаблонах 
## Интеграция и прописывание тегов для вывода экстраполей в шаблонах.
---
> Этот документ - это шпаргалка, - скопировал, вставил подправил и забыл! 
> Всё что не понятно, - спрашивать на **[форуме](https://abuyfile.com/ru/forums/cotonti/custom/plugs/xtradbrowusers)**
---
Плагин 'xtradbrowusers' - Руководство по тегам в шаблонах. Интеграция и прописание тегов для вывода экстраполей в шаблонах. Текст полной версии шпаргалки. 

**Начало шпаргалки**, а также все скриншоты для наглядности, - всё это лежит в статье [**“Плагин xtradbrowusers — Руководство по тегам в шаблонах”**](https://abuyfile.com/ru/usersblog/cheat-sheet-xtradbrowusers) 

## Пользователи (модуль 'users')

Список шаблонов модуля в папке вашей темы, например "2waydeal", "index36", "nemesis" — важно то, что они должны лежать именно в папке темы, соблюдая такой путь:

```
/themes/2waydeal/modules/users/users.edit.tpl
/themes/2waydeal/modules/users/users.profile.tpl
/themes/2waydeal/modules/users/users.details.contractor.tpl
/themes/2waydeal/modules/users/users.details.tpl
/themes/2waydeal/modules/users/users.register.tpl
/themes/2waydeal/modules/users/users.tpl
```

## **users.edit.tpl**

шаблон редактирования данных пользователя администратором.

Открываем шаблон, и обязательно внутри формы

```
<form action="{USERS_EDIT_SEND}" method="post" name="useredit" enctype="multipart/form-data" class="needs-validation" novalidate>
	<input type="hidden" name="id" value="{USERS_EDIT_ID}" />
	....
	....
	<button type="submit" class="btn btn-outline-primary">
		<i class="fa-solid fa-floppy-disk me-1"></i> {PHP.L.Update}
	</button>
</form>
```

в любом для вас удобном месте вставляем блок с выводом наших полей:

```
<!-- IF {PHP|cot_plugin_active('xtradbrowusers')} -->
<div class="row my-5">
	<p>{PHP.L.xtradbrowusers_edit_tpl_title}</p>
	<div class="list-group list-group-striped list-group-flush border-bottom">
		<!-- IF {USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}:</label>
			{USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT}
		</div>
		<!-- IF {USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT_EN} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT_EN_TITLE}:</label>
			{USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT_EN}
		</div>
		<!-- ENDIF -->
		<!-- ENDIF -->
		<!-- IF {USERS_EDIT_XTRA_X010_PHONE_VENDOR_ORDERS} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X010_PHONE_VENDOR_ORDERS_TITLE}:</label>
			{USERS_EDIT_XTRA_X010_PHONE_VENDOR_ORDERS}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_EDIT_XTRA_X011_TG_VENDOR_ORDERS} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X011_TG_VENDOR_ORDERS_TITLE}:</label>
			{USERS_EDIT_XTRA_X011_TG_VENDOR_ORDERS}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_EDIT_XTRA_X012_TG_CHANEL_VENDOR} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X012_TG_CHANEL_VENDOR_TITLE}:</label>
			{USERS_EDIT_XTRA_X012_TG_CHANEL_VENDOR}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_EDIT_XTRA_X200_RESUME_FILE} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X200_RESUME_FILE_TITLE}:</label>
			{USERS_EDIT_XTRA_X200_RESUME_FILE}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_EDIT_XTRA_X200_LAST_PROMOTION} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X200_LAST_PROMOTION_TITLE}:</label>
			{USERS_EDIT_XTRA_X200_LAST_PROMOTION}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_EDIT_XTRA_X200_DEPARTMENT} -->
		<div class="list-group-item py-3">
			<label>{USERS_EDIT_XTRA_X200_DEPARTMENT_TITLE}:</label>
			{USERS_EDIT_XTRA_X200_DEPARTMENT}
		</div>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```

**Важно:** этот код выведет лишь некоторые поля из всего «демонстрационного набора» экстраполей при установке плагина.

Моя задача — создать для вас хоть какую-то шпаргалку с иллюстрацией механизма включения (прописания) полей в шаблоны.

Здесь можно запутаться, но на самом деле всё предельно просто.

> **Собрать правильный тег для вашего шаблона, чтобы в нём получить своё поле, — это как собрать игрушечный паровозик из нескольких вагончиков:**

- `USERS_EDIT_XTRA_` — префикс из нашего плагина
- `X020_ABOUT_VENDOR_TEXT` — имя нашего поля

`USERS_EDIT_XTRA_` + `X020_ABOUT_VENDOR_TEXT` = `USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT`

Видите, как просто.

Обернув в фигурные скобки, мы нашему шаблонизатору `XTemplate` говорим: 

> **«дай мне в шаблоне здесь** `{КАРТОШКА_ЖАРЕННАЯ}`**,** `{КЕТЧУП_ОСТРЫЙ}`**»,**

и если имя корректное — он принесёт сюда в шаблон то, что туда положили повара на кухне. Поваром здесь может быть и разработчик, и вы сами как пользователь или администратор.

В нашем случае у шаблонизатора мы попросили `{USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT}` в шаблоне редактирования, и он нам сюда принесёт поле для заполнения, редактирования и сохранения данных текстового типа.

Теперь как собрать заголовок поля, то есть получить его «Описание поля (\_TITLE)»?

Всё также предельно просто:

- `USERS_EDIT_XTRA_` — префикс из нашего плагина
- `X020_ABOUT_VENDOR_TEXT` — имя нашего поля
- `_TITLE` — суффикс из нашего плагина

`USERS_EDIT_XTRA_` + `X020_ABOUT_VENDOR_TEXT` + `_TITLE` = `USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE`

Подробнее [**в файле хукинга**](https://github.com/webitproff/xtradbrowusers-cotonti/blob/main/xtradbrowusers/xtradbrowusers.users.edit.tags.php).

Снова обернули наш «паровозик» в фигурные скобки и кричим нашему шаблонизатору `XTemplate` в шаблоне: 

> **«Эй, официант, хочу** `{USERS_EDIT_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}`**!».**

И разумеется, если такое есть — он вернёт нам описание поля. В демке это лейбл поля «Обо мне кратко».

Однажды вникнув, потратив с практикой и чтением шпаргалки минут 15, — вас уже не будут смущать ни «вагончики» детского «паровозика», ни незнакомец-официант по имени «шаблонизатор XTemplate».

> **Запомнили одно: собрали паровозик из нужных вагончиков — всё, теперь зовём официанта и корректно называем то, что хотите от него!**

* * *

## Для разработчиков

В Cotonti шаблонизатор работает так:

1. **В PHP-коде** вы присваиваете значение переменной:

```
$t->assign('FIELD_NAME', htmlspecialchars(mb_strtoupper($exfld['field_name'])));
```
2. **В шаблоне** вы используете фигурные скобки:

```
{FIELD_NAME}
```
3. **Класс** `Cotpl_data` при загрузке шаблонного блока разбирает его содержимое и находит все подстроки вида `{...}`.

Именно этот фрагмент кода выделяет имя переменной:

```
if ($firstSymbol === '{' && $lastSymbol === '}') {
$this->chunks[] = new Cotpl_var(mb_substr($chunk, 1, mb_strlen($chunk) - 2));
}
```

Он убирает `{` и `}`, берёт внутреннее имя (`FIELD_NAME`) и создаёт объект `Cotpl_var`, который позже при выводе заменится на значение из массива, переданного через `assign()`.
4. **Когда шаблон рендерится**, `XTemplate` проходит по чанкам блока, находит `Cotpl_var` для `FIELD_NAME` и подставляет актуальное значение (в вашем случае — имя поля в верхнем регистре).

Таким образом, фигурные скобки — это обязательный синтаксис для вывода переменных, а `Cotpl_data` отвечает за то, чтобы эти переменные были распознаны и корректно заменены при парсинге шаблона.

Подробнее [**в файле cotemplate.php**](https://github.com/Cotonti/Cotonti/blob/f43f1fc38ba4e02027786dad9dac1435c7c52b30/system/cotemplate.php#L959).

## users.profile.tpl

 шаблон редактирования профиля пользователя и его данных, самим пользователем (не администратором, как это было выше).

Открываем шаблон, и обязательно внутри формы

```
<form action="{USERS_PROFILE_FORM_SEND}" method="post" enctype="multipart/form-data" name="profile">
	<input type="hidden" name="userid" value="{USERS_PROFILE_ID}" />
	....
	....
	<div class="text-end mt-4">
		<button type="submit" class="btn btn-primary">{PHP.L.Update}</button>
	</div>
</form>
```

в любом для вас удобном месте вставляем блок с выводом наших полей:

```
<!-- IF {PHP|cot_plugin_active('xtradbrowusers')} -->
<div class="row my-5">
	<p>{PHP.L.xtradbrowusers_profile_tpl_title}</p>
	<div class="list-group list-group-striped list-group-flush border-bottom">
		<!-- IF {USERS_PROFILE_XTRA_X020_ABOUT_VENDOR_TEXT} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}:</label>
			{USERS_PROFILE_XTRA_X020_ABOUT_VENDOR_TEXT}
		</div>
		<!-- IF {USERS_PROFILE_XTRA_X020_ABOUT_VENDOR_TEXT_EN} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X020_ABOUT_VENDOR_TEXT_EN_TITLE}:</label>
			{USERS_PROFILE_XTRA_X020_ABOUT_VENDOR_TEXT_EN}
		</div>
		<!-- ENDIF -->
		<!-- ENDIF -->
		<!-- IF {USERS_PROFILE_XTRA_X010_PHONE_VENDOR_ORDERS} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X010_PHONE_VENDOR_ORDERS_TITLE}:</label>
			{USERS_PROFILE_XTRA_X010_PHONE_VENDOR_ORDERS}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_PROFILE_XTRA_X011_TG_VENDOR_ORDERS} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X011_TG_VENDOR_ORDERS_TITLE}:</label>
			{USERS_PROFILE_XTRA_X011_TG_VENDOR_ORDERS}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_PROFILE_XTRA_X012_TG_CHANEL_VENDOR} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X012_TG_CHANEL_VENDOR_TITLE}:</label>
			{USERS_PROFILE_XTRA_X012_TG_CHANEL_VENDOR}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_PROFILE_XTRA_X200_RESUME_FILE} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X200_RESUME_FILE_TITLE}:</label>
			{USERS_PROFILE_XTRA_X200_RESUME_FILE}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_PROFILE_XTRA_X200_LAST_PROMOTION} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X200_LAST_PROMOTION_TITLE}:</label>
			{USERS_PROFILE_XTRA_X200_LAST_PROMOTION}
		</div>
		<!-- ENDIF -->
		<!-- IF {USERS_PROFILE_XTRA_X200_DEPARTMENT} -->
		<div class="list-group-item py-3">
			<label>{USERS_PROFILE_XTRA_X200_DEPARTMENT_TITLE}:</label>
			{USERS_PROFILE_XTRA_X200_DEPARTMENT}
		</div>
		<!-- ENDIF -->
	</div>
</div>
<!-- ENDIF -->
```

Отличия между users.edit.tpl и users.profile.tpl, для нас здесь в том, что у "паровозика" сменился локомотив, был "`USERS_EDIT_XTRA_`", а теперь "тянет" новый тягач, - "`USERS_PROFILE_XTRA_`".  
Во всем остальном, - "вагончики" остались прежними, - везем то же самое, просто сменили "тепловоз".

Подробнее [**в соответствующем файле хукинга**](https://github.com/webitproff/xtradbrowusers-cotonti/blob/main/xtradbrowusers/xtradbrowusers.users.profile.tags.php).

## users.details.tpl

шаблон публичного профиля пользователя. Собственно сама страница пользователя, которая доступна для просмотра даже гостям, по собственной ссылке.

Открываем шаблон, и обязательно внутри формы ... Нет тут форм, и быть не должно, если они не предусмотренны специально для этого разработанными расширениями.  
Но уже, в привычной манере у нашего поезда меняем тепловоз.

в любом для вас удобном месте вставляем блок с выводом наших полей:

```
<!-- IF {PHP|cot_plugin_active('xtradbrowusers')} -->
<!-- О себе -->
<!-- IF {USERS_DETAILS_XTRA_X020_ABOUT_VENDOR_TEXT} -->
<div class="d-flex mb-3">
	<div class="contact-icon about me-3">
		<i class="fa-solid fa-circle-info fa-xl"></i>
	</div>
	<div>
		<div class="contact-label">{USERS_DETAILS_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}</div>
		<div class="contact-value">{USERS_DETAILS_XTRA_X020_ABOUT_VENDOR_TEXT}</div>
	</div>
</div>
<!-- ENDIF -->
<!-- Телефон -->
<!-- IF {USERS_DETAILS_XTRA_X010_PHONE_VENDOR_ORDERS} -->
<div class="d-flex align-items-center mb-3">
	<div class="contact-icon phone me-3">
		<i class="fa-solid fa-phone fa-xl"></i>
	</div>
	<div>
		<div class="contact-label">{USERS_DETAILS_XTRA_X010_PHONE_VENDOR_ORDERS_TITLE}</div>
		<div class="d-flex align-items-center">
			<span id="phone-{USERS_DETAILS_ID}" class="contact-value fs-3" style="letter-spacing:2px"></span>
			<button type="button" class="btn btn-outline-primary btn-sm ms-2"
			id="show-phone-btn-{USERS_DETAILS_ID}"
			data-phone="{USERS_DETAILS_XTRA_X010_PHONE_VENDOR_ORDERS}"
			onclick="document.getElementById('phone-{USERS_DETAILS_ID}').textContent = this.dataset.phone; this.style.display='none';">
				<i class="fa-solid fa-eye me-1"></i> {PHP.L.xtradbrowusers_details_tpl_show_hidden_content}
			</button>
		</div>
	</div>
</div>
<!-- ENDIF -->
<!-- Telegram -->
<!-- IF {USERS_DETAILS_XTRA_X011_TG_VENDOR_ORDERS} -->
<div class="d-flex align-items-center mb-3">
	<div class="contact-icon telegram me-3">
		<i class="fa-brands fa-telegram fa-xl"></i>
	</div>
	<div>
		<div class="contact-label">{USERS_DETAILS_XTRA_X011_TG_VENDOR_ORDERS_TITLE}</div>
		<a href="https://t.me/{USERS_DETAILS_XTRA_X011_TG_VENDOR_ORDERS}" target="_blank" rel="noopener noreferrer" class="telegram-link">
			@{USERS_DETAILS_XTRA_X011_TG_VENDOR_ORDERS}
		</a>
	</div>
</div>
<!-- ENDIF -->
<!-- IF {USERS_DETAILS_XTRA_X012_TG_CHANEL_VENDOR} -->
<div class="d-flex align-items-center mb-3">
	<div class="contact-icon telegram me-3">
		<i class="fa-brands fa-telegram fa-xl"></i>
	</div>
	<div>
		<div class="contact-label">{USERS_DETAILS_XTRA_X012_TG_CHANEL_VENDOR_TITLE}</div>
		<a href="https://t.me/{USERS_DETAILS_XTRA_X012_TG_CHANEL_VENDOR}" target="_blank" rel="noopener noreferrer" class="telegram-link">
			@{USERS_DETAILS_XTRA_X012_TG_CHANEL_VENDOR}
		</a>
	</div>
</div>
<!-- ENDIF -->
<!-- IF {USERS_DETAILS_XTRA_X200_RESUME_FILE} -->
<div class="d-flex align-items-center mb-3">
	<div class="me-3">
		<label>{USERS_DETAILS_XTRA_X200_RESUME_FILE_TITLE}:</label>
	</div>
	<div>
		<a href="{PHP.cfg.mainurl}/datas/exflds/xtradbrowusers/{USERS_DETAILS_XTRA_X200_RESUME_FILE}"
		class="btn btn-primary btn-sm"
		target="_blank"
		rel="noopener noreferrer">
			<i class="fa-solid fa-download me-1"></i> {PHP.L.Download}
		</a>
	</div>
</div>
<!-- ENDIF -->
<!-- Дата последнего повышения -->
<!-- IF {USERS_DETAILS_XTRA_X200_LAST_PROMOTION} -->
<div class="d-flex align-items-center mb-3">
	<div class="contact-icon calendar me-3">
		<i class="fa-solid fa-calendar-alt fa-xl"></i>
	</div>
	<div>
		<div class="contact-label">{USERS_DETAILS_XTRA_X200_LAST_PROMOTION_TITLE}</div>
		<div class="contact-value">{USERS_DETAILS_XTRA_X200_LAST_PROMOTION}</div>
	</div>
</div>
<!-- ENDIF -->
<!-- Отдел -->
<!-- IF {USERS_DETAILS_XTRA_X200_DEPARTMENT} -->
<div class="d-flex align-items-center mb-3">
	<div class="contact-icon building me-3">
		<i class="fa-solid fa-building fa-xl"></i>
	</div>
	<div>
		<div class="contact-label">{USERS_DETAILS_XTRA_X200_DEPARTMENT_TITLE}</div>
		<div class="contact-value">{USERS_DETAILS_XTRA_X200_DEPARTMENT}</div>
	</div>
</div>
<!-- ENDIF -->
<!-- ENDIF -->
```

по желанию в стили темы, в самый конец добавить:

```

/* для экстраполей модуля пользователей */
.contact-icon {
width: 2.5rem;
height: 2.5rem;
display: flex;
align-items: center;
justify-content: center;
border-radius: 0.5rem;
color: #fff;
flex-shrink: 0;
}
.contact-icon.about { background: #6f42c1; }
.contact-icon.phone { background: #198754; }
.contact-icon.telegram { background: #0088cc; }
.contact-icon.calendar { color: #17a2b8; }
.contact-icon.building { color: #6f42c1; }
.contact-label {
font-size: 0.8125rem;
color: var(--bs-body-color);
opacity: 0.7;
letter-spacing: 0.5px;
text-transform: uppercase;
margin-bottom: 0.25rem;
}
.contact-value {
font-size: 0.9375rem;
font-weight: 500;
}
.telegram-link {
text-decoration: none;
font-weight: 500;
}
/* для экстраполей модуля пользователей */
```

Всё также просто, - "вагончики" остались прежними, - везем то же самое, просто сменили "тепловоз".

Подробнее [**в соответствующем файле хукинга.**](https://github.com/webitproff/xtradbrowusers-cotonti/blob/main/xtradbrowusers/xtradbrowusers.users.details.tags.php)
