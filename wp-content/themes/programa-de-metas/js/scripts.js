// DOM Ready
/*$(function() {
	
	// SVG fallback
	// toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script#update
	if (!Modernizr.svg) {
		var imgs = document.getElementsByTagName('img');
		var dotSVG = /.*\.svg$/;
		for (var i = 0; i != imgs.length; ++i) {
			if(imgs[i].src.match(dotSVG)) {
				imgs[i].src = imgs[i].src.slice(0, -3) + "png";
			}
		}
	}

});*/

OBJ = 1;
var PDM = PDM || {};

PDM.init = function() {
	$(window).scroll(function(){  
        if($(window).scrollTop() == $(document).height() - $(window).height()){
			OBJ = OBJ + 1;
			//PDM.loadMetas();
		}
    });
	
	$('.meta-single').click(function(e) {
		e.preventDefault();
		PDM.getPost($(this).attr('data-post'));
		$('.modal').addClass($(this).attr('data-eixo'));
	})
	
	$('.mask').click(function() {
		$('.mask').fadeOut();
		$('.modal').fadeOut();
	});
};

PDM.getPost = function(id) {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',  
        data: 'action=get_post_by_id&pid=' + id,   
        success: function(response){  
            $('.modal').append(response);
			$('.mask').fadeIn();
			$('.modal').fadeIn();
        }  
    });
};

PDM.loadMetas = function() {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',  
        data: 'action=infinite_scroll&objetivo=' + OBJ,   
        success: function(response){  
            $('.metas').append(response);
        }  
    });
};

$(document).ready(function() {
	PDM.init();
});