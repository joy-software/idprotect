<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{-- asset('css/app.css') --}}" rel="stylesheet">
    <link href="{{ asset('css/bulma.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <div class="container">
        <!--nav class="navbar navbar-default navbar-static-top"-->
        <nav class="nav">
            <div class="nav-left">
                <a class="nav-item" href="{{ url('/') }}">
                    <!-- Branding Image -->
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="nav-center">
                <a class="nav-item">
                  <span class="icon">
                    <i class="fa fa-github"></i>
                  </span>
                </a>
                <a class="nav-item">
                  <span class="icon">
                    <i class="fa fa-twitter"></i>
                  </span>
                </a>
            </div>

            <!-- This "nav-toggle" hamburger menu is only visible on mobile -->
            <!-- You need JavaScript to toggle the "is-active" class on "nav-menu" -->
            <span class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </span>

            <!-- This "nav-menu" is hidden on mobile -->
            <!-- Add the modifier "is-active" to display it on mobile -->
            <div class="nav-right nav-menu">
                <a class="nav-item">
                    @lang('menu.home')
                </a>
                <a class="nav-item">
                    @lang('menu.documentation')
                </a>
                <a class="nav-item">
                    @lang('menu.blog')
                </a>

                <div class="nav-item">
                    <div class="field is-grouped">
                        @if (Auth::guest())
                            <a href="{{ route('login') }}" class="nav-item"> @lang('menu.login')</a>
                            <a href="{{ route('register') }}" class="nav-item"> @lang('menu.register')</a>
                        @else
                        <!-- Dropdown with two heading -->
                            <div class="has-dropdown">
                                <input type="checkbox" id="ch1">   <!-- note: id -->
                                <label class="button is-medium" for="ch1">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </label>  <!-- note: for -->

                                <div class="dropdown box">
                                    <ul>
                                        <!--li><a>Action 1</a></li-->
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                @lang('menu.logout')
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>

            </div>




        </nav>

    </div>
        <section class="hero is-primary" id="hero_hero">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-vcentered" >
                        <div class="column">
                            <p class="title">
                                @lang('menu.hero_title')
                            </p>
                            <p class="subtitle">
                               @lang('menu.hero_message')
                            </p>
                        </div>
                        <div class="column is-narrow">
                            <div id="carbon" class="box">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-foot">
                <div class="container">
                       <search name="@lang('menu.hero_search_placeholder')"
                               url="{{url(App::getLocale())}}"
                               error="@lang('menu.hero_search_error')"
                               keywords="@lang('validation.custom.keywords.required')"
                       >@lang('menu.hero_search_button')</search>
                </div>

            </div>

        </section>
        <!--nav class="nav has-shadow">
            <div class="container">
                <div class="nav-center">
                    <a class="nav-item is-tab is-active" href="">
                        @lang('menu.nav_search_result_all')
                    </a>
                    <a class="nav-item is-tab " href="">
                        @lang('menu.nav_search_result_social')
                    </a>
                    <a class="nav-item is-tab " href="">
                        @lang('menu.nav_search_result_document')
                    </a>
                    <a class="nav-item is-tab" href="">
                        @lang('menu.nav_search_result_site')
                    </a>
                    <a class="nav-item is-tab " href="">
                        @lang('menu.nav_search_result_image')
                    </a>
                    <a class="nav-item is-tab" href="">
                        @lang('menu.nav_search_result_video')
                    </a>
                </div>
            </div>
        </nav>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <!!-- Le div de gauche --!!>
                    <div class="column is-one-quarter">
                        <code class="html">is-one-quarters</code>
                    </div>
                    <!!-- The div where the result will be shown --!!>
                    <div class="column is-half">
                        <div class="card">
                            <div class="card-content">
                                <div class="media">
                                    <!--div class="media-left ">
                                        <figure class="image is-48x48">
                                            <img src="http://bulma.io/images/placeholders/96x96.png" alt="Image">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-3">John Smith</p>
                                        <p class="subtitle is-6">@johnsmith</p>
                                    </div>
                                </div>

                                <div class="content">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                                    <a>#css</a> <a>#responsive</a>
                                    <br>
                                    <small>11:09 PM - 1 Jan 2016</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!!-- The where we will pull information over the validator --!!>
                    <div class="column">
                        <code class="html">auto</code>
                    </div>
                </div>
            </div>
        </section-->

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
