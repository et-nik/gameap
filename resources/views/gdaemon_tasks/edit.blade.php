@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Gdaemon Task
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gdaemonTask, ['route' => ['gdaemonTasks.update', $gdaemonTask->id], 'method' => 'patch']) !!}

                        @include('gdaemon_tasks.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection