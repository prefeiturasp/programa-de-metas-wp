<?php
/*
Template Name: Objetivos e Metas
*/
?>
<?php get_header(); ?>
<div id="all" class="interna">
	<div class="nav">
		<div class="content">
			<ul>
				<li><a href="<?php echo bloginfo('url');?>/conheca-o-programa/" class="first">Conheça o programa</a>|</li>
				<li><a href="<?php echo bloginfo('url');?>/objetivos-e-metas/">Objetivos e metas</a>|</li>
				<li><a href="<?php echo bloginfo('url');?>/conceito-territorial/">Conceito territorial</a>|</li>
				<li><a href="http://planejasampa.prefeitura.sp.gov.br/index.php/contato/">Contato</a></li>
			</ul>
			
			<div class="social">
				<div class="fb">
				    <div class="fb-share-button" data-href="http://programademetas.info" data-type="button" data-width="120"></div>
				</div>
				
				<div class="tw">
				    <a href="https://twitter.com/share?url=<?php echo bloginfo('url');?>&text=Programa%20de%20Metas%20da%20Cidade%202013%20-2016%3A%20um%20convite%20ao%20planejamento%20urbano%20participativo." class="twitter-share-button" data-lang="pt">Tweet</a>
				    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				
				<div class="gp">
				    <g:plus action="share" annotation="none"></g:plus>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content interna objetivos-e-metas">
		<h1 class="logo logo-interna">
			<a href="<?php echo bloginfo('url');?>/">
				<img src="<?php echo get_template_directory_uri(); ?>/img/logo-programa-de-metas.png">
			</a>
		</h1>
		
		<h2>
			Além de uma estratéga territorial, o Programa de Metas 2012-2016 também estabelece diretrizes de execução para as iniciativas do poder público que buscam unificar as ações nos diversos territórios, funcionando como eixos integradores. 
		</h2>
		
		<p class="center">
			Tais diretrizes estão organizadas em três eixos temáticos:
		</p>
		
		<img src="<?php echo get_template_directory_uri(); ?>/img/objetivos-e-metas/fluxo.png" class="fluxo"/>
		
		<p class="normal last">
			Cada eixo apresenta um conjunto de objetivos estratégicos que apontam aspectos importantes para a melhoria da vida na cidade de<br />
			São Paulo. As metas são algumas das iniciativas que possibilitarão o alcance desses objetivos, sendo possível seu o monitoramento<br />
			através dos indicadores referentes a cada um deles.
		</p>
	</div>
</div>

<?php get_footer();?>