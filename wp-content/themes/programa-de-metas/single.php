<?php
global $withcomments;
$withcomments = 1;
$terms = wp_get_post_terms($post->ID, 'metas-category');
?>
<a href="javascript:void(0);" class="close">Fechar x</a>
<div class="content">
	<h2>Meta <?php the_title();?></h2>
	<div class="conteudo">
		<div class="texto-meta">
			<p><?php echo remove_images(get_the_content());?></p>
		</div>
		<?php
			if (has_post_thumbnail($post->ID)) {
				echo get_the_post_thumbnail($post->ID);    
			}
		?>
		
		<div style="clear:both;"></div>
		<?php
			$eixo = wp_get_post_terms($post->ID, 'eixos');
			if(!empty($eixo)):
				?>
					<h4>Eixo Temático <?php echo $eixo[0]->name;?>. <?php echo $eixo[0]->description?></h4>
				<?php
			endif;
		?>
		<h4>Objetivo Temático Associado</h4>
		
		<?php
			$objetivo = wp_get_post_terms($post->ID, 'objetivos');
			if(!empty($objetivo)):
				?>
					<p class="descricao"><b><?php echo $objetivo[0]->name;?>.</b> <?php echo $objetivo[0]->description;?></p>
				<?php
			endif;
		?>
		
		<h4>Secretaria e unidade responsável</h4>
		<?php
			$secretaria = wp_get_post_terms($post->ID, 'secretarias');
			if(!empty($secretaria)):
				?>
					<p class="descricao"><?php echo $secretaria[0]->name;?></p>
				<?php
			endif;
		?>
		
		<h4>Articulação Territorial Associada</h4>
		<?php
			$articulacao = wp_get_post_terms($post->ID, 'articulacoes');
			if(!empty($articulacao)):
				?>
					<p class="descricao"><?php echo $articulacao[0]->name;?></p>
				<?php
			endif;
		?>	
		
		<div class="box">
			<h4 class="titulo">Detalhamento da Meta</h4>
			<div class="left">
				<h4>Definições dos termos técnicos</h4>
				<p class="descricao"><?php echo get_post_meta($post->ID, 'meta_termos_tecnicos', true);?></p>
			</div>
			
			<div class="borda"></div>
			<div class="right">
				<h4>O que vai ser entregue?</h4>
				<p class="descricao"><?php echo get_post_meta($post->ID, 'meta_entregue', true);?></p>
			</div>
		</div>
		
		<h4>Observações</h4>
		<p class="descricao"><?php echo get_post_meta($post->ID, 'meta_observacoes', true);?></p>
		
		<h4>Custo total da meta</h4>
		<p class="descricao"><?php echo get_post_meta($post->ID, 'meta_custo_total', true);?></p>
		
		<div class="box cronograma">
			<h4 class="titulo">Cronograma de entrega</h4>
			<div class="left">
				<h4>2013 - 2014</h4>
				<?php
					$cronograma1 = get_post_meta($post->ID, 'meta_cronograma_1', true);
					if(!empty($cronograma1)):
						$parts = explode(',', $cronograma1);
						foreach($parts as $p):
						?>
							<p class="descricao"><?php echo $p;?></p>
						<?php
						endforeach;
					endif;
				?>
			</div>
			
			<div class="borda"></div>
			
			<div class="right">
				<h4>2015 - 2016</h4>
				<?php
					$cronograma2 = get_post_meta($post->ID, 'meta_cronograma_2', true);
					if(!empty($cronograma2)):
						$parts = explode(',', $cronograma2);
						foreach($parts as $p):
						?>
							<p class="descricao"><?php echo $p;?></p>
						<?php
						endforeach;
					endif;
				?>
			</div>
		</div>
		
		<img src="<?php echo catch_that_image();?>" class="mapa" />
	</div>
</div>
<?php wp_reset_query(); ?>
<div class="comentarios">
	<h2>Deixe seu comentário</h2>
	<div class="contador">
		<span class="balao"></span>
		<span class="total">
			<?php
				$countComments = wp_count_comments($post->ID);
			?>
			<b><?php echo $countComments->approved?></b> Comentários
		</span>
	</div>
	<?php comments_template();?>
</div>