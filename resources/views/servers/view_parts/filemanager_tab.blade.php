<div class="flex flex-wrap  mt-2">
    <div class="md:w-full pr-4 pl-4">
        <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 p-2">
            <file-manager
                    v-if="activeTab === 'filemanager'"
                    :settings="{{ json_encode([
                    'baseUrl' => url('file-manager/'.$server->id).'/',
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'lang' => (app()->getLocale() ?? app()->getFallbackLocale()),
                ]) }}"
            />
        </div>
    </div>
</div>
