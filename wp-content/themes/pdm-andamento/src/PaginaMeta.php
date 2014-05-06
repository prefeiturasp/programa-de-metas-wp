<?php

namespace Pdm;

use Pdm\ApiClient;

class PaginaMeta extends Pagina
{

    public static function startup ($params)
    {
        $query = 'meta_id='.$params['id'];
        \Timber::load_template('meta.php', $query);
    }

    public static function get_context($meta_id)
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        $context['meta'] = $api->getMeta($meta_id);

        $context['subprefeituras'] = $api->getSubPrefeituras();
        $context['objetivos'] = $api->getObjetivos();
        $context['secretarias'] = $api->getSecretarias();
        $context['eixos'] = $api->getEixos();
        $context['articulacoes'] = $api->getArticulacoes();
        $context['tipos_projeto'] = $api->getTiposProjeto();

        $selos_links = array(
            'agenda-pop-rua'        => 'https://saopauloaberta.prefeitura.sp.gov.br',
            'historia-africa'       => 'https://saopauloaberta.prefeitura.sp.gov.br',
            'juventude-viva'        => 'https://saopauloaberta.prefeitura.sp.gov.br',
            'sp-aberta'             => 'https://saopauloaberta.prefeitura.sp.gov.br',
            'sp-carinhosa'          => 'https://saopauloaberta.prefeitura.sp.gov.br',
            'sp-mais-inclusiva'     => 'https://saopauloaberta.prefeitura.sp.gov.br'
            );

        $transvs = split(',',$context['meta'][transversalidade]);
        $context['transversalidade'] = array();

        foreach ($transvs as $transv) {
            $context['transversalidade'][$transv] = array(
                trim($transv) , $selos_links[trim($transv)]
            );
        }

        $context['meta_grouped'] = $api->metas_agrupadas;

        //$context['fases_projeto'] = $api->getFasesPorTipoProjeto($context['meta']['projects'][0]['project_type']);
        $context['progresso'] = $api->getMetaProgresso($meta_id);

        $executado = 0;
        foreach ($context['meta']['projects'] as $project) {
            $executado = $executado + $project['budget_executed'];
        }
        $context['executado'] = $executado;

        return $context;
    }
}
