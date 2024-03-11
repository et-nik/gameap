{{--
/**
* @var \Gameap\Models\Server $server
**/
--}}

<div class="flex flex-wrap  mt-2">
    <div class="md:w-full pr-4 pl-4">
        <server-tasks
                v-if="activeTab === 'schedules'"
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
