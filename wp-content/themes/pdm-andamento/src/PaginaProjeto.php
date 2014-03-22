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

        $context['fases_projeto'] = $api->getFasesPorTipoProjeto($context['projeto']['project_type']);
        $context['progresso'] = $api->getProjetoProgresso($projeto_id);


        // necessario mover para a classe da api
        $status_total = 0;
        foreach ($context['progresso'] as $progresso) {
            if ($progresso['status'] == 50) {
                $status_total = $status_total + ($context['fases_projeto'][$progresso['milestone']]['percentage']/2);
            } elseif ($progresso['status'] > 50) {
                $status_total = $status_total + ($context['fases_projeto'][$progresso['milestone']]['percentage']);
            } else {
                $status_total = $status_total + 0;
            }
        }

        if ($status_total == 0) {
            $context['status']['descricao'] = 'Não iniciada';
        } elseif ($status_total > 0) {
            $context['status']['descricao'] = 'Em andamento';
        } elseif ($status_total == 100) {
            $context['status']['descricao'] = 'Concluído';
        }
        $context['status']['absoluto'] = $status_total;

        return $context;
    }
}
