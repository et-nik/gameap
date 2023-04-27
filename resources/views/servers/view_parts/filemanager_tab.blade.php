<div class="row mt-2">
    <div class="col-md-12">
        <div class="card p-2">
            <file-manager
                    v-if="activeTab === 'filemanager'"
                    :settings="{{ json_encode([
                    'baseUrl' => url('file-manager/'.$server->id),
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                ]) }}"
            />
        </div>
    </div>
</div>
