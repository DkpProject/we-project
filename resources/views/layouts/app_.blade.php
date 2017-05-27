@section('title', 'аренда и продажа ненужных вещей')
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=600, initial-scale=0.6">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if( Request::is( Config::get('chatter.routes.home')) )
            <title>Форум специалистов -  {{ config('app.name', 'Laravel') }}</title>
        @elseif( Request::is( Config::get('chatter.routes.home') . '/*' ) && isset($discussion->title))
            <title>{{ $discussion->title }} - {{ config('app.name', 'Laravel') }}</title>
        @else
            <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
        @endif
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&subset=cyrillic" rel="stylesheet">
        <link href="/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/jquery.formstyler.css" rel="stylesheet">
        <link href="/css/styles.css" rel="stylesheet">
        <link href="/css/select2.min.css" rel="stylesheet">
        <link href="/css/select2-bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.formstyler.js"></script>
        <script src="/js/jquery.maskedinput.js"></script>
        <script src="/js/select2.min.js"></script>
        <script src="/js/i18n/ru.js"></script>
        <script src="/js/main.js"></script>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script>
            window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        @yield('css')
    </head>
    <body>
        <nav id="menu">
                <div class="gr">
                    <div class="sidebar-content" style="height: 100%;">
                        @if (Auth::guest())
                            <div class="left-nav">
                                <ul>
                                    <a href="{{ url('/login') }}">
                                        <li>Авторизация</li>
                                    </a>
                                    <a href="{{ url('/register-rules') }}">
                                        <li>Регистрация</li>
                                    </a>
                                </ul>
                            </div>
                        @else
                            <div class="sidebar-user">
                                <div class="user-avatar">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="user-name dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->firstname }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            @if(config('project.enableCatalog'))
                                                <a href="{{ url('/catalog/add') }}">Добавить товар</a>
                                            @endif
                                            @if(config('project.enableService'))
                                                <a href="{{ url('/service/add') }}">Добавить услугу</a>
                                            @endif
                                            <a href="{{ url('/profile') }}">Профиль</a>
                                            <a href="{{ url('/logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="left-nav">
                                <ul>
                                    <a href="/profile">
                                        <li>Профиль</li>
                                    </a>
                                    <a href="/chat">
                                        <?php $newMessage = \App\Models\Message::where('to', Auth::user()->id)->where('read', 0)->groupBy('from')->get();?>
                                        <li>Личные сообщения @if(count($newMessage)) <span class="badge badge-info">+{{count($newMessage)}}</span>@endif</li>
                                    </a>
                                    @if(config('project.enableCatalog'))
                                        <a href="/profile/goods">
                                            <li>Мои товары</li>
                                        </a>
                                    @endif
                                    @if(config('project.enableService'))
                                        <a href="/profile/services">
                                            <li>Мои услуги</li>
                                        </a>
                                    @endif
                                    <a href="/profile/team">
                                        <li>Моя команда</li>
                                    </a>
                                    @if(config('project.enableCatalog'))
                                        <a href="/catalog">
                                            <li>Каталог товаров</li>
                                        </a>
                                    @endif
                                    @if(config('project.enableService'))
                                        <a href="/service">
                                            <li>Каталог услуг</li>
                                        </a>
                                    @endif
                                    <a href="/forum">
                                        <li>Обсуждения</li>
                                    </a>
                                    <a href="/polls">
                                        <li>Опросы</li>
                                    </a>
                                    <a href="/wishes">
                                        <li>Список желаний</li>
                                    </a>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </nav>

            <div id="panel">
                <div class="col-lg-5 col-md-5 gr">
                    <a href="{{ url('/') }}" class="logo link">
                        {{ config('app.name', 'Laravel') }}
                        <br>
                        <span style="font-size: 12px;">Мой вклад - Мои возможности</span>
                    </a>
                    <div class="sidebar-content hidden-sm hidden-xs">
                        @if (Auth::guest())
                            <div class="left-nav">
                                <ul>
                                    <a href="{{ url('/login') }}">
                                        <li>Авторизация</li>
                                    </a>
                                    <a href="{{ url('/register-rules') }}">
                                        <li>Регистрация</li>
                                    </a>
                                </ul>
                            </div>
                        @else
                            <div class="sidebar-user">
                                <div class="user-avatar">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="user-name dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->firstname }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            @if(config('project.enableCatalog'))
                                                <a href="{{ url('/catalog/add') }}">Добавить товар</a>
                                            @endif
                                            @if(config('project.enableService'))
                                                <a href="{{ url('/service/add') }}">Добавить услугу</a>
                                            @endif
                                            <a href="{{ url('/profile') }}">Профиль</a>
                                            <a href="{{ url('/logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="left-nav">
                                <ul>
                                    <a href="/profile">
                                        <li>Профиль</li>
                                    </a>
                                    <a href="/chat">
                                        <li>Личные сообщения @if(count($newMessage)) <span class="badge badge-info">+{{count($newMessage)}}</span>@endif</li>
                                    </a>
                                    @if(config('project.enableCatalog'))
                                        <a href="/profile/goods">
                                            <li>Мои товары</li>
                                        </a>
                                    @endif
                                    @if(config('project.enableService'))
                                        <a href="/profile/services">
                                            <li>Мои услуги</li>
                                        </a>
                                    @endif
                                    <a href="/profile/team">
                                        <li>Моя команда</li>
                                    </a>
                                    @if(config('project.enableCatalog'))
                                        <a href="/catalog">
                                            <li>Каталог товаров</li>
                                        </a>
                                    @endif
                                    @if(config('project.enableService'))
                                        <a href="/service">
                                            <li>Каталог услуг</li>
                                        </a>
                                    @endif
                                    <a href="/forum">
                                        <li>Обсуждения</li>
                                    </a>
                                    <a href="/polls">
                                        <li>Опросы</li>
                                    </a>
                                    <a href="/wishes">
                                        <li>Список желаний</li>
                                    </a>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-19 col-md-19 gr">
                    <div class="search">
                        <div class="row" style="margin: 0;">
                            <div class="col-xs-3 gr menu-button hidden-lg hidden-md">
                                <a href="javascript://" class="link"><i class="fa fa-bars toggle-button" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-xs-18 col-md-21 gr search-panel">
                                <input type="text" class="search-query" tabindex="-1" placeholder="Мы найдем то, что Вам нужно!" autocomplete="off">
                                <i class="fa fa-spinner fa-pulse search-loading"></i>
                                <div class="search-result-container hide">
                                    <div class="search-result">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 gr add-button hidden-lg">
                                <a href="{{ url('/catalog/add') }}" class="link"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="add hidden-md hidden-sm hidden-xs">
                                <a class="topbutton" href="{{ url('/catalog/add') }}">Добавить</a>
                            </div>
                        </div>
                    </div>
                    <div class="page">
                        @if (session('status'))
                            <div class="alert alert-{{ session('type') }}">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ session('status') }}
                            </div>
                        @endif

                        @yield('content')
                    </div>
                    <footer>
                        <a href="/user-agreement">Пользовательское соглашение</a><br>
                        <a href="/additional-agreements">Дополнительные соглашения</a><br>
                        Все права защищены. Проект «Мы» © {{date("Y")}}.
                    </footer>
                </div>
            @if (!Auth::guest())
                <!--div class="col-lg-5 col-md-19 col-sm-24 col-sx-24 col-lg-offset-0 col-md-offset-5 gr">
                <div class="add hidden-md hidden-sm hidden-xs">
                    <a class="topbutton" href="/catalog/add">Добавить</a>
                </div>
                <div class="rightbar">
                    <div class="right-title">
                        Популярные товары
                    </div>
                    <div class="row">
                        <div class="col-lg-24 col-md-6 col-sm-6 col-xs-12">
                            <div class="r-good-card">
                                <img class="img-responsive" src="/img/test.jpg">
                                <div class="r-good-title"><a href="#">Apple iPhone 6s</a></div>
                                <div class="r-good-price">10000 р.</div>
                            </div>
                        </div>
                        <div class="col-lg-24 col-md-6 col-sm-6 col-xs-12">
                            <div class="r-good-card">
                                <img class="img-responsive" src="/img/test.jpg">
                                <div class="r-good-title"><a href="#">Apple iPhone 6s</a></div>
                                <div class="r-good-price">10000 р.</div>
                            </div>
                        </div>
                        <div class="col-lg-24 col-md-6 col-sm-6 col-xs-12">
                            <div class="r-good-card">
                                <img class="img-responsive" src="/img/test.jpg">
                                <div class="r-good-title"><a href="#">Apple iPhone 6s</a></div>
                                <div class="r-good-price">10000 р.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div-->
                @endif

                @if(config('project.bugTracker'))
                    <div class="bug block">
                        <i class="fa fa-bug fa-2x pull-left"></i>
                        <div class="bug tracker">
                            <form method="post" action="">
                                <input name="page" value="{{Request::getRequestUri()}}" type="hidden">
                                <textarea name="problem" class="styler" placeholder="Опишите свою проблему..."></textarea>
                                <span class="pull-right success hide mgt10" style="color: limegreen; margin-top: 12px;">Сообщение успешно отправлено!</span>
                                <span class="pull-right error hide" style="color: red; margin-top: 12px;">Сообщение должно быть более 5 символов!</span>
                                <input name="button" value="Отправить сообщение" class="btn btn-primary std" type="button">
                            </form>
                        </div>
                    </div>
                @endif

                <script src="https://cdnjs.cloudflare.com/ajax/libs/slideout/0.1.12/slideout.min.js"></script>
                <script src="/js/jquery.stickit.js"></script>
                <script src="/js/searchbox.js"></script>
                <script>
                    $('.bug.block i.fa-bug').on('click', function () {
                        if ($('.bug.block').css('bottom') == "0px") {
                            $('.bug.block').css('bottom', "-141px");
                        } else {
                            $('.bug.block').css('bottom', 0);
                        }
                    });
                    $('.bug.tracker input[type="button"]').click(function () {
                        var problem = $('.bug.tracker textarea').val();
                        var page = $('.bug.tracker input[name="page"]').val();
                        $.post('/ajax/bugtracker', { page: page, descr: problem, _token: "{{csrf_token()}}" }, function (data) {
                            if (data == "ok") {
                                $('.bug.tracker input[type="button"]').attr('disabled', true);
                                $('.bug.tracker .success').removeClass('hide');
                            } else {
                                $('.bug.tracker .error').removeClass('hide');
                            }
                        });
                    });
                    $('.sidebar-content').stickit({scope: StickScope.Document, top: 0});
                    var slideout = new Slideout({
                        'panel': document.getElementById('panel'),
                        'menu': document.getElementById('menu'),
                        'padding': 256,
                        'tolerance': 70
                    });
                    $('.toggle-button').on('click', function () {
                        slideout.toggle();
                    });
                    $('input.search-query').searchbox({
                        url: '/ajax/search',
                        param: 'query',
                        dom_id: '.search-result',
                        delay: 500,
                        loading_css: '.search-loading'
                    });
                </script>
        @yield('js')
    </body>
</html>