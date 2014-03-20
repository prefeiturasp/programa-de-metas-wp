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
        return $context;
    }
}
