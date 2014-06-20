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
            'agenda-pop-rua'        => 'http://www.prefeitura.sp.gov.br/cidade/secretarias/direitos_humanos/poprua/',
            'historia-africa'       => 'http://www.prefeitura.sp.gov.br/cidade/secretarias/igualdade_racial/',
            'juventude-viva'        => 'http://www.prefeitura.sp.gov.br/cidade/secretarias/direitos_humanos/juventude/',
            'sp-aberta'             => 'http://www.saopauloaberta.prefeitura.sp.gov.br/',
            'sp-carinhosa'          => 'http://www.saopaulocarinhosa.prefeitura.sp.gov.br/',
            'sp-mais-inclusiva'     => 'http://saopaulomaisinclusiva.prefeitura.sp.gov.br/'
            );


        if (!empty($context['meta']['transversalidade'])) {
            $transvs = split(',', $context['meta']['transversalidade']);
            $context['transversalidade'] = array();

            foreach ($transvs as $transv) {
                $context['transversalidade'][$transv] = array(
                    trim($transv) , $selos_links[trim($transv)]
                );
            }
        }

        $context['meta_grouped'] = $api->metas_agrupadas;
        $status_available = $prefecture_available = array();

        foreach ($context['meta']['projects'] as $key => $value) {

            $progresso = $api->getProjetoProgresso($value['id']);
            if ($value['project_type'] != 8) {
                $fases_projeto = $api->getFasesPorTipoProjeto($value['project_type']);
            }

            $status = $api->getProjetoStatus($progresso, $fases_projeto, $value['project_type'], $value['goal_id']);
            $context['meta']['projects'][$key]['status'] = $status;

            if ((!empty($status['descricao'])) && (!in_array($status['descricao'], $status_available))) {
                $status_available[] = $status['descricao'];
            }

            if (count($value['prefectures']) > 0) {
                foreach ($value['prefectures'] as $prefectures) {
                    $prefecture_available[] = $prefectures['id'];
                }
            }
        }

        $context['prefecture_available'] = $prefecture_available;
        $context['status_available'] = $status_available;

        $context['progresso'] = $api->getMetaProgresso($meta_id);

        $executado = 0;
        foreach ($context['meta']['projects'] as $project) {
            $executado = $executado + $project['budget_executed'];
        }
        $context['executado'] = $executado;

        return $context;
    }
}
