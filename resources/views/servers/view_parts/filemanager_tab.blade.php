<div class="row mt-2">
    <div class="col-md-12">
        <file-manager
                :settings="{{ json_encode([
                    'baseUrl' => url('file-manager/'.$server->id),
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                ]) }}"
        />
    </div>
</div>
