<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} | {{title_case(trans('menu.login'))}}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{ asset('css/bulma.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">


    <link rel="shortcut icon" href={!! url('img/logo.png') !!}>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div class="login-wrapper columns">
    <div class="column is-8 is-hidden-mobile hero-banner">
        <section class="hero is-fullheight is-dark">
            <div class="hero-body">
                <div class="container section">
                    <div class="has-text-right">
                        <h1 class="title is-1">@lang('menu.login')</h1> <br>
                        <p class="title is-3">@lang('messages.login1')</p><br>
                        <p class="title is-3">@lang('messages.login2')</p><br>
                        <p class="title is-3">@lang('messages.login3')</p>
                    </div>
                </div>
            </div>
            <div class="hero-footer">
                <p class="has-text-centered">Image © IDProtect - 2017 - NDJAMA Joy</p>
            </div>
        </section>
    </div>
    <div class="column  is-4" id="app">
        <section class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns">
                        <div class="column is-8 is-offset-2" >
                                <lang french="{{url('img/french.png')}}"
                                    english="{{url('img/britain.png')}}"
                                    url="{{url('')}}"
                                    current="{{config('app.locale')}}"
                                    route="LoginLang">
                                </lang>

                            <h1 class="avatar has-text-centered" style="margin:auto">
                                <figure class="image is-128x128" style="margin:auto">
                                    <img src="{{url('img/web2.png')}}">
                                </figure>
                            </h1>
                            @if(Session::has('message'))
                                <alert classe="is-{{ Session::get('status') }}" text_close=false style="margin-top: 10px">
                                    {{ Session::get('message') }}
                                </alert>
                            @endif
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                            <div class="login-form">
                                <div class="field {{ $errors->has('email') ? 'is-danger' : '' }}">
                                    <p class="control has-icon has-icon-right">
                                        <input class="input email-input" placeholder="jsmith@example.org" id="email" type="email"  name="email" value="{{ old('email') }}" required autofocus>
                                        <span class="icon user">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    </p>
                                    @if ($errors->has('email'))
                                        <span class="help">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="field {{  $errors->has('password') ? 'is-danger' : '' }}">
                                    <p class="control has-icon has-icon-right">
                                        <input class="input password-input" type="password" placeholder="●●●●●●●" id="password"  name="password" required>
                                        <span class="icon user">
                                        <i class="fa fa-lock"></i>
                                     </span>
                                    </p>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="field">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('messages.login4')
                                        </label>
                                    </div>
                                    <p class="has-text-centered forgot-password is-pulled-right">
                                        <a href="{{ route('register') }}">@lang('messages.login7')?</a>
                                    </p>
                                </div>

                                <p class="control login">
                                    <button class="button is-success is-outlined is-large is-fullwidth" type="submit">@lang('menu.login')</button>
                                </p>
                            </div>
                                <hr>
                                <p class="blue"><strong>@lang('messages.login5')</strong></p>

                                <p>
                                    <a href="{{ url('/auth/facebook') }}" class="btn"><i class="fa fa-facebook-f fa-lg"></i></a>
                                    <a href="{{ url('/auth/twitter') }}" class="btn"><i class="fa fa-twitter fa-lg"></i></a>
                                    <a href="{{ url('/auth/google') }}" class="btn"><i class="fa fa-google-plus fa-lg"></i></a>
                                    <a href="{{ url('/auth/github') }}" class="btn"><i class="fa fa-github fa-lg"></i></a>
                                </p>

                                <hr>
                            <div class="forgot-password">
                                <p class="has-text-centered">
                                    <a href="{{ route('password.request') }}">@lang('messages.login6')?</a>
                                </p>

                                    <p class="has-text-centered">
                                        <a href="{{ url('/'.config('app.locale').'/activation/resend') }}">@lang('messages.login8')?</a>
                                    </p>


                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
