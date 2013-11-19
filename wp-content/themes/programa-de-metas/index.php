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
                                        <a href="" class="<?php echo $eixo['slug'];?>">
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
            
            <?php
                /*$WP_query = new WP_Query(array('post_type' => 'metas',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'metas-category',
                            'field' => 'slug',
                            'terms' => 'objetivo-1'
                        )
                    )
                ));
                print_r($WP_query);
                while ($WP_query->have_posts()) : $WP_query->the_post();
                    the_title();
                endwhile;die;*/
                $term = get_term_by('slug', 'objetivo-1', 'metas-category', ARRAY_A);
                if (!empty($term)) {
                    $parent = get_term_by('id', $term['parent'], 'metas-category', ARRAY_A);
                    if (!empty($parent)) {
                        $class = $parent['slug'];
                    }
                }
            ?>
            
            <div class="metas">
                <div class="objetivo <?php echo $class;?>">
                    <h2>Objetivo 1</h2>
                    <p>Superar a extrema pobreza na cidade de São Paulo, elevando a renda, promovendo a inclusão produtiva e o acesso a serviços públicos para todos.</p>
                </div>
            
                <ul class="grid <?php echo $class;?>">
                    <li>
                        <a href="">
                            <h3>1</h3>
                            <div class="texto">
                                <p>Inserir aproximadamente 280 mil famílias com renda de até meio salário mínimo no Cadastro Único para atingir 773 mil famílias cadastradas</p>
                            </div>
                            <h4>Articulação territorial</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <h4>Secretaria e unidade<br /> responsável</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <p class="custo">R$ 224 milhões</p>
                        </a>
                    </li>
                    
                    <li>
                        <a href="">
                            <h3>1</h3>
                            <div class="texto">
                                <p>Inserir aproximadamente 280 mil famílias com renda de até meio salário mínimo no Cadastro Único para atingir 773 mil famílias cadastradas</p>
                            </div>
                            <h4>Articulação territorial</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <h4>Secretaria e unidade<br /> responsável</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <p class="custo">R$ 224 milhões</p>
                        </a>
                    </li>
                    
                    <li>
                        <a href="" class="last">
                            <h3>1</h3>
                            <div class="texto">
                                <p>Inserir aproximadamente 280 mil famílias com renda de até meio salário mínimo no Cadastro Único para atingir 773 mil famílias cadastradas</p>
                            </div>
                            <h4>Articulação territorial</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <h4>Secretaria e unidade<br /> responsável</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <p class="custo">R$ 224 milhões</p>
                        </a>
                    </li>
                    
                    <li>
                        <a href="">
                            <h3>1</h3>
                            <div class="texto">
                                <p>Inserir aproximadamente 280 mil famílias com renda de até meio salário mínimo no Cadastro Único para atingir 773 mil famílias cadastradas</p>
                            </div>
                            <h4>Articulação territorial</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <h4>Secretaria e unidade<br /> responsável</h4>
                            <p class="info">Resgate da Cidanania nos Territórios mais vulneráveis; Reordenação da fronteira ambiental.</p>
                            <p class="custo">R$ 224 milhões</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>    
    </div>
<?php get_footer(); ?>