@php($title = __('servers.title_servers_list') )

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'text':'{{ __("servers.game_servers") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-lime-500 text-white hover:bg-lime-600' href="{{ route('admin.servers.create') }}">
            <span class="fa fa-plus-square"></span>&nbsp;{{ __('servers.create') }}
        </a>
    </div>

    @include('components.grid', [
        'modelsList' => $servers,
        'labels' => [__('servers.name'), __('servers.game'), __('servers.ip_port')],
        'attributes' => ['name', 'game.name', ['twoSeparatedValues', ['server_ip', ':', 'server_port']]],
        // 'viewRoute' => 'admin.servers.show',
        'editRoute' => 'admin.servers.edit',
        'destroyRoute' => 'admin.servers.destroy',
        'destroyConfirmAction' => '',
    ])

    {!! $servers->links() !!}
@endsection

@section('footer-scripts')
    <script>
        let confirmed = false;

        document.addEventListener('click', function(event) {
            if (event.target.closest('.btn-delete') && !confirmed) {
                event.preventDefault();

                let deleteFiles = false;

                window.$dialog.success({
                    title: '{{ __('servers.delete_confirm_msg') }}',
                    content: () => h('div', {class: "mt-4 mb-4"}, [
                        h('input', {
                            type: 'checkbox',
                            id: 'delete-files-checkbox',
                            onChange: () => {deleteFiles = true;},
                        }),
                        h('label', {class: 'ms-1', for: 'delete-files-checkbox'}, '{{ __('servers.delete_files') }}'),
                    ]),
                    positiveText: '{{ __('main.yes') }}',
                    negativeText: '{{ __('main.no' ) }}',
                    closable: false,
                    onPositiveClick: () => {
                        if (deleteFiles) {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.value = 'delete_files';
                            hiddenInput.name = 'delete_files';
                            event.target.parentNode.appendChild(hiddenInput);
                        }

                        confirmed = true;
                        const clonedEvent = new event.constructor(event.type, event);
                        event.target.dispatchEvent(clonedEvent);
                    },
                    onNegativeClick: () => {
                    }
                });
            }

            confirmed = false;
        });
    </script>
@endsection
