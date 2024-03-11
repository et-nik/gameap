@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Gdaemon Tasks</h1>
        <h1 class="pull-right">
           <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600 pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gdaemonTasks.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('gdaemon_tasks.table')
            </div>
        </div>
    </div>
@endsection

