<?php

namespace Pdm;

class PaginaInicial
{
    public static function get_context()
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        $context['metas'] = $api->getMetasFiltradas($projeto_id);
        $context['subprefeituras'] = $api->getSubPrefeituras();
        $context['objetivos'] = $api->getObjetivos();
        $context['secretarias'] = $api->getSecretarias();
        $context['eixos'] = $api->getEixos();
        $context['articulacoes'] = $api->getArticulacoes();

        return $context;
    }
}
