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
	
	$('.metas.bolinhas .meta-single').hover(function(e) {
		$(this).find('.hover').show();
	});
	
	$('.metas.bolinhas .meta-single').mouseout(function(e) {
		$(this).find('.hover').hide();
	});
	
	$('.meta-single').click(function(e) {
		e.preventDefault();
		window.history.pushState('Meta ' + $(this).attr('data-post'), 'Meta ' + $(this).attr('data-post'), '?pid=' + $(this).attr('data-post'));
		PDM.getPost($(this).attr('data-post'));
		$('.modal').empty();
		$('.modal').addClass($(this).attr('data-eixo'));
	})
	
	$('.mask').click(function() {
		$('.mask').fadeOut();
		$('.modal').fadeOut();
	});
	
	$('.eixo-filter').click(function(e) {
		$('.eixo-filter').removeClass('current');
		e.preventDefault();
		$('#filter-eixo').attr('value', $(this).attr('data-slug'));
		$(this).addClass('current');
		var form = $(this).parent().parent().parent();
		var data = $(form).serialize();
		PDM.loadMetasByFilter(data);
	});
	
	$('.select-filters').dropkick({
		change: function(value, label) {
			var form = $(this).parent().parent().parent().parent();
			var data = $(form).serialize();
			PDM.loadMetasByFilter(data);
		}
	});
	
	$('.icons').click(function(e) {
		e.preventDefault();
		$('#action').attr('value', $(this).attr('data-action'));
		if ($(this).hasClass('bolas')) {
			$('.metas').addClass('bolinhas');
			$('.filters').hide();
			$('.legenda').show();
		} else {
			$('.metas').removeClass('bolinhas');
			$('.filters').show();
			$('.legenda').hide();
		}
		var form = $('#filtros');
		var data = $(form).serialize();
		PDM.loadMetasByFilter(data);
	});
	
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
	
	$('#reset-form').click(function(e) {
		e.preventDefault();
		OBJ = 1;
		PDM.loadMetas(true);
	});
};

PDM.getPost = function(id, eixo) {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',  
        data: 'action=get_post_by_id&pid=' + id,   
        success: function(response){
			if (typeof eixo !== "undefined") {
				$('.modal').addClass(eixo);	
			}
            $('.modal').html(response);
			$('.modal').css("position","absolute");
			$('.modal').css("top", Math.max(0, (($(window).height() - $('.modal').outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
			$('.modal').css("left", Math.max(0, (($(window).width() - $('.modal').outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
			$('.mask').fadeIn();
			$('.modal').fadeIn();
			PDM.init();
        }  
    });
};

PDM.loadMetasByFilter = function(target) {
	$(window).unbind('scroll');
	var loader = '<div class="loader"><img src="'+templateUrl+'/img/ajax-loader.gif" /></div>';
	//$('.metas .loader').remove();
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
	var loader = '<div class="loader"><img src="'+templateUrl+'/img/ajax-loader.gif" /></div>';
	$('.metas').append(loader);
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',
		data: 'action=infinite_scroll&objetivo=objetivo-' + OBJ,
        success: function(response){
			$('.metas .loader').remove();
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
	if (typeof postId !== "undefined" && typeof eixoId !== "undefined") {
		PDM.getPost(postId, eixoId);
	}
	
	PDM.init();
});