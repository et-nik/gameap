@extends('layouts.main')

@section('content')

    <div class="card mb-2">
        <div class="card-header">
            Main
        </div>
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-nowrap">
                    <div class="p-2 mb-3 text-center">
                        <a class="btn btn-block btn-lg btn-outline-dark rounded" href="/servers">
                            <i class="fas fa-server fa-5x m-1"></i>
                            <h5>Servers list</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-header">
            Information
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-2"><i class="fas fa-info-circle"></i> Your version: {{ Config::get('constants.AP_VERSION') }}</div>
                    <div class="col-2">Latest stable: 1.2.2</div>
                    <div class="col-2">Latest beta: 3.0.0-beta</div>
                    <div class="col-2">Latest unstable: 3.0.0-dev</div>
                </div>
            </div>

            <div class="col-12">
                <i class="fab fa-github"></i> GitHub:
                <a href="https://github.com/et-nik/gameap">https://github.com/et-nik/gameap</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <button class="btn btn-block btn-lg btn-warning rounded">
                <i class="fas fa-hands-helping"></i> Get Help
            </button>
        </div>

        <div class="col-4">
            <button href="https://docs.gameap.ru" class="btn btn-block btn-lg btn-info rounded">
                <i class="fas fa-book"></i> Documentation
            </button>
        </div>

        <div class="col-4">
            <button class="btn btn-block btn-lg btn-danger rounded">
                <i class="fas fa-bug"></i> Report a bug
            </button>
        </div>
    </div>

@endsection
