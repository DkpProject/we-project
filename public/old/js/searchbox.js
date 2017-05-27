(function($) {
  $.searchbox = {}
  
  $.extend(true, $.searchbox, {
    settings: {
      url: '/search',
      param: 'query',
      dom_id: '#results',
      delay: 100,
      loading_css: '#loading',
      previousValue: ''
    },
    
    loading: function() {
      $($.searchbox.settings.loading_css).removeClass('hide')
    },
    
    resetTimer: function(timer) {
      if (timer) clearTimeout(timer)
    },
    
    idle: function() {
      $($.searchbox.settings.loading_css).addClass('hide')
    },
    
    process: function(terms) {
        if (!terms.length) {
            $('.search-result-container').addClass('hide');
            return;
        }
      var path = $.searchbox.settings.url.split('?'),
        query = [$.searchbox.settings.param, '=', terms].join(''),
        base = path[0], params = path[1], query_string = query
      
      if (params) query_string = [params.replace('&amp;', '&'), query].join('&')
      
      $.get([base, '?', query_string].join(''), function(data) {
        $($.searchbox.settings.dom_id).html(data)
      })
      $.searchbox.settings.previousValue = terms;
    },
    
    start: function() {
      $(document).trigger('before.searchbox')
      $.searchbox.loading()
    },
    
    stop: function() {
      $.searchbox.idle()
      $('.search-result-container').removeClass('hide')
      $(document).trigger('after.searchbox')
    }
  })
  
  $.fn.searchbox = function(config) {
    var settings = $.extend(true, $.searchbox.settings, config || {})

    $(document).trigger('init.searchbox')
    $.searchbox.idle()
    
    return this.each(function() {
      var $input = $(this)

      $(document)
        .ajaxStart(function() { $.searchbox.start() })
        .ajaxStop(function() { $.searchbox.stop(); })

      $(document).click( function(event){
        if( $(event.target).closest(".search-panel").length )
            return;
        $(".search-result-container").addClass("hide");
        event.stopPropagation();
      });

      $input.on('focus', function () {
          if (!$(this).val().length) {
              return;
          }
          if ($('.search-result').find('.search-item').length) {
              $(".search-result-container").removeClass("hide");
          } else {
              if ($input.val() != $.searchbox.settings.previousValue) {
                  $.searchbox.process($input.val());
              }
          }
      })

      $input
      .focus()
      .keyup(function() {
        if ($input.val() != $.searchbox.settings.previousValue) {
          $.searchbox.resetTimer(this.timer)

          this.timer = setTimeout(function() {  
            $.searchbox.process($input.val())
          }, $.searchbox.settings.delay)
        } else {
            $(".search-result-container").removeClass("hide");
        }
      })
    })
  }
})(jQuery);