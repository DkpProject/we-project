<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Мы - удобное место аренды и продажи ненужных вещей</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/ionicons.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400|Roboto:300,400,500,700&subset=cyrillic" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
  <section class="overlay">
	<div class="close-button"><a href="/home"><i class="ion-ios-close-empty"></i></a></div>
	<div class="title"><strong>Мы</strong> найдем то, что Вам нужно!</div>
	<div class="left" id="left"><div class="big-button" id="goods"><div class="icon"><i class="fa fa-balance-scale" aria-hidden="true"></i></div><div class="subtitle">Товары</div></div></div>
	<div class="right" id="right"><div class="big-button"><div class="icon"><i class="fa fa-briefcase" aria-hidden="true"></i></div><div class="subtitle">Услуги</div></div></div>
	<div class="search"><input type="text" class="search-query" placeholder="или просто укажите, что хотите найти"></div>
	<div class="skip"><a class="a-skip" href="/home">Перейти к полной версии</a></div>
	<div>&nbsp;</div>
  </section>
	
  <script src="js/jquery-3.1.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
	$('#left').click(function() {
		$('#left').html('<div class="left-button"><div class="icon"><i class="fa fa-battery-full" aria-hidden="true"></i></div><div class="subtitle">Новые</div></div><div class="right-button"><div class="icon"><i class="fa fa-battery-half" aria-hidden="true"></i></div><div class="subtitle">Б/У</div></div>');
		
	});
	$('#right').click(function() {
		$('#right').html('<div class="left-button"><div class="icon"><i class="fa fa-angle-double-down" aria-hidden="true"></i></div><div class="subtitle">Получить</div></div><div class="right-button"><div class="icon"><i class="fa fa-angle-double-up" aria-hidden="true"></i></div><div class="subtitle">Оказать</div></div>');
		
	});
  </script>
  </body>
</html>