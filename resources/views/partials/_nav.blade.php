<nav class="main">
    <div class="container">
        <a href="/" class="brand">
            <img src="{!! asset('img/laravel-logo.png') !!}" height="30" alt="Laravel logo">
            Laradoc
        </a>

        <div class="responsive-sidebar-nav">
            <a href="#" class="toggle-slide menu-link btn">☰</a>
        </div>

        <div class="switcher">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    5.0
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="http://laravel.com/docs/master/elixir">Master</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="http://laravel.com/docs/5.0/elixir">5.0</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="http://laravel.com/docs/4.2/elixir">4.2</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="http://laravel.com/docs/4.1/elixir">4.1</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="http://laravel.com/docs/4.0/elixir">4.0</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="main-nav">
            <li class="nav-docs"><a href="{{ url('/documents') }}">Documentation</a></li>

            @if (Auth::guest())
                <li><a href="{{ url('/auth/login') }}">Login</a></li>
                <li><a href="{{ url('/auth/register') }}">Register</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Manage <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ action('DocumentsController@create') }}">New Document</a></li>
                        <li><a href="{{ action('CategoriesController@create') }}">New Category</a></li>
                        <li><a href="{{ url('categories') }}">List Category</a></li>
                        <li><a href="{{ action('DocumentsController@sync') }}">Sync Documents</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</nav>
