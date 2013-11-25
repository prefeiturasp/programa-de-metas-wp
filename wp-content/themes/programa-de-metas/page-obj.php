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
	
	<div class="content interna">
		<h1 class="logo logo-interna">
			<a href="<?php echo bloginfo('url');?>/">
				<img src="<?php echo get_template_directory_uri(); ?>/img/logo-programa-de-metas.png">
			</a>
		</h1>
		
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer();?>