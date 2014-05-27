<?php

namespace Pdm;

class PaginaProjetos
{


    public static function startup($params)
    {
        $query = 'a=b';
        \Timber::load_template('projetos.php', $query);
    }


    public static function get_context()
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        return $context;
    }

    // public static function buscaPorCoordenada($lat, $long)
    // {
    //     $api = new ApiClient;
    //     return $api->getSubPrefeiturasPorCoordenadas($lat, $long);
    // }

    // public static function metaFollow($params)
    // {
    //     $api = new ApiClient;

    //     $valid = false;
    //     if ((!empty($params['name'])) &&
    //         (!empty($params['email']))) {

    //         $valid = true;
    //     }

    //     if (($valid) && ($api->seguirMeta($params['meta'], $params['name'], $params['email']))) {
    //         return '<h4>Olá ' . $params['name'] . ', seu e-email ' . $params['email'] .
    //                ' foi incluído com sucesso</h4>';
    //     } else {
    //         return 'Falha ao tentar cadastrar seu email. Verifique seus dados e tente novamente.';
    //     }
    // }
}
