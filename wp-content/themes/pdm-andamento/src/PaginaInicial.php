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

        $context['total_metas'] = count($context['metas']);

        $context['subprefeitura_active'] = $_GET['subprefeitura'];
        if (!empty($_GET['subprefeitura'])) {
            $context['filtro_so_subprefeitura'] = 'sim';
        }
        return $context;
    }

    public static function buscaPorCoordenada($lat, $long)
    {
        $api = new ApiClient;
        return $api->getSubPrefeiturasPorCoordenadas($lat, $long);
    }
}
