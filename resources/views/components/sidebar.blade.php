<p align="center"><strong>{{ Auth::user()->name }}</strong></p>

<p align="center"><strong>Profile</strong></p>
<ul class="page-sidebar-menu">
    <li><a href="{{ route('profile') }}"><span class="fa fa-user"></span>&nbsp;View profile</a></li>
</ul>

<p align="center"><strong>Support</strong></p>
<ul class="page-sidebar-menu">
    <li><a target="blank" href="http://forum.gameap.ru"><span class="fa fa-comment"></span>&nbsp;Forum</a></li>
    <li><a target="blank" href="http://docs.gameap.ru"><span class="fa fa-wikipedia-w"></span>&nbsp;Documentation</a></li>
</ul>
