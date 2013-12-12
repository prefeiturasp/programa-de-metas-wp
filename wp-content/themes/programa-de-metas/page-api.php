<?php
    /*
    Template Name: Api
    */
    
    $taxParams = array();
    if (!empty($_GET['eixo'])) {
        $eixo = $_GET['eixo'];
        $taxParams[] = array(
			'taxonomy' => 'eixos',
			'field' => 'slug',
			'terms' => 'eixo-' . $eixo
		);	
    }
    
    if (!empty($_GET['objetivo'])) {
        $objetivo = $_GET['objetivo'];
        $taxParams[] = array(
			'taxonomy' => 'objetivos',
			'field' => 'slug',
			'terms' => 'objetivo-' . $objetivo
		);	
    }
    
    if (!empty($_GET['secretaria'])) {
        $secretaria = $_GET['secretaria'];
        $taxParams[] = array(
			'taxonomy' => 'secretarias',
			'field' => 'slug',
			'terms' => $secretaria
		);	
    }
    
    if (!empty($_GET['articulacao'])) {
        $articulacao = $_GET['articulacao'];
        $taxParams[] = array(
			'taxonomy' => 'articulacoes',
			'field' => 'slug',
			'terms' => $articulacao
		);	
    }
    
    $WP_query = new WP_Query(array('post_type' => 'metas',
        'order' => 'ASC',
        'orderby' => 'date',
        'posts_per_page' => -1,
        'tax_query' => $taxParams
    ));
    
    $metas = array();
    if ($WP_query->have_posts()) {
        while($WP_query->have_posts()){
            $WP_query->the_post();
            $articulacao = wp_get_post_terms($post->ID, 'articulacoes');
            if(!empty($articulacao)) {
                $articulacao = $articulacao[0]->name;    
            }
            
            $secretaria = wp_get_post_terms($post->ID, 'secretarias');
            if(!empty($secretaria)) {
                $secretaria = $secretaria[0]->name;    
            }
            
            $objetivo = wp_get_post_terms($post->ID, 'objetivos');
            if(!empty($objetivo)) {
                $objetivo = $objetivo[0]->name;    
            }
            
            $eixo = wp_get_post_terms($post->ID, 'eixos');
            if(!empty($eixo)) {
                $eixo = $eixo[0]->name;    
            }
            
            $metas[] = array(
                'titulo' => get_the_title(),
                //'texto' => get_the_content(),
                'articulacao' => $articulacao,
                'secretaria' => $secretaria,
                'eixo' => $eixo,
                'objetivo' => $objetivo
            );
        }
    }
    echo json_encode($metas);die;
?>