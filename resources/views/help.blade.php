@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">{{ __('home.get_help') }}</li>
    </ol>
@endsection

@section('content')
    @if (app()->getLocale() == 'en')
        <div class="card mb-2">
            <div class="card-header">
                {{ __('home.get_help') }}
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <p>You can get community help</p>
                        </div>

                        <div class="col-6"><i class="fas fa-comment-alt"></i> Forum: <a target="_blank" href="https://forum.gameap.ru">https://forum.gameap.ru</a></div>
                        <div class="col-6"><i class="fab fa-vk"></i> VK Group (Russian): <a target="_blank" href="https://vk.com/gameap_group">https://vk.com/gameap_group</a></div>
                        <div class="col-6"><i class="fab fa-discord"></i> Discord <a href="https://discord.gg/SqtHpZc">https://discord.gg/SqtHpZc</a></div>
                        <div class="col-6"><i class="fab fa-telegram-plane"></i> Telegram chat: <a href="http://t.me/game_admin_panel">http://t.me/game_admin_panel</a></div>
                        <div class="col-6"><i class="fab fa-telegram-plane"></i> Developer Telegram: <a href="http://t.me/k_nik">http://t.me/k_nik</a></div>
                        <div class="col-6"><i class="fas fa-book"></i> Documentation: <a target="_blank" href="http://docs.gameap.ru/en/">https://docs.gameap.ru</a></div>

                        <div class="col-12 mt-4">
                            <p>Do you like GameAP? Help development.</p>
                            <ul>
                                <li>Suggest your ideas;</li>
                                <li>Report a found bugs and problems</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @elseif (app()->getLocale() == 'ru')
        <div class="card mb-2">
            <div class="card-header">
                {{ __('home.get_help') }}
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <p>Вы можете получить помощь у сообщества</p>
                        </div>

                        <div class="col-6"><i class="fas fa-comment-alt"></i> Форум: <a target="_blank" href="https://forum.gameap.ru">https://forum.gameap.ru</a></div>
                        <div class="col-6"><i class="fab fa-vk"></i> Группа ВК: <a target="_blank" href="https://vk.com/gameap_group">https://vk.com/gameap_group</a></div>
                        <div class="col-6"><i class="fab fa-discord"></i> Канал Discord <a href="https://discord.gg/SqtHpZc">https://discord.gg/SqtHpZc</a></div>
                        <div class="col-6"><i class="fab fa-telegram-plane"></i> Чат Telegram: <a href="http://t.me/game_admin_panel">http://t.me/game_admin_panel</a></div>
                        <div class="col-6"><i class="fab fa-telegram-plane"></i> Telegram разработчика: <a href="http://t.me/k_nik">http://t.me/k_nik</a></div>
                        <div class="col-6"><i class="fas fa-book"></i> Документация: <a target="_blank" href="http://docs.gameap.ru/ru/">https://docs.gameap.ru</a></div>
                        
                        <div class="col-12 mt-4">
                            <p>Нравится панель? Помогите разработке</p>
                            <ul>
                                <li>Предложите свои идеи;</li>
                                <li>Сообщите о найденных багах и проблемах;</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection