Плагин 'xtradbrowusers' - Руководство по тегам в шаблонах. Интеграция и прописание тегов для вывода экстраполей в шаблонах. Текст полной версии шпаргалки. 
---
> Этот документ - это шпаргалка, - скопировал, вставил подправил и забыл! 
> Всё что не понятно, - спрашивать на **[форуме](https://abuyfile.com/ru/forums/cotonti/custom/plugs/xtradbrowusers)**
---
> **Начало шпаргалки**, а также все скриншоты для наглядности, - всё это лежит в статье [**“Плагин xtradbrowusers — Руководство по тегам в шаблонах”**](https://abuyfile.com/ru/usersblog/cheat-sheet-xtradbrowusers) 
---

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

---

## users.register.tpl

шаблон регистрации пользователя.

Открываем шаблон, и обязательно внутри формы

```html
<form id="user-register" name="register" action="{USERS_REGISTER_SEND}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <div class="card shadow-sm">
        <div class="card-header">
           <h5 class="mb-0">{USERS_REGISTER_TITLE}</h5>
        </div>
        <div class="card-body">
           {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
           
           <!-- Кнопки соцсетей, если плагин активен -->
           <!-- IF {PHP|cot_plugin_active('hybridauth')} -->
               {PHP|hybridauth_login}
               <hr class="my-4">
           <!-- ENDIF -->
           ...
           ...
        </div>
        <button type="submit" class="btn btn-outline-primary">
           <i class="fa-solid fa-user-plus me-1"></i> {PHP.L.Submit}
        </button>
    </div>
</form>
```

вставить код

```html
<!-- IF {PHP|cot_plugin_active('xtradbrowusers')} -->
<div class="row my-5">
    <div class="list-group list-group-striped list-group-flush border-bottom">
         
        <!-- IF {USERS_REGISTER_XTRA_X020_ABOUT_VENDOR_TEXT} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}:</label>
            {USERS_REGISTER_XTRA_X020_ABOUT_VENDOR_TEXT}
        </div>
        <!-- IF {USERS_REGISTER_XTRA_X020_ABOUT_VENDOR_TEXT_EN} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X020_ABOUT_VENDOR_TEXT_EN_TITLE}:</label>
            {USERS_REGISTER_XTRA_X020_ABOUT_VENDOR_TEXT_EN}
        </div>
        <!-- ENDIF -->
        <!-- ENDIF -->
         
        <!-- IF {USERS_REGISTER_XTRA_X010_PHONE_VENDOR_ORDERS} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X010_PHONE_VENDOR_ORDERS_TITLE}:</label>
            {USERS_REGISTER_XTRA_X010_PHONE_VENDOR_ORDERS}
        </div>
        <!-- ENDIF -->
         
        <!-- IF {USERS_REGISTER_XTRA_X011_TG_VENDOR_ORDERS} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X011_TG_VENDOR_ORDERS_TITLE}:</label>
            {USERS_REGISTER_XTRA_X011_TG_VENDOR_ORDERS}
        </div>
        <!-- ENDIF -->
         
        <!-- IF {USERS_REGISTER_XTRA_X012_TG_CHANEL_VENDOR} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X012_TG_CHANEL_VENDOR_TITLE}:</label>
            {USERS_REGISTER_XTRA_X012_TG_CHANEL_VENDOR}
        </div>
        <!-- ENDIF -->
         
        <!-- IF {USERS_REGISTER_XTRA_X200_RESUME_FILE} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X200_RESUME_FILE_TITLE}:</label>
            {USERS_REGISTER_XTRA_X200_RESUME_FILE}
        </div>
        <!-- ENDIF -->
         
        <!-- IF {USERS_REGISTER_XTRA_X200_LAST_PROMOTION} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X200_LAST_PROMOTION_TITLE}:</label>
            {USERS_REGISTER_XTRA_X200_LAST_PROMOTION}
        </div>
        <!-- ENDIF -->
         
        <!-- IF {USERS_REGISTER_XTRA_X200_DEPARTMENT} -->
        <div class="list-group-item py-3">
            <label>{USERS_REGISTER_XTRA_X200_DEPARTMENT_TITLE}:</label>
            {USERS_REGISTER_XTRA_X200_DEPARTMENT}
        </div>
        <!-- ENDIF -->
         
    </div>
</div>
<!-- ENDIF -->
```

Напоминаю, это код демонстрационных экстраполей плагина для модуля пользователей, которые (поля) буду сразу после установки плагина.  
Поля именуете под себя, затем редактируете то, что хотите от вашего "официанта", но перед этим составьте ему правильно "состав вашего поезда с локомотивом и вагонами".

**и как же их составлять?**

**Всё также предельно просто:**

```cpp
USERS_REGISTER_XTRA_        — префикс; (локомотив/тягач вагонов)
X200_RESUME_FILE            — имя поля; (первый вагон)
_TITLE                      — суффикс из нашего плагина. (второй вагон и он же замыкающий)
```

```cpp
USERS_REGISTER_XTRA_ + X200_RESUME_FILE + _TITLE = {USERS_REGISTER_XTRA_X200_RESUME_FILE_TITLE}
```

[**Подробнее — в файле хукинга.**](https://github.com/webitproff/xtradbrowusers-cotonti/blob/main/xtradbrowusers/xtradbrowusers.users.register.tags.php#L57)

Запомните: собрали "паровозик" из нужных вагонов — всё, теперь зовём официанта и корректно называем то, что хотите от него!  
Представьте, что каждая строка вида `{USERS_REGISTER_XTRA_X200_RESUME_FILE}` или `{USERS_REGISTER_XTRA_X200_RESUME_FILE_TITLE}` это просто два разных, но похожих поезда и идут они в одном направлении.  
А теперь представьте, что в вашем регионе (в шаблоне) появился груз другой номенклатуры, собираем основной состав:

`USERS_REGISTER_XTRA_` + `X200_DEPARTMENT` = `{USERS_REGISTER_XTRA_X200_DEPARTMENT}`

и дополнительный "железнодорожный" состав

`USERS_REGISTER_XTRA_` + `X200_DEPARTMENT` + `_TITLE` = `{USERS_REGISTER_XTRA_X200_DEPARTMENT_TITLE}`

---

## users.tpl или users.contractor.tpl или users.freelancer.tpl

Шаблон списка пользователей, то есть страница сайта, где мы можем фильтровать и искать пользователей по доступным параметрам.  
Но в данном конкретном случае нас не интересуют формы вообще!  
В отличии, от шаблона регистрации, настройки и редактирования пользователя, мы здесь данные не отправляем в базу, а берем из базы и показываем визитеру.

Такие шаблоны, могут иметь очень разный вид, но в каждом из них будет логический блок "официанта":

```html
<!-- BEGIN: USERS_ROW --> и <!-- END: USERS_ROW -->
```

это "начало" и "конец" соответственно, то есть пределы, внутри которых мы формируем "лицо" одного элемента, для всех элементов этого списка.  
Если кому будет проще понять, - это "копирка", - вырезали буквы в картонке, сделали трафарет, и пошли под копирку вандалить по стенам домов города, с ведром краски в руках, например, "Покайся!". Ну и так на каждом доме, пока не выйдет кто, да не вправит то, что "сместилось" с моральных координат.

Вобщем находим пределы трафарета

```html
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <!-- BEGIN: USERS_ROW -->
    <div class="col">
        <div class="card h-100 shadow-sm border-0 user-card {USERS_ROW_ODDEVEN}">
            <div class="card-body d-flex flex-column">
            .....
            ......
            </div>
        </div>
    </div>
    <!-- END: USERS_ROW -->
</div>
```

вставить код, в удобном месте, например сразу после вывода аватара

```html
<!-- IF {PHP|cot_plugin_active('xtradbrowusers')} -->
<!-- О себе -->
<!-- IF {USERS_ROW_XTRA_X020_ABOUT_VENDOR_TEXT} -->
<div class="d-flex mb-3">
    <div class="contact-icon about me-3">
        <i class="fa-solid fa-circle-info fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{USERS_ROW_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}</div>
        <div class="contact-value">{USERS_ROW_XTRA_X020_ABOUT_VENDOR_TEXT}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- Телефон (скрыт, показ по кнопке) -->
<!-- IF {USERS_ROW_XTRA_X010_PHONE_VENDOR_ORDERS_VALUE} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon phone me-3">
        <i class="fa-solid fa-phone fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{USERS_ROW_XTRA_X010_PHONE_VENDOR_ORDERS_TITLE}</div>
        <div class="d-flex align-items-center">
            <span id="phone-{USERS_ROW_ID}" class="contact-value fs-3" style="letter-spacing:2px"></span>
            <button type="button" class="btn btn-outline-primary btn-sm ms-2"
                id="show-phone-btn-{USERS_ROW_ID}"
                data-phone="{USERS_ROW_XTRA_X010_PHONE_VENDOR_ORDERS_VALUE}"
                onclick="document.getElementById('phone-{USERS_ROW_ID}').textContent = this.dataset.phone; this.style.display='none';">
                <i class="fa-solid fa-eye me-1"></i> {PHP.L.xtradbrowusers_details_tpl_show_hidden_content}
            </button>
        </div>
    </div>
</div>
<!-- ENDIF -->
<!-- Telegram (личный) -->
<!-- IF {USERS_ROW_XTRA_X011_TG_VENDOR_ORDERS_VALUE} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon telegram me-3">
        <i class="fa-brands fa-telegram fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{USERS_ROW_XTRA_X011_TG_VENDOR_ORDERS_TITLE}</div>
        <a href="https://t.me/{USERS_ROW_XTRA_X011_TG_VENDOR_ORDERS_VALUE}" target="_blank" rel="noopener noreferrer" class="telegram-link">
            @{USERS_ROW_XTRA_X011_TG_VENDOR_ORDERS_VALUE}
        </a>
    </div>
</div>
<!-- ENDIF -->
<!-- Telegram-канал -->
<!-- IF {USERS_ROW_XTRA_X012_TG_CHANEL_VENDOR_VALUE} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon telegram me-3">
        <i class="fa-brands fa-telegram fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{USERS_ROW_XTRA_X012_TG_CHANEL_VENDOR_TITLE}</div>
        <a href="https://t.me/{USERS_ROW_XTRA_X012_TG_CHANEL_VENDOR_VALUE}" target="_blank" rel="noopener noreferrer" class="telegram-link">
            @{USERS_ROW_XTRA_X012_TG_CHANEL_VENDOR_VALUE}
        </a>
    </div>
</div>
<!-- ENDIF -->
<!-- Файл (резюме) -->
<!-- IF {USERS_ROW_XTRA_X200_RESUME_FILE_VALUE} -->
<div class="d-flex align-items-center mb-3">
    <div class="me-3">
        <label>{USERS_ROW_XTRA_X200_RESUME_FILE_TITLE}:</label>
    </div>
    <div>
        <a href="{PHP.cfg.mainurl}/datas/exflds/xtradbrowusers/{USERS_ROW_XTRA_X200_RESUME_FILE_VALUE}"
        class="btn btn-primary btn-sm"
        target="_blank"
        rel="noopener noreferrer">
            <i class="fa-solid fa-download me-1"></i> {PHP.L.Download}
        </a>
    </div>
</div>
<!-- ENDIF -->
<!-- Дата последнего повышения -->
<!-- IF {USERS_ROW_XTRA_X200_LAST_PROMOTION} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon calendar me-3">
        <i class="fa-solid fa-calendar-alt fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{USERS_ROW_XTRA_X200_LAST_PROMOTION_TITLE}</div>
        <div class="contact-value">{USERS_ROW_XTRA_X200_LAST_PROMOTION}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- Отдел -->
<!-- IF {USERS_ROW_XTRA_X200_DEPARTMENT} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon building me-3">
        <i class="fa-solid fa-building fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{USERS_ROW_XTRA_X200_DEPARTMENT_TITLE}</div>
        <div class="contact-value">{USERS_ROW_XTRA_X200_DEPARTMENT}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- ENDIF -->
```

Напоминаю. [**скриншоты смотрим в этой статье**](https://abuyfile.com/ru/usersblog/cheat-sheet-xtradbrowusers).

Про поезда и паравозики не буду, читайте выше. Подробнее также смотрите [**в моих шаблонах для Cotonti**](https://abuyfile.com/ru/market/cotonti/themes) и в [**файле хукинга**](https://github.com/webitproff/xtradbrowusers-cotonti/blob/main/xtradbrowusers/xtradbrowusers.users.loop.php) этого плагина!

---

## Статьи, форумы, интернет-магазин, комментарии и теги нашего плагина.

Прописание тегов и сборка "составов поездов" по предыдущему модулю, - модулю пользователей 'users', как по мне это было простенько.  
Разумеется это субъективный взгляд, и новичкам везде тяжело, пока не освоятся.  
Поэтому я и прибегаю к разного рода самым известным аналогиям, что бы вам, как новичку было проще сопоставить то, что вам уже известно с тем, что представлено в шпаргалке. Прибегая к такого рода "познанию в сравнении" вы по большей части не будете создавать новые знания, а будете пользоваться вашими текущими, еще с детства.  
***Вы точно забудете, имена шаблонов, полей, что и где прописывать, но вы никогда не забудете про "паровозик с вагонами", который нужно собрать.*** Уверен также не забудете, что "официанту" нужно назвать корректное имя того, что желаете от него получить, и тут вспомните, что имя, - это уже собранный "железнодорожный состав", со своим локомотивом, собственными вагонами пассажирскими, грузовыми, багажными, почтовыми и т.д.

Но если "внутри" модуля 'users' нам было достаточно "официанту сказать", - «дай мне в шаблоне здесь **{КАРТОШКА_ЖАРЕННАЯ}**, **{КЕТЧУП_ОСТРЫЙ}**», то в расширениях за пределами шаблонов модуля 'users' (простите за тавтологию, но тут лучше так), мы будем вынужденны говорить, указывая явное "географическое" происхождение.  
Например, - **{ЕГИПЕТСКАЯ_КАРТОШКА_ЖАРЕННАЯ}**, **{АМЕРИКАНКСАЯ_КАРТОШКА_ЖАРЕННАЯ}**, **{ЧИЛИЙСКИЙ_КЕТЧУП_ОСТРЫЙ}** и.д.  
И так, чутку забегая вперед, покажу, как мы будем говорить, а точнее называть официанту (шаблонизатору XTemplate) имена "составов с географическим признаком":

В статьях на странице полной новости:

```html
{PAGE_OWNER_XTRA_X200_RESUME_FILE}
{PAGE_OWNER_XTRA_X200_RESUME_FILE_TITLE}

{PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY_TITLE}
{PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY}
{PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY_NAME}
```

На форуме, в списках постов (ответов в теме):

```html
{FORUMS_POSTS_ROW_USER_XTRA_X200_RESUME_FILE}
{FORUMS_POSTS_ROW_USER_XTRA_X200_RESUME_FILE_TITLE}

{FORUMS_POSTS_ROW_USER_XTRA_X200_RESIDENCE_COUNTRY_TITLE}
{FORUMS_POSTS_ROW_USER_XTRA_X200_RESIDENCE_COUNTRY}
{FORUMS_POSTS_ROW_USER_XTRA_X200_RESIDENCE_COUNTRY_NAME}
```

В товарах, на странице карточки товара, в блоке информации о продавце:

```html
{MARKET_OWNER_XTRA_X200_RESUME_FILE}
{MARKET_OWNER_XTRA_X200_RESUME_FILE_TITLE}

{MARKET_OWNER_XTRA_X200_RESIDENCE_COUNTRY_TITLE}
{MARKET_OWNER_XTRA_X200_RESIDENCE_COUNTRY}
{MARKET_OWNER_XTRA_X200_RESIDENCE_COUNTRY_NAME}
```

В комментариях, на странице статьи полной новости, в блоке списка комментариев и информации о авторе комментария:

```html
{COMMENTS_ROW_AUTHOR_XTRA_X200_RESUME_FILE}
{COMMENTS_ROW_AUTHOR_XTRA_X200_RESUME_FILE_TITLE}

{COMMENTS_ROW_AUTHOR_XTRA_X200_RESIDENCE_COUNTRY_TITLE}
{COMMENTS_ROW_AUTHOR_XTRA_X200_RESIDENCE_COUNTRY}
{COMMENTS_ROW_AUTHOR_XTRA_X200_RESIDENCE_COUNTRY_NAME}
```

На первый взгляд, здесь тоже все очень просто и оно действительно так, но есть ньюанс, если раньше, с модулем пользователей, наш плагин сам указывал "локомотив", главный, ключевой тягач всех вагонов, то здесь, с расширения за пределами модуля пользователей, плагин заранее не знает его.

В дебри лезть не будем, здесь давайте усвоим одно, что как и у модуля 'users', у остальных модулей и плагинов используются такие же, но свои тягачи, со своими именами. Паровоз, тепловоз, электровоз, дизелевоз, автомотриса - в общем смысле назначение одно, - тянуть за собой состав вагонов, из которых мы составляем правильные имена, что бы их потом назвать официанту.

Так как же составлять правильно имена тегов?

1. Правило первое.

К "локомотиву" цепляемся в последнюю очередь, сразу собираем состав вагонов.

2. Правило второе.

Состав вагонов, за пределами модуля пользователей, всегда начинается с "вагона обслуживания", а именно с постпрефикса "`XTRA_`".

К "вагону обслуги" цепляем "первый ключевой" вагон, а это имя вашего поля, которое всегда видете в админке плагина, на вкладке "Статистика", в колонке "Имя поля".  
К "первому ключевому", с характерным звуком, пристыковываем замыкающий суффиксный вагон атрибутов, в виде "`_TITLE`", "`_NAME`" или "`_VALUE`", взамисимости от характера "груза", но об этом позже.

3. Правило третье.

Если "поехал" один собранный поезд из вагона обслуги и первого ключевого, - поедут все остальные.

Собираем состав:

```cpp
- "XTRA_"                         - вагон обслуги, для дальних поездок, за пределами модуля 'users';
- "X011_TG_VENDOR_ORDERS"         - ключевой вагон, с именем нашего поля, в данном случае, для перевозки данных поля "телеграм"
```

Стыкуем эти два вагона

"`XTRA_`" + "`X011_TG_VENDOR_ORDERS`" = `XTRA_X011_TG_VENDOR_ORDERS`

Всё! у нас есть основа поезда, это основа нашего состава.  
Теперь, можно цепляться к любому локомотиву, который тягает другие поезда в нужном "географическом" направлении.  
Выше о них уже я писал, это:

```cpp
- "PAGE_OWNER_"                - тягач, всего, что связано с пользователем, владельцем статьи, на ее полной странице, по собственной ссылке. 

- "FORUMS_POSTS_ROW_USER_"     - тягач, всего, что связано с пользователем, владельцем/автором поста/ответа в любой теме форума.  

- "COMMENTS_ROW_AUTHOR_"       - тягач, всего, что связано с пользователем, автором комментария, в списке комментариев к кокнретной статье.

- "MARKET_OWNER_"              - тягач, всего, что связано с пользователем, владельцем товара, в карточке его полной страницы.
```

Стыкуем локомотив и основу поезда для статьи, что бы вывести в шаблоне page.tpl, он же page.news.tpl или page.usersblog.tpl - это просто вариации одного шаблона.

"`PAGE_OWNER_`" + `"XTRA_X011_TG_VENDOR_ORDERS`" = "`PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS`"

Вот и получили наш поезд в сборе, он почти готов к отправке.  
Осталось нам, обратиться к "официанту", который обслуживает наши шаблоны, а сейчас это page.tpl (полная статья) и правильно сказать, обернув составленное имя в фигурные скобки:

```html
{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS}
```

Для нас это звучит примерно так:

Принеси мне в статью, "служебный вагон" плагина 'xtradbrowusers' и прикрепленный к нему, "ключевой вагон", я надеюсь там есть нужные мне данные поля телеграм этого пользователя.

Мы проверяем, и в нужном месте появились данные, которые мы попросили у официанта.  
Но нам этого мало, и мы хотим получить название этого поля.  
Не путать с "имя поля".  
Зайдите в админку, таблица "Параметры экстраполей" вы наглядно увидите разницу.  
Название поля, - это описательная пояснительная записка к каждому полю, что бы мы понимали, что это за данные. Например, можно вывести дату, а это дата чего именно? Вот для этого и существуют названия полей, которые мы получаем, стыкуя с нашим составом, суффиксный вагон атрибута "_TITLE".

Для предельной простоты, рекомендую запомнить, что бы не путаться, увидели атрибут "_TITLE" в составе экстраполя - это этикетка, лейба, лейбл, стикер того, что лежит в ОСНОВНОМ СОСТАВЕ из служебного и ключевого вагонов.

И по аналогии, с тем, что мы уже знаем, берем наш основной поезд, уже с локомотивом и дополнительно стыкуем:

"`PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS`" + `"_TITLE`" = "`PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS_TITLE`"

Заворачиваем в обертку из фигурных скобок, и передаем официанту новый поезд и в новом составе, вот в таком виде:

```html
{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS_TITLE}
```

И если он уже приносил `{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS}`, то на ваш новый запрос, ответит "мм-гу" и тут же покажет `{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS_TITLE}`.

Оформим это разметкой HTML-кода, и в нужном месте, где-то после никнейма пользователя (владельца статьи) добавим:

```html
<!-- IF {PHP|cot_plugin_active('xtradbrowusers')} -->
<!-- IF {PAGE_OWNER_XTRA_X020_ABOUT_VENDOR_TEXT} -->
<div class="d-flex mb-3">
    <div class="contact-icon about me-3">
        <i class="fa-solid fa-circle-info fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X020_ABOUT_VENDOR_TEXT_TITLE}</div>
        <div class="contact-value">{PAGE_OWNER_XTRA_X020_ABOUT_VENDOR_TEXT}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X010_PHONE_VENDOR_ORDERS_VALUE} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon phone me-3">
        <i class="fa-solid fa-phone fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X010_PHONE_VENDOR_ORDERS_TITLE}</div>
        <div class="d-flex align-items-center">
            <span id="phone-{PAGE_OWNER_ID}" class="contact-value fs-3" style="letter-spacing:2px"></span>
            <button type="button" class="btn btn-outline-primary btn-sm ms-2"
                id="show-phone-btn-{PAGE_OWNER_ID}"
                data-phone="{PAGE_OWNER_XTRA_X010_PHONE_VENDOR_ORDERS_VALUE}"
                onclick="document.getElementById('phone-{PAGE_OWNER_ID}').textContent = this.dataset.phone; this.style.display='none';">
                <i class="fa-solid fa-eye me-1"></i> {PHP.L.xtradbrowusers_details_tpl_show_hidden_content}
            </button>
        </div>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon telegram me-3">
        <i class="fa-brands fa-telegram fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS_TITLE}</div>
        <a href="https://t.me/{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS}" target="_blank" rel="noopener noreferrer" class="telegram-link">
            @{PAGE_OWNER_XTRA_X011_TG_VENDOR_ORDERS}
        </a>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X012_TG_CHANEL_VENDOR_VALUE} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon telegram me-3">
        <i class="fa-brands fa-telegram fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X012_TG_CHANEL_VENDOR_TITLE}</div>
        <a href="https://t.me/{PAGE_OWNER_XTRA_X012_TG_CHANEL_VENDOR_VALUE}" target="_blank" rel="noopener noreferrer" class="telegram-link">
            @{PAGE_OWNER_XTRA_X012_TG_CHANEL_VENDOR_VALUE}
        </a>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X200_RESUME_FILE} -->
<div class="d-flex align-items-center mb-3">
    <div class="me-3">
        <label>{PAGE_OWNER_XTRA_X200_RESUME_FILE_TITLE}:</label>
    </div>
    <div>
        <a href="{PHP.cfg.mainurl}/datas/exflds/xtradbrowusers/{PAGE_OWNER_XTRA_X200_RESUME_FILE}"
        class="btn btn-primary btn-sm"
        target="_blank"
        rel="noopener noreferrer">
            <i class="fa-solid fa-download me-1"></i> {PHP.L.Download}
        </a>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X200_LAST_PROMOTION} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon calendar me-3">
        <i class="fa-solid fa-calendar-alt fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X200_LAST_PROMOTION_TITLE}</div>
        <div class="contact-value">{PAGE_OWNER_XTRA_X200_LAST_PROMOTION}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X200_DEPARTMENT} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon building me-3">
        <i class="fa-solid fa-building fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X200_DEPARTMENT_TITLE}</div>
        <div class="contact-value">{PAGE_OWNER_XTRA_X200_DEPARTMENT}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- IF {PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY} -->
<div class="d-flex align-items-center mb-3">
    <div class="contact-icon building me-3">
        <i class="fa-solid fa-building fa-xl"></i>
    </div>
    <div>
        <div class="contact-label">{PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY_TITLE}</div>
        <div class="contact-value">{PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY} | {PAGE_OWNER_XTRA_X200_RESIDENCE_COUNTRY_NAME}</div>
    </div>
</div>
<!-- ENDIF -->
<!-- ENDIF -->
```

Смотрите пояснительные скриншоты [**в статье с краткой шпаргалкой**](https://abuyfile.com/ru/usersblog/cheat-sheet-xtradbrowusers).

[**Файл хукинга**](https://github.com/webitproff/xtradbrowusers-cotonti/blob/main/xtradbrowusers/xtradbrowusers.usertags.php)

