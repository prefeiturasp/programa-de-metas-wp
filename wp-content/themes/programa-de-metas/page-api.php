<?php
    /*
    Template Name: Api
    */

    if (!empty($_GET['filtros'])) {
        
    }
    $WP_query = new WP_Query(array('post_type' => 'metas',
        'order' => 'ASC',
        'orderby' => 'date',
        'posts_per_page' => -1,
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