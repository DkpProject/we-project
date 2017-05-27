@if(count($catalog) && config('project.enableCatalog'))
    <div class="search-section">
        Товары
    </div>
    @foreach($catalog as $item)
    <a href="/catalog/{{$item->id}}">
        <div class="search-item">
            <i class="fa fa-angle-double-right pull-right fa-2x"></i>
            <h5>{{$item->name}}</h5>
            <span>{{$item->cat->name}}</span>
        </div>
    </a>
    @endforeach
    <div class="search-show-all">
        <a href="/catalog/search/{{urlencode($query)}}">Показать все товары по запросу</a>
    </div>
@endif
@if(count($service) && config('project.enableService'))
    <div class="search-section">
        Услуги
    </div>
    @foreach($service as $item)
        <a href="/service/{{$item->id}}">
            <div class="search-item">
                <i class="fa fa-angle-double-right pull-right fa-2x"></i>
                <h5>{{$item->name}}</h5>
                <span>{{$item->cat->name}}</span>
            </div>
        </a>
    @endforeach
    <div class="search-show-all">
        <a href="/service/search/{{urlencode($query)}}">Показать все услуги по запросу</a>
    </div>
@endif
@if(!count($catalog) && !count($service))
    <div class="search-no-result">
        По вашему запросу ничего не найдено
    </div>
@endif