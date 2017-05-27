@extends('layouts.app')

@section('css')
	<link href="/vendor/devdojo/chatter/assets/css/chatter.css" rel="stylesheet">
@stop

@section('content')
<?\Carbon\Carbon::setLocale('ru')?>
<div id="chatter" class="chatter_home">

	@if (count($errors) > 0)
	    <div class="chatter-alert alert alert-danger">
            <p><strong><i class="chatter-alert-danger"></i> Ошибка!</strong> Возникли следующие ошибки: </p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
	    </div>
	@endif
    @if (!count(Auth::user()->specs))
        <div class="chatter-alert alert alert-info">
            <i class="chatter-close"></i>
            <strong><i class="chatter-alert-info"></i> Информация!</strong>
            Мы обнаружили, что у Вы не указали свои специализации и поэтому Ваши обсуждения к сожалению пусты. Исправить эту ситуацию можно на <a href="/profile/form">этой странице</a>, указав свои специализации.
        </div>
        <div class="chatter-alert-spacer"></div>
    @endif

	<div class="chatter_container">
		
	    <div class="row">

	    	<div class="col-md-24 left-column">
	    		<!-- SIDEBAR -->
	    		<div class="chatter_sidebar">
					<button class="btn btn-primary pull-right" id="new_discussion_btn"><i class="chatter-new"></i> Новое обсуждение</button>

					<ul class="nav nav-pills nav-stacked cat-list">
                        <li style="margin-top: 2px;"><a href="/forum"><i class="chatter-bubble"></i> Все категории</a></li>

                        @foreach(Auth::user()->specs as $category)
							<li><a href="/forum/cat/{{ str_slug($category->name, "-") }}"><div class="chatter-box" style="background-color:#{{ \App\Helpers\ForumHelper::stringToColorCode($category->name) }}"></div> {{ $category->name }}</a></li>
						@endforeach
					</ul>
				</div>
				<!-- END SIDEBAR -->
	    	</div>
        </div>
        <div class="row">
	        <div class="col-md-24 right-column">
	        	<div class="panel">
                    @if (count($discussions))
		        	<ul class="discussions">
		        		@foreach($discussions as $discussion)
				        	<li>
				        		<a class="discussion_list" href="/forum/discuss/{{ str_slug($discussion->category->name, "-") }}/{{ $discussion->slug }}">
					        		<div class="chatter_avatar">
					        			@if(isset($discussion->user->images->first()->file))

                                            <img src="/images/uploads/user/{{ $discussion->user->images->first()->file }}">
					        			
					        			@else
					        				
					        				<span class="chatter_avatar_circle" style="background-color:#<?= ForumHelper::stringToColorCode($discussion->user->firstname) ?>">
					        					{{ strtoupper(mb_substr($discussion->user->firstname, 0, 1)) }}
					        				</span>
					        				
					        			@endif
					        		</div>

					        		<div class="chatter_middle">
					        			<h3 class="chatter_middle_title">
                                            @if($discussion->evaluation)
                                                <span style="color: orange;">Оценка экспертов:</span>
                                            @endif
                                            {{ $discussion->title }} <div class="chatter_cat" style="background-color:#{{ \App\Helpers\ForumHelper::stringToColorCode($discussion->category->name) }}">{{ $discussion->category->name }}</div></h3>

                                        @if($discussion->evaluation)
                                            <div class="chatter_rate">Требуемый уровень оценки:
                                                <div class="icon-rate-{{$discussion->evaluation}} bs-14"></div>
                                            </div>
                                        @endif
					        			<span class="chatter_middle_details">Размещено: <span data-href="/user">{{ ucfirst($discussion->user->firstname) }}</span> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($discussion->created_at))->diffForHumans() }}</span>
					        			<p>{{ mb_substr(strip_tags($discussion->post[0]->body), 0, 200) }}@if(strlen(strip_tags($discussion->post[0]->body)) > 200){{ '...' }}@endif</p>
					        		</div>

					        		<div class="chatter_right">
					        			
					        			<div class="chatter_count"><i class="chatter-bubble"></i> {{ $discussion->postsCount[0]->total }}</div>
					        		</div>

					        		<div class="chatter_clear"></div>
					        	</a>
				        	</li>
			        	@endforeach
		        	</ul>
                    @else
                        <div class="text-center margin-top">Обсуждений не найдено</div>
                    @endif
	        	</div>

	        	<div id="pagination">
	        		{{ $discussions->links() }}
	        	</div>

	        </div>
	    </div>
	</div>

	<div id="new_discussion">
	        	

    	<div class="chatter_loader dark" id="new_discussion_loader">
		    <div></div>
		</div>

    	<form id="chatter_form_editor" action="/forum/discuss" method="POST">
        	<div class="row">
	        	<div class="col-md-12">
		        	<!-- TITLE -->
	                <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок обсуждения" v-model="title" value="{{ old('title') }}" >
	            </div>

	            <div class="col-md-10">
		            <!-- CATEGORY -->
			            <select id="category_id" class="form-control" name="category_id" style="width:100%" data-placeholder="Выберите категорию...">
                            <option></option>
                            @foreach(App\Models\Category::where('parent_id', 0)->get() as $cat)
                                <optgroup label="{{ $cat->name }}">
                                    @foreach(App\Models\Category::where('parent_id', $cat->id)->get() as $subcat)
                                        <option value="{{ $subcat->id }}" {{($subcat->id == old('category_id'))?'selected':''}}>{{ $subcat->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
			            </select>
		        </div>

		        <div class="col-md-2">
		        	<i class="chatter-close"></i>
		        </div>	
	        </div><!-- .row -->

            <!-- BODY -->
        	<div id="editor">
				<label id="tinymce_placeholder">Описание обсуждения</label>
    			<textarea id="body" class="richText" name="body" placeholder="">{{ old('body') }}</textarea>
    		</div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div id="new_discussion_footer">
            	<button id="submit_discussion" class="btn btn-success pull-right"><i class="chatter-new"></i> Создать обсуждение</button>
            	<a href="/forum" class="btn btn-default pull-right" id="cancel_discussion">Отменить</a>
            	<div style="clear:both"></div>
            </div>
        </form>

    </div><!-- #new_discussion -->

</div>

<input type="hidden" id="chatter_tinymce_toolbar" value="bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image jbimages">
<input type="hidden" id="chatter_tinymce_plugins" value="link, image, jbimages">

@endsection

@section('js')
<script src="/vendor/devdojo/chatter/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="/vendor/devdojo/chatter/assets/js/tinymce.js"></script>
<script src="/vendor/devdojo/chatter/assets/js/chatter.js"></script>
<script>
	var my_tinymce = tinyMCE;
	$('document').ready(function(){

		$('#tinymce_placeholder').click(function(){
			my_tinymce.activeEditor.focus();
		});
		$('.chatter-close').click(function(){
			$('#new_discussion').slideUp();
		});
		$('#new_discussion_btn, #cancel_discussion').click(function(){
            $('#new_discussion').slideDown();
            $('#title').focus();
		});
		$('#category_id').styler('destroy');

		@if (count($errors) > 0)
			$('#new_discussion').slideDown();
			$('#title').focus();
		@endif

	});
</script>
@stop
