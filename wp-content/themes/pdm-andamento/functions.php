<?php
$api_address = get_option("pdm_andamento_api_address");

if (empty($api_address)) {
    wp_die("Você precisa configurar o tema antes de usá-lo. Vá nas <a href=\"\">configurações</a>.");
} else {
    define('API_URL', $api_address);
}

require "vendor/autoload.php";
require "routes.php";

show_admin_bar(false);
add_theme_support('post-formats');
add_theme_support('post-thumbnails');
add_theme_support('menus');

add_filter('get_twig', 'add_to_twig');
add_filter('timber_context', 'add_to_context');

add_action('wp_enqueue_scripts', 'load_scripts');

define('THEME_URL', get_template_directory_uri());

// This tells WordPress to call the function named "setup_theme_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_theme_admin_menus");

function setup_theme_admin_menus() {
    add_submenu_page('themes.php', 
        'Front Page Elements', 'Configurações', 'manage_options', 
        'front-page-elements', 'theme_front_page_settings'); 
}

function theme_front_page_settings() {
    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    $api_address = get_option("pdm_andamento_api_address");

    if (isset($_POST["update_settings"])) {
        $api_address = esc_attr($_POST["api_address"]);   
        update_option("pdm_andamento_api_address", $api_address);
        ?>
            <div id="message" class="updated">Configurações atualizadas com sucesso.</div>
        <?php
    }
?>
    <div class="wrap">
        <h2>Configurações do Programa de Metas</h2>
 
        <form method="POST" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="api_address">
                            Endereço da API:
                        </label> 
                    </th>
                    <td>
                        <input type="text" name="api_address" value="<?php echo $api_address;?>" size="25" />
                        <p>O endereço deve obrigatoriamente terminar com barra (/).</p>
                    </td>
                </tr>
            </table>
            <p>
                <input type="hidden" name="update_settings" value="Y" />
                <input type="submit" value="Salvar" class="button-primary"/>
            </p>
        </form>
    </div>
<?php
}

function add_to_context($data)
{
    /* this is where you can add your own data to Timber's context object */
//    $api = new Pdm\ApiClient;
//    $data['metas'] = $api->getMetasFiltradas();
    $data['menu'] = new TimberMenu();
    return $data;
}

function add_to_twig($twig)
{
    /* this is where you can add your own fuctions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    $twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
    return $twig;
}

function myfoo($text)
{
    $text .= ' bar!';
    return $text;
}

function load_scripts ()
{
    //wp_enqueue_script('jquery');
}
