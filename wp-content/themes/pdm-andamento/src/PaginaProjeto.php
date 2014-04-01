<?php

namespace Pdm;

use Pdm\ApiClient;

class PaginaProjeto extends Pagina
{

    public static function startup ($params)
    {
        $query = 'projeto_id='.$params['id'];
        \Timber::load_template('projeto.php', $query);
    }

    public static function get_context($projeto_id)
    {
        $context = \Timber::get_context();
        $api = new ApiClient;

        $context['subprefeituras'] = $api->getSubPrefeituras();
        $context['objetivos'] = $api->getObjetivos();
        $context['secretarias'] = $api->getSecretarias();
        $context['eixos'] = $api->getEixos();
        $context['articulacoes'] = $api->getArticulacoes();
        $context['tipos_projeto'] = $api->getTiposProjeto();

        $context['projeto'] = $api->getProjeto($projeto_id);
        $context['meta_relacionada'] = $api->getMeta($context['projeto']['goal_id']);

        if ($context['projeto']['project_type'] != 8) {
            $context['fases_projeto'] = $api->getFasesPorTipoProjeto($context['projeto']['project_type']);
        }

        $context['progresso'] = $api->getProjetoProgresso($projeto_id);

        $context['status'] = $api->getProjetoStatus($context['progresso'], $context['fases_projeto'], $context['projeto']['project_type'], $context['projeto']['goal_id']);

        if ($context['projeto']['project_type'] == 8) {
            $context['progresso'] = $api->preparaDadosMesAMesPorPrefeitura($context['progresso']);
        }

        return $context;
    }
}
