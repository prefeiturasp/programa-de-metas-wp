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

        $context['meta_grouped'] = array(
                11, // (consultórios na rua),
                35, // (Unid. Habitacionais),
                37, // (Regularização fundiária),
                42, // (Casas de mediação),
                47, // (Esporte 24h),
                54, // (CEFAI),
                73, // (Praças wifi),
                89, // (Coleta seletiva),
                97 // (ciclovias)
        );

        //TODO: deve ser inserido o suporte a múltiplos tipos de projeto por meta
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
