<nav id="top-menu" class="relative flex flex-wrap items-center content-between py-3 px-4  text-white top-0 bg-black">
    <a id="brand-link" class="inline-block pt-1 pb-1 mr-4 text-lg whitespace-no-wrap" href="/">
        <img id="brand-logo" src="{{ URL::asset('/images/gap_logo_white.png') }}" class="logo" alt="GameAP" />
    </a>

    <button class="py-1 px-2 text-md leading-normal bg-transparent border border-transparent rounded" type="button" data-bs-toggle="collapse" data-bs-target="#left-menu" aria-controls="left-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="px-5 py-1 border border-gray-600 rounded"></span>
    </button>

    <div class="hidden flex-grow items-center bg-black" id="navbarSupportedContent">
        <ul class="flex flex-wrap list-reset pl-0 mb-0 me-auto">
            <li class=""><a class="inline-block py-2 px-4 no-underline" href="{{ route('home') }}">{{ __('navbar.main') }}</a></li>
            @can('admin roles & permissions')
                <li class=" relative">
                    <a href="#" class="inline-block py-2 px-4 no-underline  inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1" data-bs-toggle="dropdown">{{ __('navbar.admin') }}<span class="caret"></span></a>
                    <ul class=" absolute left-0 z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-gray-300 rounded">
                        <li class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"><a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('admin.dedicated_servers.index') }}">{{ __('navbar.dedicated_servers') }}</a></li>
                        <li class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"><a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('admin.servers.index') }}">{{ __('navbar.game_servers') }}</a></li>
                        <li class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"><a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('admin.games.index') }}">{{ __('navbar.games') }}</a></li>
                        <li class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"><a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('admin.gdaemon_tasks.index') }}">{{ __('navbar.gdaemon_tasks') }}</a></li>
                    </ul>
                </li>

                <li class=" relative">
                    <a href="#" class="inline-block py-2 px-4 no-underline  inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1" data-bs-toggle="dropdown">{{ __('navbar.users') }}<span class="caret"></span></a>
                    <ul class=" absolute left-0 z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-gray-300 rounded">
                        <li class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"><a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('admin.users.index') }}">{{ __('navbar.users') }}</a></li>
                        <li class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0"><a class="block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0" href="{{ route('admin.users.create') }}">{{ __('navbar.add_user') }}</a></li>
                    </ul>
                </li>
            @endcan
        </ul>

        <ul class="flex flex-wrap list-reset pl-0 mb-0 me-3">
            <li class=" me-1">
                <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-gray-900 text-white hover:bg-gray-900 navbar-btn" href="{{ route('profile') }}"><i class="fas fa-user"></i>&nbsp;{{ Auth::user()->name }}</a>
            </li>

            <li class="">
                {{ Form::open(['id' => 'logout-form', 'url' => route('logout'), 'style'=>'display:inline']) }}
                    {{ csrf_field() }}
                    {{ Form::button( '<i class="fas fa-sign-out-alt"></i>&nbsp;' . __('navbar.sign_out') ,
                    [
                        'class' => 'btn btn-danger navbar-btn',
                        'v-on:click' => $destroyConfirmAction
                            ?? 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                        'type' => 'submit'
                    ]
                    ) }}
                {{ Form::close() }}
            </li>
        </ul>
    </div>
</nav>
