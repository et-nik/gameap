<!-- Id Field -->
<div class="mb-3">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $gdaemonTask->id !!}</p>
</div>

<!-- Run Aft Id Field -->
<div class="mb-3">
    {!! Form::label('run_aft_id', 'Run Aft Id:') !!}
    <p>{!! $gdaemonTask->run_aft_id !!}</p>
</div>

<!-- Created At Field -->
<div class="mb-3">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! \Gameap\Helpers\DateHelper::convertToLocal($gdaemonTask->created_at) !!}</p>
</div>

<!-- Updated At Field -->
<div class="mb-3">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! \Gameap\Helpers\DateHelper::convertToLocal($gdaemonTask->updated_at) !!}</p>
</div>

<!-- Dedicated Server Id Field -->
<div class="mb-3">
    {!! Form::label('dedicated_server_id', 'Dedicated Server Id:') !!}
    <p>{!! $gdaemonTask->dedicated_server_id !!}</p>
</div>

<!-- Server Id Field -->
<div class="mb-3">
    {!! Form::label('server_id', 'Server Id:') !!}
    <p>{!! $gdaemonTask->server_id !!}</p>
</div>

<!-- Task Field -->
<div class="mb-3">
    {!! Form::label('task', 'Task:') !!}
    <p>{!! $gdaemonTask->task !!}</p>
</div>

<!-- Data Field -->
<div class="mb-3">
    {!! Form::label('data', 'Data:') !!}
    <p>{!! $gdaemonTask->data !!}</p>
</div>

<!-- Cmd Field -->
<div class="mb-3">
    {!! Form::label('cmd', 'Cmd:') !!}
    <p>{!! $gdaemonTask->cmd !!}</p>
</div>

<!-- Output Field -->
<div class="mb-3">
    {!! Form::label('output', 'Output:') !!}
    <p>{!! $gdaemonTask->output !!}</p>
</div>

<!-- Status Field -->
<div class="mb-3">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $gdaemonTask->status !!}</p>
</div>

