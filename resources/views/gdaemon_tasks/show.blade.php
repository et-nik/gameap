@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Gdaemon Task
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="flex flex-wrap " style="padding-left: 20px">
                    @include('gdaemon_tasks.show_fields')
                    <a href="{!! route('gdaemonTasks.index') !!}" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
