@extends('layouts.app')
@section('css')
    <link href="/vendor/devdojo/chatter/assets/css/chatter.css" rel="stylesheet">
@stop

@section('content')
    <style>
        .wish {
            padding: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #f3f3f3;
        }
        .wish i.fa {
            transition: all 0.2s ease 0s;
            color: #e1e1e1;
            cursor: pointer;
        }
        .wish i.fa:hover {
            color: #cacaca;
        }
    </style>
    <input type="hidden" id="chatter_tinymce_toolbar" value="bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image jbimages">
    <input type="hidden" id="chatter_tinymce_plugins" value="link, image, jbimages">
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Ваши пожелания</div>
                <div class="page-content">
                    {!! Form::open(array('url'=>'/wishes','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="form-group{{ $errors->has('wishes') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Ваши пожелания</label>
                        <div class="col-md-20" id="chatter">
                            <div class="chatter_loader dark" id="new_discussion_loader">
                                <div></div>
                            </div>
                            <div id="chatter_form_editor">
                                <div id="editor" style="position: relative; border: 1px solid #F3F6F9">
                                    <label id="tinymce_placeholder" style="top: 41px; left: 2px;">Опишите свое желание. Его увидят специалисты и обязательно свяжутся с Вами для его уточнения и исполнения.</label>
                                    <textarea name="wishes" class="richText" minlength="5" class="styler" placeholder="Опишите свое желание. Его увидят специалисты и обязательно свяжутся с Вами для его уточнения и исполнения.">{{old('wishes')}}</textarea>
                                </div>
                            </div>

                            @if ($errors->has('wishes'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('wishes') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-20 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Отправить
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @if($auth->wishes()->active()->count())
                <div class="page-title">Ваши прошлые пожелания</div>
                <div class="page-content">
                    <div class="wishes">
                        @foreach($auth->wishes()->active()->latest()->get() as $wish)
                        <div class="wish">
                            <a href="/wishes/{{$wish->id}}/delete">
                                <i class="fa fa-times pull-right"></i>
                            </a>
                            {!! $wish->text !!}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script src="/vendor/devdojo/chatter/assets/vendor/tinymce/tinymce.min.js"></script>
    <script>
        var chatter_tinymce_toolbar = $('#chatter_tinymce_toolbar').val();
        var chatter_tinymce_plugins = $('#chatter_tinymce_plugins').val();

        // Initiate the tinymce editor on any textarea with a class of richText
        tinymce.init({
            selector:'textarea.richText',
            language: 'ru_RU',
            skin: 'chatter',
            plugins: chatter_tinymce_plugins,
            toolbar: chatter_tinymce_toolbar,
            menubar: false,
            statusbar: false,
            height : "220",
            content_css : "/css/app.css, /vendor/devdojo/chatter/assets/css/chatter.css",
            template_popup_height: 380,
            relative_urls: false,
            setup: function (editor) {
                editor.on('init', function(args) {
                    // The tinymce editor is ready
                    document.getElementById('new_discussion_loader').style.display = "none";
                    if(!editor.getContent()){
                        document.getElementById('tinymce_placeholder').style.display = "block";
                    }
                    document.getElementById('chatter_form_editor').style.display = "block";
                });
                editor.on('keyup', function(e) {
                    content = editor.getContent();
                    if(content){
                        //$('#tinymce_placeholder').fadeOut();
                        document.getElementById('tinymce_placeholder').style.display = "none";
                    } else {
                        //$('#tinymce_placeholder').fadeIn();
                        document.getElementById('tinymce_placeholder').style.display = "block";
                    }
                });
            }
        });
    </script>
@endsection