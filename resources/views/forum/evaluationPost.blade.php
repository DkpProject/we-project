<p><b>Статус товара:</b>@if($data['used']) бывший в употреблении @else новый @endif</p>
<p><b>Тип сделки:</b>@if($data['deal_type'] == "buy") продажа @else аренда @endif</p>
<p><b>Пользователь указать свою стоимость:</b> @money($data['cost'], 'рубль')</p>
<p><b>Описание товара:</b> {{$data['descr']}}</p>