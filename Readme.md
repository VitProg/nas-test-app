# Тестовое задание

# Рабочий пример
http://nastestapp.jquarter.ru/currency

# Установка
1. клонировать репозиторий `git clone https://github.com/VitProg/nas-test-app`
2. создать папку protected/runtime и web/assets  с правами на запись
3. настроить подключение к базе в `protected/config/database.php`
4. выполнить в консоли (в корневой директории проекта):
    * загрузить нужные пакеты `composer.phar update`
    * создать нужные таблицы в БД `php protected/yiic migrate`

`/curency`
таблица котировок с выбором даты (по умолчанию сегодняшняя)

`/site/login`
Авторизация.
Чтобы войти под админом: admin/admin

`/admin/curency`
админская таблица котировок с выбором даты (по умолчанию сегодняшняя)
с кнопкой "обновить данные" за выбранную дату