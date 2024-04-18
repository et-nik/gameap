@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700">{{ __('home.get_help') }}</li>
    </ol>
@endsection

@section('content')
    @if (app()->getLocale() == 'en')
        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                {{ __('home.get_help') }}
            </div>
            <div class="flex-auto p-6">
                <div class="md:w-full pr-4 pl-4">
                    <div class="flex flex-wrap ">
                        <div class="md:w-full pr-4 pl-4">
                            <h3>You can get community help</h3>

                            <div class="flex flex-wrap ">
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fas fa-book"></i> Documentation: <a target="_blank" href="http://docs.gameap.com/en/">https://docs.gameap.com</a></div>
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-telegram-plane"></i> Telegram chat: <a target="_blank" href="http://t.me/game_admin_panel">http://t.me/game_admin_panel</a></div>

                                <div class="md:w-1/2 pr-4 pl-4"><i class="fas fa-comment-alt"></i> Forum: <a target="_blank" href="https://forum.gameap.ru">https://forum.gameap.ru</a></div>
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-discord"></i> Discord <a target="_blank" href="https://discord.gg/SqtHpZc">https://discord.gg/SqtHpZc</a></div>

                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-telegram-plane"></i> Developer Telegram: <a target="_blank" href="http://t.me/k_nik">http://t.me/k_nik</a></div>
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-vk"></i> VK Group (Russian): <a target="_blank" href="https://vk.com/gameap">https://vk.com/gameap</a></div>
                            </div>
                        </div>

                        <div class="md:w-full pr-4 pl-4 mt-4">
                            <h3>Do you like GameAP? Help development.</h3>
                            <ul>
                                <li>Suggest your ideas;</li>
                                <li>Report a found bugs and problems</li>
                            </ul>
                        </div>

                        <div class="md:w-full pr-4 pl-4 mt-2 mb-2">
                            <h3>Thanks</h3>
                            <p>Without them, panel development would be much more difficult.</p>

                            <ul>
                                <li><a target="_blank" href="https://github.com/iTeeLion">Sergey Abu</a>. For his contribution to the panel, game servers settings, bug reports.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif (app()->getLocale() == 'ru')
        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                {{ __('home.get_help') }}
            </div>
            <div class="flex-auto p-6">
                <div class="md:w-full pr-4 pl-4">
                    <div class="flex flex-wrap ">
                        <div class="md:w-full pr-4 pl-4 mb-2">
                            <h3>Вы можете получить помощь у сообщества</h3>

                            <div class="flex flex-wrap ">
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fas fa-book"></i> Документация: <a target="_blank" href="http://docs.gameap.com/ru/">https://docs.gameap.com</a></div>
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-telegram-plane"></i> Чат Telegram: <a target="_blank" href="http://t.me/game_admin_panel">http://t.me/game_admin_panel</a></div>

                                <div class="md:w-1/2 pr-4 pl-4"><i class="fas fa-comment-alt"></i> Форум: <a target="_blank" href="https://forum.gameap.ru">https://forum.gameap.ru</a></div>
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-discord"></i> Канал Discord <a target="_blank" href="https://discord.gg/SqtHpZc">https://discord.gg/SqtHpZc</a></div>

                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-telegram-plane"></i> Telegram разработчика: <a target="_blank" href="http://t.me/k_nik">http://t.me/k_nik</a></div>
                                <div class="md:w-1/2 pr-4 pl-4"><i class="fab fa-vk"></i> Группа ВК: <a target="_blank" href="https://vk.com/gameap">https://vk.com/gameap</a></div>
                            </div>
                        </div>

                        <div class="md:w-full pr-4 pl-4 mt-2 mb-2">
                            <h3>Нравится панель? Помогите разработке</h3>
                            <ul>
                                <li>Предложите свои идеи;</li>
                                <li>Сообщите о найденных багах и проблемах;</li>
                            </ul>
                        </div>

                        <div class="md:w-full pr-4 pl-4 mt-2 mb-2">
                            <h3>Благодарности</h3>
                            <p>Без них, разработка панели шла бы гораздо труднее.</p>

                            <ul>
                                <li><a target="_blank" href="https://github.com/iTeeLion">Sergey Abu</a> за вклад в панель, настройки для игровых серверов, багрепорты.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
