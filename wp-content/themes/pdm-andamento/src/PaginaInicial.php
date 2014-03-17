<?php

namespace Pdm;

class PaginaInicial
{
    public static function get_context()
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        $context['metas'] = $api->getMetasFiltradas($projeto_id);
        return $context;
    }
}
