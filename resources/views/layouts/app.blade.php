<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">

        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="x-ua-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <link rel="shortcut icon" href="">

        <meta name="theme-color" content="#3c8dbc">
        <meta name="msapplication-navbutton-color" content="#3c8dbc">
        <meta name="apple-mobile-web-app-status-bar-style" content="#3c8dbc">
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    <link href="/css/app.31fea6640a2972fa8a94eadf88612e5c.css" rel="stylesheet"></head>
    <body style="background-color: #3c8dbc">
        <div id="app" style="min-height: 100vh; text-align: center; position: relative">
            <div style="background-color: #3c8dbc !important; color: white; font-family: Roboto; position:absolute; top: 230px; margin-top:-90px; width: 100%">
                <img src="/images/loading.svg" style="width: 100px; height: 100px">
                <div style="text-align: center; font-size: 20px; margin-top: 5px">Загрузка...</div>
                <div id="loading-message" style="display: none; width: 250px; margin: auto; font-size: 14px; margin-top: 10px">
                    <span style="font-size: 16px; font-weight: bold">Не загружается страница?</span>
                    <div style="padding-top: 5px">
                        <span class="hints">Загрузка сайта может занять от 5 до 10 секунд, в зависимости от скорости вашего соединения с сетью Интернет</span>
                        <span class="hints" style="display: none">Попробуйте посетить наш сайт с другого браузера или обновить Ваш текущий.</span>
                        <span class="hints" style="display: none">Возможно у Вас нестабильное соединение с сетью Интернет</span>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var pick = 0;
            setTimeout(function() {
                var message = document.getElementById('loading-message');
                if (message) {
                    var changehints = setInterval(function () {
                        var hints = document.getElementsByClassName('hints');
                        if (hints.length) {
                            if (pick == hints.length)
                                pick = 0;
                            for (var i = 0; i < hints.length; i++)
                                hints[i].style.display = 'none';
                            hints[pick].style.display = 'inline';
                            pick++;
                        } else {
                            clearInterval(changehints);
                        }
                    }, 8000);
                    message.style.display = 'block';
                }
            }, 5000);
        </script>
    <script type="text/javascript" src="/js/manifest.50d36b6de0cb7c43e17f.js"></script><script type="text/javascript" src="/js/vendor.93941689d742845cb48d.js"></script><script type="text/javascript" src="/js/app.8ed0304a85c7555c2ec2.js"></script></body>
</html>
