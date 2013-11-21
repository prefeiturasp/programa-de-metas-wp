<?php get_header(); ?>
    <div id="all">
        <div class="modal">
            
        </div>
        
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
        
        <div class="content">
            <h1 class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/img/logo-programa-de-metas.png">
            </h1>
            
            <p class="intro">
                O Programa de Metas 2013-2016 pode ser entendido como a consolidação do plano de governo Um Tempo Novo<br />
                Para São Paulo, que, em 2012, foi escolhido nas urnas pela maioria da população paulistana. O Programa<br />
                de Metas utiliza como fio condutor das metas o reordenamento territorial e a redução das desigualdades.
            </p>
            
            <div class="filters">
                <?php
                $eixos = filter_eixos();
                if(!empty($eixos)):
                    ?>
                        <ul class="eixos">
                            <?php
                                foreach($eixos as $eixo):
                            ?>
                                    <li>
                                        <a href="javascript:void(0);" class="<?php echo $eixo['slug'];?>">
                                            <span class="titulo"><?php echo $eixo['name'];?></span>
                                            <span class="descri"><?php echo $eixo['description'];?></span>
                                        </a>
                                    </li>
                            <?php
                                endforeach;
                            ?>
                        </ul>    
                    <?php
                endif;
                ?>
            </div>
            
            <div class="metas">
                <?php
                    $objetivo = get_term_by('slug', 'objetivo-1', 'metas-category', ARRAY_A);
                    if (!empty($objetivo)) {
                        $objetivoNome = $objetivo['name'];
                        $objetivoDescri = $objetivo['description'];
                        $objetivoSlug = $objetivo['slug'];
                        $eixo = get_term_by('id', $objetivo['parent'], 'metas-category', ARRAY_A);
                        if(!empty($eixo)):
                            $class = $eixo['slug'];
                            ?>
                                <div class="objetivo <?php echo $class;?>">
                                    <h2><?php echo $objetivoNome;?></h2>
                                    <p><?php echo $objetivoDescri;?></p>
                                </div>
            
                                <ul class="grid <?php echo $class;?>">
                                    <?php
                                    $WP_query = new WP_Query(array('post_type' => 'metas',
                                        'order' => 'ASC',
                                        'orderby' => 'date',
                                        'posts_per_page' => -1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'metas-category',
                                                'field' => 'slug',
                                                'terms' => $objetivoSlug
                                            )
                                        )
                                    ));
                                    $i = 1;
                                    while ($WP_query->have_posts()) : $WP_query->the_post();
                                        $terms = wp_get_post_terms($post->ID, 'metas-category');
                                        ?>
                                            <li>
                                                <a href="javascript:void(0);" class="meta-single" data-post="<?php echo $post->ID;?>" data-eixo="<?php echo $class;?>">
                                                    <h3><?php the_title();?></h3>
                                                    <div class="texto">
                                                        <?php the_content();?>
                                                    </div>
                                                    <h4>Articulação territorial</h4>
                                                    <?php
                                                        foreach($terms as $t):
                                                            if($t->parent == 53):
                                                    ?>
                                                                <p class="info"><?php echo $t->name;?></p>
                                                    <?php
                                                            endif;
                                                        endforeach;
                                                    ?>
                                                    <h4>Secretaria e unidade<br /> responsável</h4>
                                                    <?php
                                                        foreach($terms as $t):
                                                            if($t->parent == 25):
                                                    ?>
                                                                <p class="info"><?php echo $t->name;?></p>
                                                    <?php
                                                            endif;
                                                        endforeach;
                                                    ?>
                                                    <p class="custo"><?php echo get_post_meta($post->ID, 'meta_custo_total', true);?></p>
                                                </a>
                                            </li>
                                        <?php
                                        $i++;
                                    endwhile;
                                    ?>
                                </ul>
                            <?php
                        endif;
                    }
                ?>
            </div>
        </div>    
    </div>
<?php get_footer(); ?>