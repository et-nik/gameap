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

    'create'                    => 'Создать',
    'edit'                      => 'Редактировать',
    'view'                      => 'Просмотр',
    'save'                      => 'Сохранить',
    'main'                      => 'Основное',
    'name'                      => 'Имя',
    'location'                  => 'Локация',
    'provider'                  => 'Провайдер',
    'ip'                        => 'IP',
    'os'                        => 'Операционная система',
    'servers_count'             => 'Количество серверов',
    'download_logs'             => 'Скачать логи',
    'download_certificates'     => 'Скачать сертификаты',

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
    'd_shortcodes_id'           => 'id сервера',
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

    'delete_has_servers_error_msg' => 'Нельзя удалить выделенный сервер, на котором есть сервера',

    'autosetup_title' => 'Автоматическая настройка выделенного сервера',

    'autosetup_description_linux' => '<p>Можете использовать следующие хост и токен для настройки GDaemon используя gameapctl:</p>
                    <ul class="list-disc">
                        <li>Хост: <code>:host</code></li>
                        <li>Токен: <code>:token</code></li>
                    </ul>
                    <p>Или для автоматической настройки GDaemon запустите команду в консоли выделенного сервера:</p>',

    'autosetup_description_windows' => '<p>Только для Windows</p>
                                <ul class="list-disc">
                                    <li>Перейдите на страницу <a href="https://github.com/gameap/gameapctl/releases">gameapctl релизов</a>
                                        (<code>https://github.com/gameap/gameapctl/releases</code>)
                                    </li>
                                    <li>Выберите последнюю версию и скачайте архив для вашей архитектуры, скорее всего вам подойдёт gameapctl-vX.Y.Z-windows-amd64.zip</li>
                                    <li>Запустите gameapctl.exe на вашем Windows хосте</li>
                                    <li>Нажмите кнопку Install в секции GameAP Daemon</li>
                                    <li>Заполните все поля:<br>
                                        Host: <code>:host</code><br>
                                        Token: <code>:token</code>
                                    </li>
                                    <li>Кликните по кнопке установки</li>
                                </ul>',

    'autosetup_expire_msg' => 'Ваша ссылка будет действительна 5 минут.',
    'autosetup_expire_token_msg' => 'Токен будет действителен 5 минут',
];
