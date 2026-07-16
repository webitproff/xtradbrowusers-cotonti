# xtradbrowusers-cotonti


### карта файлов плагина xtradbrowusers с указанием назначения и используемых хуков

```

/xtradbrowusers/
├── inc/
│   └── xtradbrowusers.functions.php         # API: загрузка/сохранение, регистрация таблицы
├── lang/
│   ├── xtradbrowusers.ru.lang.php           # Русская локализация
│   ├── xtradbrowusers.en.lang.php           # Английская локализация
├── setup/
│   ├── xtradbrowusers.install.sql           # SQL: создание таблицы cot_xtradbrowusers
│   ├── xtradbrowusers.install.php           # PHP: демо-поля при установке
│   ├── xtradbrowusers.uninstall.php         # PHP: удаление extra_fields + таблицы
│   └── xtradbrowusers.uninstall.sql         # SQL: DROP TABLE
├── xtradbrowusers.global.php                # Глобальная инициализация (подключение языков, функций)
├── xtradbrowusers.setup.php                 # Регистрация плагина в БД Cotonti
├── xtradbrowusers.extrafields.php           # admin.extrafields.first – регистрация таблицы для управления экстраполями
├── xtradbrowusers.header.tags.php           # Хук header.tags. Присваивает теги {USERS_HEADER_XTRA_XXXXX} и {USERS_HEADER_XTRA_XXXXX_TITLE}
├── xtradbrowusers.users.profile.tags.php    # users.profile.tags – теги в форме редактирования профиля (пользователь)
├── xtradbrowusers.users.profile.update.done.php # users.profile.update.done – сохранение при редактировании профиля
├── xtradbrowusers.users.edit.tags.php       # users.edit.tags – теги в форме админ. редактирования пользователя
├── xtradbrowusers.users.edit.update.done.php # users.edit.update.done – сохранение при админ. редактировании
├── xtradbrowusers.users.details.tags.php    # users.details.tags – теги в публичном профиле
├── xtradbrowusers.users.loop.php            # users.loop – теги в списке пользователей (USERS_ROW_...)
├── xtradbrowusers.usertags.php              # usertags.main – интеграция в cot_generate_usertags() (теги без префикса)
├── xtradbrowusers.users.delete.done.php     # users.delete.done – удаление записи при удалении пользователя
├── xtradbrowusers.users.register.tags.php   # users.register.tags – теги в форме регистрации
└── xtradbrowusers.users.register.add.done.php # users.register.add.done – сохранение после регистрации 

```
