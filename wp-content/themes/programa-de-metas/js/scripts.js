var OBJ = 1;
if (typeof currentOBJ !== "undefined") {
	OBJ = currentOBJ;
}
var filters = '';
stopScroll = false;
var PDM = PDM || {};

PDM.init = function() {
	$(window).scroll(function(){  
        if($(window).scrollTop() == $(document).height() - $(window).height()){
			if (!stopScroll) {
				OBJ = OBJ + 1;
				PDM.loadMetas();
				$(window).unbind('scroll');
			}
		}
    });
	
	$('.meta-single').click(function(e) {
		e.preventDefault();
		PDM.getPost($(this).attr('data-post'));
		$('.modal').empty();
		$('.modal').addClass($(this).attr('data-eixo'));
	})
	
	$('.mask').click(function() {
		$('.mask').fadeOut();
		$('.modal').fadeOut();
	});
	
	$('.eixo-filter').click(function(e) {
		e.preventDefault();
		$('#filter-eixo').attr('value', $(this).attr('data-slug'));
	});
	
	$('.select-filters').dropkick();
	
	$('.select-objetivos').dropkick();
	
	$('.select-secretaria').dropkick();
	
	$('#filtros').submit(function(e) {
		e.preventDefault();
		stopScroll = true;
		data = $(this).serialize();
		PDM.loadMetasByFilter(data);
	});
	
	$('.close').click(function(e) {
		e.preventDefault();
		$('.modal').fadeOut();
		$('.modal').empty();
		$('.mask').fadeOut();
	});
};

PDM.getPost = function(id) {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',  
        data: 'action=get_post_by_id&pid=' + id,   
        success: function(response){  
            $('.modal').html(response);
			$('.mask').fadeIn();
			$('.modal').fadeIn();
			$('body,html').animate({
				scrollTop: 0	
			}, 1000);
			PDM.init();
        }  
    });
};

PDM.loadMetasByFilter = function(target) {
	var loader = '<div class="loader"><img src="'+templateUrl+'/img/ajax-loader.gif" /></div>';
	$('.metas').html(loader);
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',  
        data: target,   
        success: function(response){
			$('.metas').html(response);
			PDM.init();
        }  
    });
};

PDM.loadMetas = function(replace) {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',
		data: 'action=infinite_scroll&objetivo=objetivo-' + OBJ,
        success: function(response){
			if (typeof replace !== "undefined") {
				$('.metas').html(response);
			} else {
				$('.metas').append(response);
			}
			PDM.init();
        }  
    });
};

$(document).ready(function() {
	PDM.init();
});