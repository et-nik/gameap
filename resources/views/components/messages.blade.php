@if ($message = Session::get('notification'))
    <n-alert title="{{ __('main.info') }}" type="info" class="mb-2">
        {{ $message }}
    </n-alert>
@endif

@if ($message = Session::get('success'))
    <n-alert title="{{ __('main.success') }}" type="success" class="mb-2">
        {{ $message }}
    </n-alert>
@elseif ($message = Session::get('error'))
    <n-alert title="{{ __('main.error') }}" type="error" class="mb-2">
        {{ $message }}
    </n-alert>
@endif
