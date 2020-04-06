<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dedicated servers Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'title_list' => 'Список выделенных серверов',
    'title_create' => "Создание выделенного сервера",
    'title_edit' => "Редактирование выделенного сервера",

    'dedicated_servers' => 'Выделенные серверы',

    'create'            => 'Создать',
    'edit'              => 'Редактировать',
    'save'              => 'Сохранить',
    'main'              => 'Основное',
    'name'              => 'Имя',
    'location'          => 'Локация',
    'provider'          => 'Провайдер',
    'ip'                => 'IP',
    'os'                => 'Операционная система',
    'servers_count'     => 'Количество серверов',

    'scripts'           => 'Скрипты',
    'edit_scripts'      => 'Редактировать скрипты',
    'server_certificate' => 'Сертификат сервера',
    'client_certificate' => 'Сертификат клиента',
    'change_certificate' => 'Изменить сертификат',

    'ip_list'           => 'Список IP',
    'gdaemon_api_key'   => 'Ключ GDaemon API',
    'gdaemon_version'   => 'Версия GameAP Daemon',
    'gdaemon_uptime'    => 'GameAP Daemon uptime',

    'gdaemon_online_servers_count'   => 'Игровых серверов онлайн',
    'gdaemon_working_tasks_count'    => 'GDaemon заданий выполняется',
    'gdaemon_waiting_tasks_count'    => 'GDaemon заданий ожидает',

    'gdaemon_empty_info' => 'Не удалось получить информацию',

    /* Shortcodes description */
    'game_server_shortcodes'    => 'Шорткоды игрового сервера',
    'd_shortcodes_host'         => 'хост или IP сервера',
    'd_shortcodes_port'         => 'порт сервера',
    'd_shortcodes_query_port'   => 'query порт сервера',
    'd_shortcodes_rcon_port'    => 'rcon порт сервера',
    'd_shortcodes_dir'          => 'абсолютный путь к каталог сервера',
    'd_shortcodes_uuid'         => 'уникальный id',
    'd_shortcodes_uuid_short'   => 'короткий уникальный id',
    'd_shortcodes_game'         => 'код игры',
    'd_shortcodes_user'         => 'имя пользователя (существующий пользователь на выделенном сервере, не в админ панели)',

    'start_restart_shortcodes'   => 'Запуск/перезапуск',
    'd_shortcodes_start_command'   => 'Команда запуска сервера',

    'console_command_shortcodes'   => 'Скрипт отправки команды',
    'd_shortcodes_console_command'   => 'Команда консоли',

    'create_success_msg' => 'Выделенный сервер успешно создан',
    'update_success_msg' => 'Выделенный сервер успешно обновлён',
    'delete_success_msg' => 'Выделенный сервер успешно удалён',

    'autosetup_title' => 'Автоматическая настройка выделенного сервера',

    'autosetup_description_debian_ubuntu' => '<p>Только для Debian/Ubuntu.</p>
                    <p>Для автоматической настройки GDaemon запустите команду в консоли выделенного сервера:</p>',

    'autosetup_description_windows' => '<p>Только для Windows</p>
                                <ul>
                                    <li>Установите <a target="_blank" href="https://www.microsoft.com/ru-ru/download/details.aspx?id=53587">Microsoft Visual C++ 2015</a></li>
                                    <li>Скачайте инсталлятор <a target="_blank" href="http://packages.gameap.ru/windows/gameap-daemon-installer.exe">gameap-daemon-installer.exe</a>
                                        (<code>http://packages.gameap.ru/windows/gameap-daemon-installer.exe</code>)
                                    </li>
                                    <li>Запустите инсталлятор на вашем Windows хосте</li>
                                    <li>Заполните все поля:<br>
                                        Host: <code>:host</code><br>
                                        Token: <code>:token</code>
                                    </li>
                                    <li>Кликните по кнопке установки</li>
                                </ul>',

    'autosetup_expire_msg' => 'Ваша ссылка будет действительна 5 минут.',
    'autosetup_expire_token_msg' => 'Токен будет действителен 5 минут',
];