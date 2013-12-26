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
		var form = $('#filtros');
		var data = $(form).serialize();
		if ($(this).hasClass('mapa')) {
			$('#container').addClass('mapa');
			$('.filters').hide();
			$('.container-mapa').show();
			$('.metas').empty();
		} else if ($(this).hasClass('bolas')) {
			$('.metas').addClass('bolinhas');
			$('#container').css('width', '1069px');
			$('.filters').hide();
			$('.legenda').show();
			PDM.loadMetasByFilter(data);
		} else {
			$('.metas').removeClass('bolinhas');
			$('.filters').show();
			$('.legenda').hide();
			$('.container-mapa').hide();
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

PDM.loadMetasBySub = function(sub) {
	$.ajax({  
        url: wpAjaxUrl,  
        type:'POST',
		data: 'action=load_by_sub&subprefeitura=' + sub,
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
	
	$('#mapaSub area').mouseenter(function(){
		getId = $(this).attr('id');
		$(".subs").find("."+ getId).filter(':not(:animated)').toggle();
		$(this).parent().parent().parent().find('.subs').find("."+ getId).addClass('active');
		$(".subs").find("."+ getId).removeAttr('style');
				
	});
	
	$('#mapaSub area').mouseout(function(){
		$(this).parent().parent().parent().find('.subs').find("."+ getId).removeClass('active');
		$(".subs").find("."+ getId).removeAttr('style');					
	});
	
	
	$('#mapaSub area').click(function(){
		var getId = "";
		var subprefeitura = "";
		getId = $(this).attr('id');
		
		$(".subs").find("."+ getId).addClass('clicado');
		var clicado = $(this).parent().parent().parent().find('.subs').find("."+ getId).is('.clicado');
		var qtdClicado = $('#legenda').find('.'+getId).size();
		
		if(qtdClicado>0){
			/* verifica se existe alguma subprefeitura ja clicada e remove esse clic */

			$('#legenda').find("."+ getId).remove();
			$(".subs").find("."+ getId).removeAttr('style');
			$(".subs").find("."+ getId).removeClass('clicado');
			/**
			* Fazer o ajax para carregar as informações das metas depois dessas linhas de comando
			*/
				
				
		}else{
			
			if(clicado == true){
				/* adiciona tags de clicado que pinta o mapa e box lateral */
				subprefeitura = $(".subs").find("."+ getId).html();
				$('#legenda').append( "<strong class='"+getId+"'>"+subprefeitura+"<input type='hidden' name='subprefeituras[]' value='"+getId+"' /></strong>" );
				var hiddens = $('#legenda').find('input[type="hidden"]');
				var subs = [];
				$(hiddens).each(function(i) {
					subs[i] = this.value;
				});
				$(".subs").find("."+ getId).removeAttr('style');
				/**
				* Fazer o ajax para carregar as informações das metas depois dessas linhas de comando
				*/
				PDM.loadMetasBySub(subs);
				
			}
		}
		return false;
	});
	$('.limpar').click(function(){
		$('#legenda strong').remove();
		$(".subs div").removeClass('clicado');	
		$(".subs div").removeAttr('style');	
	});
});