<?php

Timber::add_route('meta/:id', function ($params) {
    return Pdm\PaginaMeta::startup($params);
});

Timber::add_route('projeto/:id', function ($params) {
    return Pdm\PaginaProjeto::startup($params);
});

// Timber::add_route('meta/:id/page/:pg', function ($params) {
//     $query = 'posts_per_page=3&post_type='.$params['name'].'&paged='.$params['pg'];
//     Timber::load_template('archive.php', $query);
// });
