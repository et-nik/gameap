<p align="center"><strong>{{ Auth::user()->name }}</strong></p>

<p align="center"><strong>Profile</strong></p>
<ul class="page-sidebar-menu">
    <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i>&nbsp;View profile</a></li>
</ul>

<p align="center"><strong>Support</strong></p>
<ul class="page-sidebar-menu">
    <li><a target="blank" href="http://forum.gameap.ru"><i class="fa fa-comment"></i>&nbsp;Forum</a></li>
    <li><a target="blank" href="http://docs.gameap.ru"><i class="fa fa-wikipedia-w"></i>&nbsp;Documentation</a></li>
</ul>
