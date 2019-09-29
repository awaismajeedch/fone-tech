jQuery(function($) { 
   
    $(".menu .sub-menu a").live('click', function(){
    	var button = $(this);
    	if(button.length > 0){
			var title = button.attr('title').split("-");
    		if(title[0] == 'skin'){

      			document.cookie = 'themeple_skin='+title[1] ; 
      			setTimeout(function(){
                    window.location.hash = "#wpwrap";
                  window.location.reload(true);
                
             	}, 1000);

    		}
		}
  	});
	
    $(".clients").each(function(){

        var $self = $(this);
        var viewport = $(window).width();
        var items = parseInt($self.parent().find('.num_el').html(), 10);

        if(viewport <= 480)
          items = 1;
        else if(viewport > 480 && viewport <= 768)
          items = 1;
        if( $('.caro:first img:first', $self).size() ) {
          $('.caro:first img:first', $self).one("load", function(){
          $self.carouFredSel({
              items:items,
              circular:false,
              auto  : false,
              responsive:true,
              prev  : { 
                button  : $self.parent().find('.prev'),
                key   : "left"
              },
              next  : { 
                button  : $self.parent().find('.next'),
                key   : "right"
              }
              



          });
      });
        }

    });

    $(".accordion-group").live('click', function(){
        var $self = $(this);
        $body = $self.find('.accordion-body');
        if($self.find('.accordion-heading').hasClass('in_head')){
          $self.parent().find('.accordion-heading').removeClass('in_head');
        }else{  
          $self.parent().find('.accordion-heading').removeClass('in_head');
          $self.find('.accordion-heading').addClass('in_head');
        }
          
    });


   
    
    var $container = $('#holder .filterable');
    
        

  $('.nav-port li a').click(function(){
    var selector = $(this).attr('data-filter');
    $(this).parent().parent().find('.active').removeClass('active');
    $(this).parent().addClass('active');
    $container.isotope({ 
    filter: selector,
    animationOptions: {
       duration: 750,
       easing: 'linear',
       queue: false,
     
     }
    });
    return false;
  });

  
  if($().mobileMenu) {
    $('div.menu').each(function(){
      $(this).mobileMenu();
    });
  }  
    
  



});


 (function($){

    $.fn.extend({ 

        hoverZoom: function(settings) {
 
            var defaults = {
                overlay: true,
                overlayColor: '#2e9dbd',
                overlayOpacity: 0.7,
                zoom: 25,
                speed: 300
            };
             
            var settings = $.extend(defaults, settings);
         
            return this.each(function() {
            
                var s = settings;
                var hz = $(this);
                var image = $('img', hz);

                image.load(function() {
                    
                    if(s.overlay === true) {
                        $(this).parent().append('<div class="zoomOverlay" />');
                        $(this).parent().find('.zoomOverlay').css({
                            opacity:0, 
                            display: 'block', 
                            backgroundColor: s.overlayColor
                        }); 
                    }
                
                    var width = $(image).width();
                    var height = $(image).height();
                
                    $(this).fadeIn(1000, function() {
                        $(this).parent().css('background-image', 'none');
                        hz.hover(function() {
                            
                            
                            $('img', this).stop().animate({
                                height: height + s.zoom,
                                marginLeft: -(s.zoom),
                                marginTop: -(s.zoom)
                            }, s.speed);
                            image.css('width', 'auto');
                            if(s.overlay === true) {
                                $(this).parent().find('.zoomOverlay').stop().animate({
                                    opacity: s.overlayOpacity
                                }, s.speed);
                            }
                        }, function() {
                            $('img', this).stop().animate({
                                height: height,
                                marginLeft: 0,
                                marginTop: 0
                            }, s.speed);
                            if(s.overlay === true) {
                                $(this).parent().find('.zoomOverlay').stop().animate({
                                    opacity: 0
                                }, s.speed);
                            }
                        });
                    });
                });    
            });
        }
    });
})(jQuery);
