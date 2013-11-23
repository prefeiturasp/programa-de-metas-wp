<?php get_header(); ?>
<div id="all">
	<div class="nav">
		<div class="content">
			<ul>
				<li><a href="" class="first">Conheça o programa</a>|</li>
				<li><a href="">Objetivos e metas</a>|</li>
				<li><a href="">Conceito territorial</a>|</li>
				<li><a href="">Contato</a></li>
			</ul>
		</div>
	</div>
	
	<div class="content interna">
		<h1 class="logo logo-interna">
			<img src="<?php echo get_template_directory_uri(); ?>/img/logo-programa-de-metas.png">
		</h1>
		
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
</div>