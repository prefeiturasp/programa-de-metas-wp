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
        return $context;
    }
}
