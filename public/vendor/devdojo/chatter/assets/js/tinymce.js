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

function initializeNewEditor(id){
    tinymce.init({ 
        selector:'#'+id,
		language: 'ru_RU',
        skin: 'chatter',
        plugins: chatter_tinymce_plugins,
        toolbar: chatter_tinymce_toolbar,
        menubar: false,
        statusbar: false,
        height : "300",
        content_css : "/css/app.css, /vendor/devdojo/chatter/assets/css/chatter.css",
        template_popup_height: 380,
        plugin_image_width: 500
    });
}
