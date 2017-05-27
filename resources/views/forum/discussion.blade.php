@extends('layouts.app')

@section('css')
	<link href="/vendor/devdojo/chatter/assets/css/chatter.css" rel="stylesheet">
@stop


@section('content')
<?\Carbon\Carbon::setLocale('ru')?>
<?php
if ($discussion->evaluation) {
    $eva_level = Auth::user()->specs_level($discussion->category->id)['level'];
} else {
    $eva_level = 0;
}?>
<div id="chatter" class="discussion">

	<div id="chatter_header" style="background-color:#424B5F;">
        <a class="back_btn" href="/forum"><i class="chatter-back"></i></a>
        <h1 title="{{ $discussion->title }}">{{ $discussion->title }}
            <span class="chatter_head_details">Категория <a class="chatter_cat" href="/forum/cat/{{ str_slug($discussion->category->name, "-") }}" style="background-color:#{{ \App\Helpers\ForumHelper::stringToColorCode($discussion->category->name) }}">{{ $discussion->category->name }}</a></span>
        </h1>
	</div>

	@if (count($errors) > 0)
	    <div class="chatter-alert alert alert-danger">
            <p><strong><i class="chatter-alert-danger"></i> Ошибка!</strong> Возникли следующие ошибки:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
	    </div>
	@endif
    @if ($discussion->answered)
        <div class="chatter-alert alert alert-info">
            <strong><i class="chatter-alert-info"></i> Информация!</strong>
            Это обсуждение было закрыто. Все сообщения доступны только для прочтения.
        </div>
        <div class="chatter-alert-spacer"></div>
    @endif

	<div class="mgt10">

        @if($discussion->evaluation)
	    <div class="row">
            <div class="col-md-24">
                <h4>Оцениваемый товар: <a href="/catalog/{{$discussion->item->id}}">{{$discussion->item->name}}</a></h4>
                <h5>Требуемый уровень оценки: <div class="icon-rate-{{$discussion->evaluation}}"></div></h5>
            </div>
        </div>
        @endif
	    <div class="row">

	        <div class="col-md-24">
					
				<div class="conversation">
	                <ul class="discussions no-bg" style="display:block;">
	                	@foreach($posts as $key => $post)
	                		<li data-id="{{ $post->id }}">
		                		<span class="chatter_posts">
		                			@if(!Auth::guest() && (Auth::user()->id == $post->user->id))
                                        @if ($key)
		                				<div id="delete_warning_{{ $post->id }}" class="chatter_warning_delete">
		                					<i class="chatter-warning"></i>Вы уверены, что хотите удалить это сообщение?
		                					<button class="btn btn-sm btn-danger pull-right delete_response">Да, удалить</button>
		                					<button class="btn btn-sm btn-default pull-right">Нет, спасибо</button>
		                				</div>
                                        @endif
                                        @if (!$key)
		                				<div id="close_warning_{{ $post->id }}" class="chatter_warning_close">
		                					<i class="chatter-warning"></i>Вы уверены, что хотите закрыть это обсуждение?
		                					<button class="btn btn-sm btn-danger pull-right close_response">Да, закрыть</button>
		                					<button class="btn btn-sm btn-default pull-right">Нет, спасибо</button>
		                				</div>
                                        @endif
			                			<div class="chatter_post_actions">
                                            @if(!$key && !$discussion->answered && !$discussion->evaluation)
			                				<p class="chatter_close_btn">
			                					<i class="chatter-close"></i> Закрыть
			                				</p>
                                            @endif
                                            @if($key && !$discussion->answered)
			                				<p class="chatter_delete_btn">
			                					<i class="chatter-delete"></i> Удалить
			                				</p>
                                            @endif
                                            @if((($key && $discussion->evaluation) || !$discussion->evaluation) && !$discussion->answered)
			                				<p class="chatter_edit_btn">
			                					<i class="chatter-edit"></i> Редактировать
			                				</p>
                                            @endif
                                            @if($discussion->evaluation && $key)
                                                <p style="color: orange; cursor: default;">
                                                    Оценка товара: <span class="chatter_price">{{$post->price}}</span> руб.
                                                </p>
                                            @endif
                                            @if($post->thanks && !$discussion->evaluation)
                                                <p style="color: green; cursor: default;">
                                                    <i class="fa fa-check fa-lg" style="top: 0px; margin-right: 2px;"></i>
                                                    Лучший ответ
                                                </p>
                                            @endif
			                			</div>
			                		@endif
                                    @if(!Auth::guest() && (Auth::user()->id != $post->user->id) && $key)
                                        <div class="chatter_post_actions">
                                            @if($discussion->evaluation < $eva_level)
                                                <p style="color: orange; cursor: default;">
                                                    Оценка товара: <span class="chatter_price price-{{$post->id}}">{{$post->price}}</span> руб.
                                                </p><br>
                                                @if(!$discussion->answered)
                                                <div class="btn-group price-confirm" data-toggle="buttons">
                                                    <label class="btn btn-sm btn-default" for="check-price-{{$post->id}}">
                                                        <input type="checkbox" id="check-price-{{$post->id}}" name="confirmed[]" value="{{$post->id}}" autocomplete="off"> Подтвердить эту оценку
                                                    </label>
                                                </div>
                                                @endif
                                            @endif
			                			</div>
                                    @endif
                                    @if (Auth::user()->id != $post->user->id && $key && $discussion->user_id == Auth::user()->id && !$post->thanks)
                                        <div class="chatter_post_actions">
                                            <a href="/forum/posts/{{$post->id}}/thanks">
                                                <button class="btn btn-default" data-toggle="tooltip" data-placement="left" data-original-title="Поблагодарить"><i class="fa fa-lg fa-handshake-o"></i>
                                                </button>
                                            </a>
                                        </div>
                                    @elseif ($post->thanks && Auth::user()->id != $post->user->id)
                                        <div class="chatter_post_actions">
                                            <p style="color: green; cursor: default;">
                                                <i class="fa fa-check fa-lg" style="top: 0px; margin-right: 2px;"></i>
                                                Лучший ответ
                                            </p>
                                        </div>
                                    @endif
			                		<div class="chatter_avatar">
					        			@if(isset($post->user->images->first()->file))
                                            <img src="/images/uploads/user/{{ $post->user->images->first()->file }}">
					        			@else
					        				<span class="chatter_avatar_circle" style="background-color:#<?= \App\Helpers\ForumHelper::stringToColorCode($post->user->firstname) ?>">
					        					{{ ucfirst(mb_substr($post->user->firstname, 0, 1)) }}
					        				</span>
					        			@endif
					        		</div>

					        		<div class="chatter_middle">
					        			<span class="chatter_middle_details"><a href="{{ \App\Helpers\ForumHelper::getUserLink($post->user) }}" class="post-user-name-{{$post->id}}">{{ ucfirst($post->user->firstname) }}</a> <span class="ago chatter_middle_details">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</span></span>
					        			<div class="chatter_body"><?= $post->body ?></div>
					        		</div>

					        		<div class="chatter_clear"></div>
				        		</span>
		                	</li>
	                	@endforeach

	           
	                </ul>
	            </div>
                @if(!$discussion->answered && (($discussion->user_id != Auth::user()->id && $discussion->evaluation)) && $discussion->evaluation < $eva_level)
                    <div class="modal fade price-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="/forum/discuss/{{$discussion->id}}/confirm" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Подтверждение оценки специалистов</h4>
                                    </div>
                                    <div class="modal-body">
                                        Выбранные вами оценки специалистов:
                                        <table width="100%" class="table table-striped">
                                            <thead>
                                                <th></th>
                                                <th>Специалист</th>
                                                <th class="text-right">Стоимость</th>
                                            </thead>
                                            <tbody class="confirm-table">
                                            </tbody>
                                        </table>
                                        <div class="text-right">Итоговая оценка: <span class="evaluation-result"></span></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-std btn-default" data-dismiss="modal">Закрыть</button>
                                        <button type="submit" class="btn btn-std btn-success confirm-button">Подтвердить оценку товара</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>Подтверждение оценок экспертов</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eget arcu eget leo varius iaculis id sit amet mauris. Fusce et dui vitae lacus eleifend ultricies. Aliquam malesuada fermentum sodales. Aliquam erat volutpat. Aenean tempor est sed leo interdum interdum.</p> <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis viverra massa fermentum, tempor mauris id, pharetra odio. Sed tempus varius lacus at vulputate. Maecenas in magna rhoncus, viverra nulla sit amet, dignissim enim. Vivamus ut elit eros. Curabitur sed iaculis libero. Mauris sollicitudin neque in malesuada auctor. Donec consequat est vitae dolor ultricies, nec convallis quam viverra. Vivamus vitae porta enim, ut vehicula risus. Sed nec mauris id massa laoreet porttitor mollis elementum felis. Ut sit amet est nec magna ultricies lacinia a vitae nisl. </p>
                        <div class="chatter_sidebar">
                            <button class="btn btn-primary evaluation-confirm" data-toggle="modal" data-target=".price-confirm-modal"><i class="fa fa-check" style="position: relative; top: 0px;"></i> Подтверждение оценок</button>
                        </div>
                    </div>
                @endif

                @if(!$discussion->answered && (($discussion->user_id != Auth::user()->id && $discussion->evaluation && $discussion->evaluation == $eva_level && $discussion->posts->count() < 4 && !$discussion->posts->where('user_id', Auth::user()->id)->count()) || !$discussion->evaluation))
	            	<div id="new_response">

	            		<div class="chatter_avatar">
                            @if(isset(Auth::user()->images->first()->file))

                                <img src="/images/uploads/user/{{ Auth::user()->images->first()->file }}">

		        			@else
		        				<span class="chatter_avatar_circle" style="background-color:#<?= \App\Helpers\ForumHelper::stringToColorCode(Auth::user()->firstname) ?>">
		        					{{ strtoupper(mb_substr(Auth::user()->firstname, 0, 1)) }}
		        				</span>
		        			@endif
		        		</div>
                        <form action="/forum/posts" method="POST" class="form_responce">
                            <div id="new_discussion">


                                <div class="chatter_loader dark" id="new_discussion_loader">
                                    <div></div>
                                </div>

                                <div id="chatter_form_editor">

                                    <!-- BODY -->
                                    <div id="editor">
                                        <label id="tinymce_placeholder">Ваше сообщение</label>
                                        <textarea id="body" class="richText" name="body" placeholder="">{{ old('body') }}</textarea>
                                    </div>

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
                                </div>

                            </div>

                            @if($discussion->evaluation == $eva_level && $discussion->evaluation)
                                Стоимость: <input name="price" class="price" value="{{ old('price') }}" style="" placeholder="Предполагаемая стоимоть товара" type="text"> ₽
                            @endif

                            <button id="submit_response" type="submit" class="btn btn-success pull-right"><i class="chatter-new"></i> Отправить</button>
                        </form>
					</div>
                @endif

	        </div>


	    </div>
	</div>

</div>

<input type="hidden" id="chatter_tinymce_toolbar" value="bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image jbimages">
<input type="hidden" id="chatter_tinymce_plugins" value="link, image, jbimages">

@stop

@section('js')
    <script src="/vendor/devdojo/chatter/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/vendor/devdojo/chatter/assets/js/tinymce.js"></script>
    <script>
        var my_tinymce = tinyMCE;
        $('document').ready(function(){

            $('#submit_response').click(function(){
                $('#chatter_form_editor').submit();
            });

            $('#tinymce_placeholder').click(function(){
                my_tinymce.activeEditor.focus();
            });

        });
    </script>

    <script>

        $('.evaluation-confirm').click(function () {
            var html = "", max = 0, min = 0;
            if($('input[name="confirmed[]"]:checked').length) {
                $('input[name="confirmed[]"]:checked').each(function (ind, el) {
                    html += "<tr><td>#"+(ind+1)+"</td><td>"+$('.post-user-name-'+$(el).val()).html()+"</td><td class='text-right'>" + $('.price-' + $(el).val()).html() + " ₽<input type='hidden' name='posts[]' value='"+$(el).val()+"'></td></tr>";
                    max = Math.max(max, $('.price-' + $(el).val()).html());
                    if(!ind)
                        min = $('.price-' + $(el).val()).html();
                    else
                        min = Math.min(min, $('.price-' + $(el).val()).html());
                });
            } else {
                html = '<tr><td class="text-center" colspan="3">Выберите оценки для подтверждения</td></tr>';
            }
            if (max == min)
                $('.price-confirm-modal .evaluation-result').html(max +' ₽');
            else
                $('.price-confirm-modal .evaluation-result').html(min + ' - ' + max +' ₽');
            $('.price-confirm-modal .confirm-table').html(html);
        });

        $('document').ready(function(){
            $('.chatter_edit_btn').click(function(){
                parent = $(this).parents('li');
                parent.addClass('editing');
                id = parent.data('id');
                container = parent.find('.chatter_middle');
                body = container.find('.chatter_body');
                price = parent.find('.chatter_price');
                details = container.find('.chatter_middle_details');

                var price_field = "";
                if({{$discussion->evaluation}}) {
                    price_field = 'Стоимость: <input type="text" name="price" style="width: 100px; border: 1px solid #EEEEEE; padding: 6px 8px; border-radius: 3px;" value="'+ price.html() +'">';
                }
                // dynamically create a new text area
                container.prepend('<textarea id="post-edit-' + id + '">' + body.html() + '</textarea>');
                container.append('<div class="chatter_update_actions">'+price_field+'<button class="btn btn-success pull-right update_chatter_edit"  data-id="' + id + '"><i class="chatter-check"></i> Сохранить</button><button href="/" class="btn btn-default pull-right cancel_chatter_edit" data-id="' + id + '">Отменить</button></div>');

                initializeNewEditor('post-edit-' + id);

            });

            $('.discussions li').on('click', '.cancel_chatter_edit', function(e){
                post_id = $(e.target).data('id');
                parent_li = $(e.target).parents('li');
                parent_actions = $(e.target).parent('.chatter_update_actions');
                tinymce.remove('#post-edit-' + post_id);
                $('#post-edit-' + post_id).remove();
                parent_actions.remove();

                parent_li.removeClass('editing');
            });

            $('.discussions li').on('click', '.update_chatter_edit', function(e){
                post_id = $(e.target).data('id');
                update_body = tinyMCE.get('post-edit-' + post_id).getContent();
                $.form('/forum/posts/' + post_id, { _token: '{{ csrf_token() }}', _method: 'PATCH', 'body' : update_body, 'price' : $(this).prev().val() }, 'POST').submit();
            });


            // DELETE BUTTON
            $('.chatter_delete_btn').click(function(){
                parent = $(this).parents('li');
                parent.addClass('delete_warning');
                id = parent.data('id');
                $('#delete_warning_' + id).show();
            });

            $('.chatter_close_btn').click(function(){
                parent = $(this).parents('li');
                parent.addClass('close_warning');
                id = parent.data('id');
                $('#close_warning_' + id).show();
            });

            $('.chatter_warning_delete .btn-default').click(function(){
                $(this).parent('.chatter_warning_delete').hide();
                $(this).parents('li').removeClass('delete_warning');
            });

            $('.chatter_warning_close .btn-default').click(function(){
                $(this).parent('.chatter_warning_close').hide();
                $(this).parents('li').removeClass('close_warning');
            });

            $('.delete_response').click(function(){
                post_id = $(this).parents('li').data('id');
                $.form('/forum/posts/' + post_id, { _token: '{{ csrf_token() }}', _method: 'DELETE'}, 'POST').submit();
            });

            $('.close_response').click(function(){
                post_id = $(this).parents('li').data('id');
                $.form('/forum/discuss/{{$discussion->id}}/close', { _token: '{{ csrf_token() }}'}, 'POST').submit();
            });

        });


    </script>
    <script src="/vendor/devdojo/chatter/assets/js/chatter.js"></script>

@stop