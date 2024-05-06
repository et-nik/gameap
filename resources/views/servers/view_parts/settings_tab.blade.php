<div class="flex flex-wrap mt-2">
    <div class="md:w-full">
        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
            <div class="flex-auto p-6">
                {!! Form::model($server, ['method' => 'PATCH', 'route' => ['servers.updateSettings', $server->id], 'id' => 'adminServerForm']) !!}

                <div class="md:w-full pr-4 pl-4">
                    <div class="relative block mt-4 mb-4">
                        {{ Form::checkbox('autostart', true, $autostart, ['id' => 'autostart', 'class' => 'form-check-input']) }}
                        {{ Form::label('autostart', __('servers.autostart_setting'), ['class' => 'form-check-label']) }}
                    </div>
                </div>

                <div class="md:w-full pr-4 pl-4">
                    <div class="relative block mt-4 mb-4">
                        {{ Form::checkbox('update_before_start', true, $updateBeforeStart, ['id' => 'update_before_start', 'class' => 'form-check-input']) }}
                        {{ Form::label('update_before_start', __('servers.update_before_start_setting'), ['class' => 'form-check-label']) }}
                    </div>
                </div>

                @if(!empty($server->gameMod->vars))
                    @foreach ($server->gameMod->vars as $var)
                        @if (isset($var['admin_var']) && $var['admin_var'])
                            @cannot('admin roles & permissions')
                                @continue
                            @endcannot
                        @endif

                        <div class="md:w-full pr-4 pl-4">
                            {{ Form::bsText(
                                    'vars[' . $var['var'] . ']',
                                    (isset($server->vars[ $var['var'] ]))
                                        ? $server->vars[ $var['var'] ]
                                        : $var['default'],
                                    $var['info']
                                ) }}
                        </div>
                    @endforeach
                @endif

                <div class="md:w-full mt-4 mb-4">
                    <g-button color="green">
                        <i class="fas fa-save"></i></i>&nbsp;{{ __('main.save') }}
                    </g-button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
