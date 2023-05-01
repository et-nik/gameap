<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Servers Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'title_servers_list' => 'Список игровых серверов',
    'title_create'       => 'Создание игрового сервера',
    'title_edit'         => 'Редактирование игрового сервера',
    'title_server'       => 'Игровой сервер',

    'servers'       => 'Серверы',
    'game_servers'  => 'Игровые Серверы',
    'file_manager'  => 'Файловый менеджер',

    'start'         => 'Запуск',
    'restart'       => 'Перезапуск',
    'stop'          => 'Остановка',
    'control'       => 'Управление',
    'update'        => 'Обновление',
    'reinstall'     => 'Переустановка',
    'status'        => 'Статус',
    'commands'      => 'Команды',
    'ip_port'       => 'IP:Порт',

    'enabled'       => 'Включен',

    'not_installed' => 'не установлен',
    'installed'     => 'установлен',
    'installation'  => 'установка',

    'disabled'      => 'отключен',
    'blocked'       => 'заблокирован',

    'offline'       => 'офлайн',
    'online'        => 'онлайн',

    'name'          => 'Имя',
    'game'          => 'Игра',
    'game_mod'      => 'Модификация',

    'tools'         => 'Инструменты',
    'files'         => 'Файлы',
    'admin'         => 'Администрирование',

    'task_scheduler' => 'Планировщик задач',

    'autostart_setting'           => 'Автозапуск в случае падения',
    'update_before_start_setting' => 'Обновлять сервер перед запуском',

    'process_status' => 'Статус процесса',
    'active'        => 'активен',
    'inactive'      => 'неактивен',
    'last_check'    => 'Последняя проверка',

    'query'         => 'Query',
    'query_players' => 'Игроков',
    'query_map'     => 'Карта',

    'console'       => 'Консоль',

    'not_installed_msg' => 'Сервер не установлен',
    'installation_process_msg' => 'Сервер в процессе установки',
    'disabled_msg' => 'Сервер отключен',
    'blocked_msg' => 'Сервер заблокирован',

    // Admin

    'create'        => 'Создать',
    'edit'          => 'Редактирование сервера',
    'revoke'        => 'Отозвать',

    'settings'          => 'Настройки',

    'install'       => 'Установить сервер',

    'server_info' => 'Информация о сервере',
    'basic_info'    => 'Основное',
    'ds_ip_ports'    => 'Выделенный сервер, IP, порты',
    'dedicated_server' => 'Выделенный сервер',
    'start_command' => 'Команда запуска',

    'start_success_msg' => 'Игровой сервер успешно запущен',
    'start_fail_msg' => 'Не удалось запустить сервер',
    'stop_success_msg' => 'Игровой сервер успешно остановлен',
    'stop_fail_msg' => 'Не удалось остановить сервер',
    'restart_success_msg' => 'Игровой сервер успешно перезапущен',
    'restart_fail_msg' => 'Не удалось перезапустить сервер',
    'create_success_msg' => 'Игровой сервер успешно создан',
    'update_success_msg' => 'Игровой сервер успешно обновлён',
    'delete_success_msg' => 'Игровой сервер успешно удалён',

    'settings_update_success_msg' => 'Настройки игрового сервера успешно обновлены',

    'task_success_msg' => 'Задача успешно выполнена',
    'task_see_log'     => 'Подробности смотрите в логе задачи.',

    'unknown_command_msg' => 'Неизвестная команда',

    'd_dir' => 'Оставьте пустым для автоматического создания. 
        Путь относительно рабочей директории выделенного сервера. 
        Например <strong>servers/my_server</strong>',

    'd_installation_is_stuck' => 'Похоже, что установка сервера зависла. ' .
        'Это могло произойти в случае возникновения ошибки в GameAP Daemon или по другой причине. ' .
        'Следующие действия помогут исправить проблему: ' .
        '<ul>' .
        '<li>Проверьте работу GameAP Daemon;</li>' .
        '<li>Перезапустите GameAP Daemon;</li>' .
        '<li>Установите статус сервера вручную. Перейдите в <a href=:link>администрирование игрового сервера</a> и поменяйте статус сервера.</li>' .
        '<ul>',

    'delete_confirm_msg' => 'Вы уверены, что хотите удалить сервер?',

    'delete_files' => 'Удалить файлы',

    'starting' => 'Запуск',
    'stopping' => 'Остановка',
    'restarting' => 'Перезапуск',
    'updating' => 'Обновление',
    'installing' => 'Установка',
    'reinstalling' => 'Переустановка',

    'command_progress_waiting' => 'Ожидание запуска задачи',
    'command_progress_executed' => 'Задание выполняется',
    'command_progress_waiting_status' => 'Проверка статуса сервера',

    'empty_list' => 'Серверы отсутствуют',

    'filters' => 'Фильтр',
    'select_game_filter_placeholder' => 'Выберите игры',
    'select_ip_filter_placeholder' => 'Выберите список IP',
];
