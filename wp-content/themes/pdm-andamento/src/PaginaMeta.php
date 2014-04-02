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
