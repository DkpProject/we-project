@section('title', 'Авторизация')
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=600, initial-scale=0.6">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--@if( Request::is( Config::get('chatter.routes.home')) )--}}
            {{--<title>Форум специалистов -  {{ config('app.name', 'Laravel') }}</title>--}}
        {{--@elseif( Request::is( Config::get('chatter.routes.home') . '/*' ) && isset($discussion->title))--}}
            {{--<title>{{ $discussion->title }} - {{ config('app.name', 'Laravel') }}</title>--}}
        {{--@else--}}
            {{--<title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>--}}
        {{--@endif--}}
        {{--<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&subset=cyrillic" rel="stylesheet">--}}
        {{--<link href="/css/font-awesome.min.css" rel="stylesheet">--}}
        {{--<link href="/css/bootstrap.min.css" rel="stylesheet">--}}
        {{--<link href="/css/jquery.formstyler.css" rel="stylesheet">--}}
        {{--<link href="/css/styles.css" rel="stylesheet">--}}
        {{--<link href="/css/select2.min.css" rel="stylesheet">--}}
        {{--<link href="/css/select2-bootstrap.min.css" rel="stylesheet">--}}
        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
        {{--<script src="/js/bootstrap.min.js"></script>--}}
        {{--<script src="/js/jquery.formstyler.js"></script>--}}
        {{--<script src="/js/jquery.maskedinput.js"></script>--}}
        {{--<script src="/js/select2.min.js"></script>--}}
        {{--<script src="/js/i18n/ru.js"></script>--}}
        {{--<script src="/js/main.js"></script>--}}
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href=/css/app.31fea6640a2972fa8a94eadf88612e5c.css rel=stylesheet>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @yield('css')
</head>
<body>
<div class="wrapper">
    <div id="content">
        <div class="color-sep"></div>
        <div class="content">
            <div class="row">
                <div class="col-xxl-8 offset-xxl-8 col-xl-10 offset-xl-7 col-lg-10 offset-lg-7 col-md-12 offset-md-6 col-sm-18 offset-sm-3">
                    <div class="login-page">
                        <div class="header acenter">
                            Авторизация на сайт
                        </div>
                        <form action="/login" method="POST">
                            {{csrf_field()}}
                            <div class="login">
                                <span class="input input-filled">
                                    <input class="input-field" type="text" name="email" required/>
                                    <label class="input-label">
                                        <span class="input-label-content">E-mail</span>
                                    </label>
                                </span>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="password">
                                <span class="input input-filled">
                                    <input class="input-field" type="password" name="password" required/>
                                    <label class="input-label">
                                        <span class="input-label-content">Пароль</span>
                                    </label>
                                </span>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="actions">
                                <button class="btn btn-primary pull-right" type="submit">Авторизоваться</button>
                                <a href="/recovery">Восстановление аккаунта</a>
                                <br>
                                <a href="/register-rules">Регистрация</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="row rules">
                <div class="aright">
                    <a href="/user-agreement">Пользовательское соглашение</a>
                </div>
                <div class="sep"></div>
                <div>
                    <a href="/faq">Часто задаваемые вопросы</a>
                </div>
            </div>
            <div class="row copyright">
                <div>Все права защещены. ДКП &laquo;Мы&raquo; &copy; 2017</div>
            </div>
        </footer>
    </div>
    </div>
</div>
</body>
</html>
