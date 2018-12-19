<p align="center"><strong>{{ Auth::user()->name }}</strong></p>

<p align="center"><strong>{{ __('sidebar.profile') }}</strong></p>
<ul class="page-sidebar-menu">
    <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i>&nbsp;{{ __('sidebar.view_profile') }}</a></li>
</ul>

<p align="center"><strong>{{ __('sidebar.support') }}</strong></p>
<ul class="page-sidebar-menu">
    <li><a target="blank" href="http://docs.gameap.ru"><i class="fab fa-wikipedia-w"></i>&nbsp;{{ __('home.documentation') }}</a></li>
</ul>
