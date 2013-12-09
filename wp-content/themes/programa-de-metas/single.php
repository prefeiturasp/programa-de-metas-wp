<?php
global $withcomments;
$withcomments = 1;
$terms = wp_get_post_terms($post->ID, 'metas-category');
?>

<a href="javascript:void(0);" class="close">Fechar x</a>
<div class="bg">
	<div class="texto-meta">
		<h2>Meta <?php the_title();?></h2>
		<?php the_content();?>
		<?php
			if (has_post_thumbnail($post->ID)) {
				echo get_the_post_thumbnail($post->ID);    
			}
		?>
	</div>
	
	<div class="detalhes">
		<?php
			$eixo = wp_get_post_terms($post->ID, 'eixos');
			if(!empty($eixo)):
				?>
					<h4>Eixo Temático <?php echo $eixo[0]->name;?>. <?php echo $eixo[0]->description?></h4>
				<?php
			endif;
		?>
		<h4>Objetivo temático associado</h4>
		<?php
			$objetivo = wp_get_post_terms($post->ID, 'objetivos');
			if(!empty($objetivo)):
				?>
					<p class="info"><b><?php echo $objetivo[0]->name;?>.</b> <?php echo $objetivo[0]->description;?></p>
				<?php
			endif;
		?>
		<h4>Secretaria e unidade responsável</h4>
		<?php
			$secretaria = wp_get_post_terms($post->ID, 'secretarias');
			if(!empty($secretaria)):
				?>
					<p class="info"><?php echo $secretaria[0]->name;?></p>
				<?php
			endif;
		?>
		<h4>Articulação territorial associada</h4>
		<?php
			$articulacao = wp_get_post_terms($post->ID, 'articulacoes');
			if(!empty($articulacao)):
				?>
					<p class="info"><?php echo $articulacao[0]->name;?></p>
				<?php
			endif;
		?>					
		
		<div class="detalhamento">
			<h4>Detalhamento da Meta</h4>
			<div class="informacoes">
				<div class="termos">
					<p class="titulo">Definição dos termos técnicos</p>
					<p class="info"><?php echo get_post_meta($post->ID, 'meta_termos_tecnicos', true);?></p>
				</div>
				
				<div class="entrega">
					<p class="titulo">O que vai ser entregue ?</p>
					<p class="info"><?php echo get_post_meta($post->ID, 'meta_entregue', true);?></p>
				</div>
			</div>
		</div>
		
		<h4>Observações</h4>
		<p class="info"><?php echo get_post_meta($post->ID, 'meta_observacoes', true);?></p>
		<h4>Custo total da meta</h4>
		<p class="info"><?php echo get_post_meta($post->ID, 'meta_custo_total', true);?></p>
		<div class="cronograma">
			<div class="conteudo">
				<h4>Cronograma de entrega</h4>
				<div class="um">
					<p class="titulo">2013-2014</p>
					<?php
					$cronograma1 = get_post_meta($post->ID, 'meta_cronograma_1', true);
					if(!empty($cronograma1)):
						$parts = explode(',', $cronograma1);
						foreach($parts as $p):
						?>
							<p class="info"><?php echo $p;?></p>
						<?php
						endforeach;
					endif;
					?>
				</div>
				<div class="dois">
					<p class="titulo">2015-2016</p>
					<?php
					$cronograma2 = get_post_meta($post->ID, 'meta_cronograma_2', true);
					if(!empty($cronograma2)):
						$parts = explode(',', $cronograma2);
						foreach($parts as $p):
						?>
							<p class="info"><?php echo $p;?></p>
						<?php
						endforeach;
					endif;
					?>
				</div>
			</div>	
		</div>
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