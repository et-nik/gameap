<div class="row mt-2">
    <div class="col-12">
        <server-tasks v-if="activeTab === 'schedules'" :server-id="{{ $server->id }}"></server-tasks>
    </div>
</div>