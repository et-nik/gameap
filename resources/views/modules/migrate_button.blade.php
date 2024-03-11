{{ Form::open(['id' => 'migrate', 'url' => route('modules.migrate'), 'style'=>'display:inline']) }}

{{ Form::button( '<i class="fas fa-redo"></i>&nbsp;<span class="hidden xl:inline">&nbsp;' . __('modules.migrate') . '</span>',
    [
        'class' => 'btn btn-success',
        'title' => __('main.delete'),
        'v-on:click' => 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
        'type' => 'submit'
    ]
    ) }}

{{ Form::close() }}
