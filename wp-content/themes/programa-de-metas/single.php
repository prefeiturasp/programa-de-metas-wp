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
	</div>
	
	<div class="detalhes">
		<?php
			foreach($terms as $t):
				if($t->parent == 0 && strpos($t->slug, 'eixo') !== false):
					$n = explode('-', $t->slug);
					$n = $n[1];
		?>
					<h4>Eixo Temático <?php echo $n;?>. <?php echo $t->description?></h4>
		<?php
				endif;
			endforeach;
		?>
		<h4>Objetivo temático associado</h4>
		<?php
			foreach($terms as $t):
				if(strpos($t->name, 'Objetivo') !== false):
		?>
					<p class="info"><b><?php echo $t->name;?>.</b> <?php echo $t->description;?></p>
		<?php
				endif;
			endforeach;
		?>
		<h4>Secretaria e unidade responsável</h4>
		<?php
			foreach($terms as $t):
				if($t->parent == 25):
		?>
					<p class="info"><?php echo $t->name;?></p>
		<?php
				endif;
			endforeach;
		?>
		<h4>Articulação territorial associada</h4>
		<?php
			foreach($terms as $t):
				if($t->parent == 53):
		?>
					<p class="info"><?php echo $t->name;?></p>
		<?php
				endif;
			endforeach;
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
			<b>46</b> Comentários
		</span>
	</div>
	<?php comments_template();?>
</div>