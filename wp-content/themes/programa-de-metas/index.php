<?php get_header(); ?>
    <div id="all">
        <div class="modal">
            
        </div>
        
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
        
        <div class="content">
            <h1 class="logo">
                <a href="http://programademetas.info"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-programa-de-metas.png"><a/>
            </h1>
            
            <p class="intro">
                Reduzir as desigualdades em uma cidade do tamanho e da complexidade de São Paulo não é tarefa fácil. O Programa de Metas 2013-2016 reconhece os limites de seu horizonte temporal para fazer frente a uma história de ações desordenadas e concentradoras sobre o território paulistano. Ao mesmo tempo, propõe-se a dar os primeiros passos no caminho da construção de um processo de planejamento participativo e transparente que aponte os eixos de superaçãodas desigualdades sociais, econômicas e regionais.
            </p>
            <a href="<?php echo bloginfo('url');?>/conheca-o-programa/" class="leia-mais">Leia mais >></a>
           <!-- <p class="intro">
                O esforço de elaboração do Programa de Metas 2013-2016 foi o de ir além da lista de metas, apontando objetivos estratégicos, eixos estruturantes e articulações territoriais sobre os quais se pretende alcançar resultados efetivos. Tais objetivos, eixos e articulações, em conjunto com a participação popular no processo, são a verdadeira ponte para a elaboração de um projeto de cidade. A possibilidade de transformação desse projeto em realidade passa pela execução das metas, mas passa também pela continuidade do acompanhamento desses aspectos estratégicos, pela capacidade de ajuste de percurso e, principalmente, pela apropriação desse projeto pela população. O Programa de Metas 2013-2016 pode ser o começo de uma grande mudança. Esperamos que os paulistanos aceitem o convite e nos acompanhem na construção desse novo modelo de planejamento público e compreensão da ação sobre a cidade.
            </p> -->
            
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
                                        <a href="javascript:void(0);" class="<?php echo $eixo['slug'];?> eixo-filter" data-slug="<?php echo $eixo['slug'];?>">
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
                
                <!--form id="filtros">
                    <input type="hidden" name="action" value="infinite_scroll">
                    <ul class="outros-filtros">
                        <li>
                            <select name="articulacao" class="select-filters">
                                <option value="">Articulação</option>
                                <?php
                                    $articulacoes = filter_articulacoes();
                                    if(!empty($articulacoes)):
                                        foreach($articulacoes as $articulacao):
                                            ?>
                                                <option value="<?php echo $articulacao['slug'];?>"><?php echo $articulacao['name'];?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </li>
                        
                        <li>
                            <select name="objetivo" class="select-objetivos">
                                <option value="">Objetivo</option>
                                <?php
                                    $objetivos = filter_objetivos();
                                    if(!empty($objetivos)):
                                        foreach($objetivos as $objetivo):
                                            ?>
                                                <option value="<?php echo $objetivo['slug'];?>"><?php echo $objetivo['name'];?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </li>
                        
                        <li>
                            <select name="secretaria" class="select-secretaria">
                                <option value="">Secretaria</option>
                                <?php
                                    $secretarias = filter_secretarias();
                                    if(!empty($secretarias)):
                                        foreach($secretarias as $secretaria):
                                            ?>
                                                <option value="<?php echo $secretaria['slug'];?>"><?php echo $secretaria['name'];?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </li>
                    </ul>
                    <div class="buscar">
                        <input type="submit" value="buscar">
                    </div>
                </form-->
                <img class="breve" src="<?php echo get_template_directory_uri(); ?>/img/breve.png">
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
                                    echo '<div style="width:100%;float:left;">';
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
                                            echo ($i%3 == 0) ? '</div><div style="width:100%;float:left;">' : '';
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