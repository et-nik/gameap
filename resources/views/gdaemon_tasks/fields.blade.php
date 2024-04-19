<!-- Run Aft Id Field -->
<div class="mb-3 sm:w-1/2 pr-4 pl-4">
    {!! Form::label('run_aft_id', 'Run Aft Id:') !!}
    {!! Form::number('run_aft_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Dedicated Server Id Field -->
<div class="mb-3 sm:w-1/2 pr-4 pl-4">
    {!! Form::label('dedicated_server_id', 'Dedicated Server Id:') !!}
    {!! Form::number('dedicated_server_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Server Id Field -->
<div class="mb-3 sm:w-1/2 pr-4 pl-4">
    {!! Form::label('server_id', 'Server Id:') !!}
    {!! Form::number('server_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Task Field -->
<div class="mb-3 sm:w-1/2 pr-4 pl-4">
    {!! Form::label('task', 'Task:') !!}
    {!! Form::text('task', null, ['class' => 'form-control']) !!}
</div>

<!-- Data Field -->
<div class="mb-3 sm:w-full pr-4 pl-4 lg:w-full pr-4 pl-4">
    {!! Form::label('data', 'Data:') !!}
    {!! Form::textarea('data', null, ['class' => 'form-control']) !!}
</div>

<!-- Cmd Field -->
<div class="mb-3 sm:w-full pr-4 pl-4 lg:w-full pr-4 pl-4">
    {!! Form::label('cmd', 'Cmd:') !!}
    {!! Form::textarea('cmd', null, ['class' => 'form-control']) !!}
</div>

<!-- Output Field -->
<div class="mb-3 sm:w-full pr-4 pl-4 lg:w-full pr-4 pl-4">
    {!! Form::label('output', 'Output:') !!}
    {!! Form::textarea('output', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="mb-3 sm:w-1/2 pr-4 pl-4">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="mb-3 sm:w-full pr-4 pl-4">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('gdaemonTasks.index') !!}" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline btn-default">Cancel</a>
</div>
