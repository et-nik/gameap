<table class="w-full max-w-full mb-4 bg-transparent block w-full overflow-auto scrolling-touch" id="gdaemonTasks-table">
    <thead>
        <tr>
            <th>Run Aft Id</th>
        <th>Dedicated Server Id</th>
        <th>Server Id</th>
        <th>Task</th>
        <th>Data</th>
        <th>Cmd</th>
        <th>Output</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($gdaemonTasks as $gdaemonTask)
        <tr>
            <td>{!! $gdaemonTask->run_aft_id !!}</td>
            <td>{!! $gdaemonTask->dedicated_server_id !!}</td>
            <td>{!! $gdaemonTask->server_id !!}</td>
            <td>{!! $gdaemonTask->task !!}</td>
            <td>{!! $gdaemonTask->data !!}</td>
            <td>{!! $gdaemonTask->cmd !!}</td>
            <td>{!! $gdaemonTask->output !!}</td>
            <td>{!! $gdaemonTask->status !!}</td>
            <td>
                {!! Form::open(['route' => ['gdaemonTasks.destroy', $gdaemonTask->id], 'method' => 'delete']) !!}
                <div class='relative inline-flex align-middle'>
                    <a href="{!! route('gdaemonTasks.show', [$gdaemonTask->id]) !!}" class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('gdaemonTasks.edit', [$gdaemonTask->id]) !!}" class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>