{{--
/**
* @var \Gameap\Models\Server $server
**/
--}}

<div class="row mt-2">
    <div class="col-md-12">
        <server-tasks
{{--                v-if="activeTab === 'schedules'"--}}
                :server-id="{{ $server->id }}"
                :privileges="{{
                    json_encode([
                        'start'     => Gate::check('server-start', $server),
                        'stop'      => Gate::check('server-stop', $server),
                        'restart'   => Gate::check('server-restart', $server),
                        'update'    => Gate::check('server-update', $server),
                    ])
                }}"
        ></server-tasks>
    </div>
</div>
