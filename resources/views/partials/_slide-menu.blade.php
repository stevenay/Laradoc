<nav id="slide-menu" class="slide-menu" role="navigation">

    <div class="brand">
        <a href="/">
            <img src="{{ asset('/img/laravel-logo-white.png') }}" height="50">
        </a>
    </div>

    <ul class="slide-main-nav">
        <li><a href="/">Home</a></li>
        <li class="nav-docs"><a href="/docs">Documentation</a></li>
        <li class="nav-laracasts"><a href="https://laracasts.com">Laracasts</a></li>
        <li class="nav-lumen"><a href="http://lumen.laravel.com">Lumen</a></li>
        <li class="nav-forge"><a href="https://forge.laravel.com">Forge</a></li>
        <li class="nav-envoyer"><a href="https://envoyer.io">Envoyer</a></li>
        <li class="nav-api"><a href="/api/5.0">API</a></li>
        <li class="dropdown community-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Conference <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="http://laracon.us">Laracon US</a></li>
                <li><a href="http://laracon.eu">Laracon EU</a></li>
            </ul>
        </li>
        <li class="dropdown community-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Community <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="https://github.com/laravel/laravel">GitHub</a></li>
                <li><a href="https://twitter.com/laravelphp">Twitter</a></li>
                <li class="divider"></li>
                <li><a href="https://laracasts.com/discuss">Laracasts Forums</a></li>
                <li><a href="http://laravel.io/forum">Laravel.io Forums</a></li>
                <li><a href="http://larachat.co">LaraChat Slack Channel</a></li>
                <li><a href="https://laravel-news.com/">Laravel News</a></li>
                <li><a href="http://www.laravelpodcast.com/">Laravel Podcast</a></li>
                <li class="divider"></li>
                <li><a href="http://laravelcollective.com">Laravel Collective</a></li>
                <li class="divider"></li>
                <li><a href="https://larajobs.com/?partner=5#/">LaraJobs</a></li>
            </ul>
        </li>
    </ul>

    <div class="slide-docs-nav">
        <h2>Documentation</h2>
        <ul>
            <li>Prologue
                <ul>
                    <li><a href="/docs/5.0/releases">Release Notes</a></li>
                    <li><a href="/docs/5.0/upgrade">Upgrade Guide</a></li>
                    <li><a href="/docs/5.0/contributions">Contribution Guide</a></li>
                </ul>
            </li>
            <li>Setup
                <ul>
                    <li><a href="/docs/5.0/installation">Installation</a></li>
                    <li><a href="/docs/5.0/configuration">Configuration</a></li>
                    <li><a href="/docs/5.0/homestead">Homestead</a></li>
                </ul>
            </li>
            <li>The Basics
                <ul>
                    <li><a href="/docs/5.0/routing">Routing</a></li>
                    <li><a href="/docs/5.0/middleware">Middleware</a></li>
                    <li><a href="/docs/5.0/controllers">Controllers</a></li>
                    <li><a href="/docs/5.0/requests">Requests</a></li>
                    <li><a href="/docs/5.0/responses">Responses</a></li>
                    <li><a href="/docs/5.0/views">Views</a></li>
                </ul>
            </li>
            <li>Architecture Foundations
                <ul>
                    <li><a href="/docs/5.0/providers">Service Providers</a></li>
                    <li><a href="/docs/5.0/container">Service Container</a></li>
                    <li><a href="/docs/5.0/contracts">Contracts</a></li>
                    <li><a href="/docs/5.0/facades">Facades</a></li>
                    <li><a href="/docs/5.0/lifecycle">Request Lifecycle</a></li>
                    <li><a href="/docs/5.0/structure">Application Structure</a></li>
                </ul>
            </li>
            <li>Services
                <ul>
                    <li><a href="/docs/5.0/authentication">Authentication</a></li>
                    <li><a href="/docs/5.0/billing">Billing</a></li>
                    <li><a href="/docs/5.0/cache">Cache</a></li>
                    <li><a href="/docs/5.0/collections">Collections</a></li>
                    <li><a href="/docs/5.0/bus">Command Bus</a></li>
                    <li><a href="/docs/5.0/extending">Core Extension</a></li>
                    <li><a href="/docs/5.0/elixir">Elixir</a></li>
                    <li><a href="/docs/5.0/encryption">Encryption</a></li>
                    <li><a href="/docs/5.0/envoy">Envoy</a></li>
                    <li><a href="/docs/5.0/errors">Errors &amp; Logging</a></li>
                    <li><a href="/docs/5.0/events">Events</a></li>
                    <li><a href="/docs/5.0/filesystem">Filesystem / Cloud Storage</a></li>
                    <li><a href="/docs/5.0/hashing">Hashing</a></li>
                    <li><a href="/docs/5.0/helpers">Helpers</a></li>
                    <li><a href="/docs/5.0/localization">Localization</a></li>
                    <li><a href="/docs/5.0/mail">Mail</a></li>
                    <li><a href="/docs/5.0/packages">Package Development</a></li>
                    <li><a href="/docs/5.0/pagination">Pagination</a></li>
                    <li><a href="/docs/5.0/queues">Queues</a></li>
                    <li><a href="/docs/5.0/session">Session</a></li>
                    <li><a href="/docs/5.0/templates">Templates</a></li>
                    <li><a href="/docs/5.0/testing">Unit Testing</a></li>
                    <li><a href="/docs/5.0/validation">Validation</a></li>
                </ul>
            </li>
            <li>Database
                <ul>
                    <li><a href="/docs/5.0/database">Basic Usage</a></li>
                    <li><a href="/docs/5.0/queries">Query Builder</a></li>
                    <li><a href="/docs/5.0/eloquent">Eloquent ORM</a></li>
                    <li><a href="/docs/5.0/schema">Schema Builder</a></li>
                    <li><a href="/docs/5.0/migrations">Migrations &amp; Seeding</a></li>
                    <li><a href="/docs/5.0/redis">Redis</a></li>
                </ul>
            </li>
            <li>Artisan CLI
                <ul>
                    <li><a href="/docs/5.0/artisan">Overview</a></li>
                    <li><a href="/docs/5.0/commands">Development</a></li>
                </ul>
            </li>
        </ul>
    </div>

</nav>