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

PDM.getPost = function(id) {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',  
        data: 'action=get_post_by_id&pid=' + id,   
        success: function(response){  
            $('.modal').html(response);
			$('.modal').center();
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
	PDM.init();
});

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}