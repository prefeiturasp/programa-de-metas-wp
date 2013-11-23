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