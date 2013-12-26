<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '', 
		'container'       => 'div', 
		'container_class' => 'menu-{menu slug}-container', 
		'container_id'    => '',
		'menu_class'      => 'menu', 
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if (!is_admin()) {
    
    	wp_deregister_script('jquery'); // Deregister WordPress jQuery
    	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js', array(), '1.9.1'); // Google CDN jQuery
    	wp_enqueue_script('jquery'); // Enqueue it!
    	
    	//wp_register_script('conditionizr', 'http://cdnjs.cloudflare.com/ajax/libs/conditionizr.js/2.2.0/conditionizr.min.js', array(), '2.2.0'); // Conditionizr
        //wp_enqueue_script('conditionizr'); // Enqueue it!
        
        wp_register_script('modernizr', 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), '2.6.2'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!
        
        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
		
		wp_register_script('dropkick', get_template_directory_uri() . '/js/jquery.dropkick-min.js'); // Modernizr
        wp_enqueue_script('dropkick'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!
    
    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
	
	wp_register_style('fonts', 'http://fonts.googleapis.com/css?family=Tinos:400,700,400italic,700italic');
    wp_enqueue_style('fonts'); // Enqueue it!
	
	wp_register_style('montserrat', 'http://fonts.googleapis.com/css?family=Montserrat:400,700');
    wp_enqueue_style('montserrat'); // Enqueue it!
	
	wp_register_style('dropkick',  get_template_directory_uri() . '/css/dropkick.css');
    wp_enqueue_style('dropkick'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

// programa de metas

/*CUSTOM METAS*/
add_action('init', 'metas_register');
function metas_register() {
	$labels = array(
      'name' => __('Metas'),
      'singular_name' => __('Meta'),
      'add_new' => __('Nova meta'),
      'add_new_item' => __('Adicionar'),
      'edit_item' => __('Editar'),
      'new_item' => __('Nova'),
      'view_item' => __('Ver'),
      'search_items' => __('Procurar'),
      'not_found' =>  __('Nada encontrado'),
      'not_found_in_trash' => __('Nada encontrado na lixeira'),
      'parent_item_colon' => ''
    );
    $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'metas'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'page-attributes', 'comments', 'thumbnail'),
		'taxonomies' => array('metas-category')
    );
    register_post_type('metas', $args );
    flush_rewrite_rules();
}

add_action('admin_init', 'metas_create');

function create_metascategory_taxonomy() {

    $labels = array(
        'name' => _x( 'Categorias', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Category' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('metas-category', 'metas', array(
        'label' => __('Categoria'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'metas-category'),
    ));
}

add_action('init', 'create_metascategory_taxonomy', 0);

function create_eixos_taxonomy() {

    $labels = array(
        'name' => _x( 'Eixos', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Editar Eixo' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('eixos', 'metas', array(
        'label' => __('Eixos'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'eixos'),
    ));
}

add_action('init', 'create_eixos_taxonomy', 0);

function create_objetivos_taxonomy() {

    $labels = array(
        'name' => _x( 'Objetivos', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => __('Eixos'),
        'parent_item_colon' => null,
        'edit_item' => __( 'Editar Objetivo' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('objetivos', 'metas', array(
        'label' => __('Objetivos'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'objetivos'),
    ));
}

add_action('init', 'create_objetivos_taxonomy', 0);

function create_secretaria_taxonomy() {

    $labels = array(
        'name' => _x( 'Secretaria', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Editar secretaria' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('secretarias', 'metas', array(
        'label' => __('Secretarias'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'secretarias'),
    ));
}

add_action('init', 'create_secretaria_taxonomy', 0);

function create_articulacoes_taxonomy() {

    $labels = array(
        'name' => _x( 'Articulações', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Editar secretaria' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('articulacoes', 'metas', array(
        'label' => __('Articulações'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'articulacoes'),
    ));
}

add_action('init', 'create_articulacoes_taxonomy', 0);

function create_subprefeituras_taxonomy() {

    $labels = array(
        'name' => _x( 'Subprefeituras', 'taxonomy general name' ),
        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Editar subprefeitura' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('subprefeituras', 'metas', array(
        'label' => __('Subprefeituras'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'subprefeituras'),
    ));
}

add_action('init', 'create_subprefeituras_taxonomy', 0);

function metas_create() {
    add_meta_box('metas_meta_termos_tecnicos', 'Definições dos termos técnicos', 'metas_meta_termos_tecnicos', 'metas');
	add_meta_box('metas_meta_o_que_vai_ser_entregue', 'O que vai ser entregue', 'metas_meta_o_que_vai_ser_entregue', 'metas');
	add_meta_box('metas_meta_custo_total', 'Custo total', 'metas_meta_custo_total', 'metas');
	add_meta_box('metas_meta_cronograma_1', 'Cronograma 2013-2014', 'metas_meta_cronograma_1', 'metas');
	add_meta_box('metas_meta_cronograma_2', 'Cronograma 2015-2016', 'metas_meta_cronograma_2', 'metas');
	add_meta_box('metas_meta_observacoes', 'Observações', 'metas_meta_observacoes', 'metas');
}

function metas_meta_termos_tecnicos() {
	global $post;
    $custom = get_post_custom($post->ID);
    $meta_value = $custom["meta_termos_tecnicos"][0];

    ?>
    <div class="meta">
      <input type="hidden" name="metas-nonce" value="<?php echo wp_create_nonce('metas-nonce'); ?>" />
      <!--textarea name="meta_termos_tecnicos" class="link" style="width:90%; height: 140px;"><?php echo $meta_value; ?></textarea-->
	  <?php wp_editor($meta_value, 'meta-termos-tecnicos', array('textarea_name' => 'meta_termos_tecnicos')); ?> 
    </div>
    <?php
}

function metas_meta_o_que_vai_ser_entregue() {
	global $post;
    $custom = get_post_custom($post->ID);
    $meta_value = $custom["meta_entregue"][0];

    ?>
    <div class="meta">
      <input type="hidden" name="metas-nonce" value="<?php echo wp_create_nonce('metas-nonce'); ?>" />
      <input type="text" name="meta_entregue" class="link" value="<?php echo $meta_value; ?>" style="width:90%" />
    </div>
    <?php
}

function metas_meta_custo_total() {
	global $post;
    $custom = get_post_custom($post->ID);
    $meta_value = $custom["meta_custo_total"][0];

    ?>
    <div class="meta">
      <input type="hidden" name="metas-nonce" value="<?php echo wp_create_nonce('metas-nonce'); ?>" />
      <input type="text" name="meta_custo_total" class="link" value="<?php echo $meta_value; ?>" style="width:90%" />
    </div>
    <?php
}

function metas_meta_cronograma_1() {
	global $post;
    $custom = get_post_custom($post->ID);
    $meta_value = $custom["meta_cronograma_1"][0];

    ?>
    <div class="meta">
      <input type="hidden" name="metas-nonce" value="<?php echo wp_create_nonce('metas-nonce'); ?>" />
      <input type="text" name="meta_cronograma_1" class="link" value="<?php echo $meta_value; ?>" style="width:90%" />
    </div>
    <?php
}

function metas_meta_cronograma_2() {
	global $post;
    $custom = get_post_custom($post->ID);
    $meta_value = $custom["meta_cronograma_2"][0];

    ?>
    <div class="meta">
      <input type="hidden" name="metas-nonce" value="<?php echo wp_create_nonce('metas-nonce'); ?>" />
      <input type="text" name="meta_cronograma_2" class="link" value="<?php echo $meta_value; ?>" style="width:90%" />
    </div>
    <?php
}

function metas_meta_observacoes() {
	global $post;
    $custom = get_post_custom($post->ID);
    $meta_value = $custom["meta_observacoes"][0];

    ?>
    <div class="meta">
      <input type="hidden" name="metas-nonce" value="<?php echo wp_create_nonce('metas-nonce'); ?>" />
      <textarea name="meta_observacoes" class="link" style="width:90%; height: 140px;"><?php echo $meta_value; ?></textarea>
    </div>
    <?php
}

add_action ('save_post', 'save_metas');

function save_metas(){
    global $post;
	
    if ( !wp_verify_nonce($_POST['metas-nonce'], 'metas-nonce')) {
        return $post->ID;
    }

    if ( !current_user_can('edit_post', $post->ID))
        return $post->ID;
	
    update_post_meta($post->ID, "meta_termos_tecnicos", $_POST['meta_termos_tecnicos']);
	update_post_meta($post->ID, "meta_entregue", $_POST['meta_entregue']);
	update_post_meta($post->ID, "meta_custo_total", $_POST['meta_custo_total']);
	update_post_meta($post->ID, "meta_observacoes", $_POST['meta_observacoes']);
	update_post_meta($post->ID, "meta_cronograma_1", $_POST['meta_cronograma_1']);
	update_post_meta($post->ID, "meta_cronograma_2", $_POST['meta_cronograma_2']);
}

function filter_eixos() {
	$eixos = get_categories(
		array(
			'orderby' => 'name',
			'hide_empty' => 0,
			'taxonomy' => 'eixos'
		)
	);
	
	if (!empty($eixos)) {
		$outPut = array();
		foreach ($eixos as $eixo){
			if (strpos($eixo->name, 'Eixo') !== false) {
				$outPut[] = array(
					'name' => $eixo->name,
					'slug' => $eixo->slug,
					'description' => $eixo->description
				);	
			}
		}
		return $outPut;
	}
	return false;
}

function filter_articulacoes() {
	$articulacoes = get_categories(
		array(
			'orderby' => 'name',
			'hide_empty' => 0,
			'taxonomy' => 'articulacoes'
		)
	);
	
	if (!empty($articulacoes)) {
		$outPut = array();
		foreach ($articulacoes as $articulacao){
			$outPut[] = array(
				'name' => $articulacao->name,
				'slug' => $articulacao->slug,
				'description' => $articulacao->description
			);
		}
		return $outPut;
	}
	return false;
}

function filter_objetivos() {
	$outPut = array();
	for ($i = 1; $i<=20; $i++) {
		$outPut[] = array(
			'name' => 'Objetivo ' . $i,
			'slug' => 'objetivo-' . $i,
		);
	}
	return $outPut;
}

function filter_secretarias() {
	$secretarias = get_categories(
		array(
			'orderby' => 'name',
			'hide_empty' => 0,
			'taxonomy' => 'secretarias'
		)
	);
	
	if (!empty($secretarias)) {
		$outPut = array();
		foreach ($secretarias as $secretaria){
			$outPut[] = array(
				'name' => $secretaria->name,
				'slug' => $secretaria->slug,
				'description' => $secretaria->description
			);
		}
		return $outPut;
	}
	return false;
}

add_action('wp_ajax_load_metas_filter_bolinhas', 'load_metas_filter_bolinhas');
add_action('wp_ajax_nopriv_load_metas_filter_bolinhas', 'load_metas_filter_bolinhas');

add_action('wp_ajax_load_metas_filter', 'load_metas_filter');
add_action('wp_ajax_nopriv_load_metas_filter', 'load_metas_filter');

function load_metas_filter_bolinhas() {
	global $post;
	$eixo = 'eixo-1';
	for ($i=1; $i<=20; $i++) {
		if ($i >= 12 && $i < 18) {
			$eixo = 'eixo-2';
		} else if ($i >= 18) {
			$eixo = 'eixo-3';
		}
		$objetivo = get_term_by('slug', 'objetivo-' . $i, 'objetivos', ARRAY_A);
		if (!empty($objetivo)) {
			$objetivoNumero = explode('-', $objetivo['slug']);
			$objetivoNumero = $objetivoNumero[1];
			$WP_query = new WP_Query(array('post_type' => 'metas',
				'order' => 'ASC',
				'orderby' => 'date',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'objetivos',
						'field' => 'slug',
						'terms' => $objetivo['slug']
					)
				)
			));
			if ($WP_query->have_posts()) {
				?>
				<ul class="<?php echo $eixo;?>">
						<li>
							<a href="" class="bolinha-objetivo">
								<div class="img-container">
									<img src="<?php echo get_template_directory_uri(); ?>/img/icones/objetivo-<?php echo $objetivoNumero;?>.png"/>
								</div>
								<span><?php echo $objetivoNumero;?></span>
							</a>
						</li>
					<?php
						$x = 1;
						while ($WP_query->have_posts()) : $WP_query->the_post();
						$bottom = $x * 45;
					?>
							<li>
								<a href="javascript:void(0);" style="bottom:<?php echo $bottom . 'px';?>" alt="<?php the_title();?>" class="meta-single" data-post="<?php echo $post->ID;?>" data-eixo="<?php echo $eixo;?>">
									<div class="hover">
										<div class="seta"></div>
										<div class="texto"><?php echo remove_images(get_the_content());?></div>
									</div>
								</a>
							</li>
					<?php
						$x++;
					endwhile;
					?>
				</ul>
				<?php
			}
		}
	}die();
}

function load_metas_filter() {
	global $post;
	$tax_art = '';
	$tax_sec = '';
	$eixo = 'eixo-1';
	
	if (!empty($_POST['eixo'])) {
		$eixo = $_POST['eixo'];
	}
	
	if (!empty($_POST['articulacao'])) {
		$tax_art = array(
			'taxonomy' => 'articulacoes',
			'field' => 'slug',
			'terms' => $_POST['articulacao']
		);	
	}
	
	if (!empty($_POST['secretaria'])) {
		$tax_sec = array(
			'taxonomy' => 'secretarias',
			'field' => 'slug',
			'terms' => $_POST['secretaria']
		);
	}
	
	if (empty($_POST['objetivo'])) {
		$objetivos = get_terms('objetivos', array('orderby' => 'id', 'order' => 'ASC'));		
		foreach ($objetivos as $objetivo) {
			$tax_obj = array(
				'taxonomy' => 'objetivos',
				'field' => 'slug',
				'terms' => $objetivo->slug
			);
			
			$splitedSlug = explode('-', $objetivo->slug);
			if ($splitedSlug[1] >= 12 && $splitedSlug < 18) {
				$eixo = 'eixo-2';
			} else if ($splitedSlug[1] >= 18) {
				$eixo = 'eixo-3';
			}
			
			load_objetivos($tax_obj, $objetivo, $eixo, $tax_art, $tax_sec);
		}
	} else {
		$objetivo = get_term_by('slug', $_POST['objetivo'], 'objetivos');
		
		if (empty($_POST['eixo'])) {
			$splitedSlug = explode('-', $objetivo->slug);
			if ($splitedSlug[1] >= 12 && $splitedSlug < 18) {
				$eixo = 'eixo-2';
			} else if ($splitedSlug[1] >= 18) {
				$eixo = 'eixo-3';
			}
		}
		
		$tax_obj = array(
			'taxonomy' => 'objetivos',
			'field' => 'slug',
			'terms' => $objetivo->slug
		);
		load_objetivos($tax_obj, $objetivo, $eixo, $tax_art, $tax_sec);
	}
	die();
}

function load_objetivos($tax_obj, $objetivo, $eixo, $tax_art = '', $tax_sec = '') {
	global $post;
	
	$WP_query = new WP_Query(array('post_type' => 'metas',
		'order' => 'ASC',
		'orderby' => 'date',
		'posts_per_page' => -1,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'eixos',
				'field' => 'slug',
				'terms' => $eixo
			),
			$tax_obj,
			$tax_art,
			$tax_sec
		)
	));
	
	if($WP_query->have_posts()):
	?>
		<div class="objetivo <?php echo $eixo;?>">
			<h2><?php echo $objetivo->name;?></h2>
			<p><?php echo $objetivo->description;?></p>
		</div>
		
		<ul class="grid <?php echo $eixo;?>">
			<?php
				$i = 1;
				echo '<div style="width:100%;float:left;">';
				while ($WP_query->have_posts()) : $WP_query->the_post();
					?>
					<li>
						<a href="javascript:void(0);" class="meta-single" data-post="<?php echo $post->ID;?>" data-eixo="<?php echo $eixo;?>">
							<h3><?php the_title();?></h3>
							<div class="conteudo">
								<div class="texto">
									<?php
										if (has_post_thumbnail($post->ID)) {
											echo get_the_post_thumbnail($post->ID);    
										}
									?>
									<p><?php echo remove_images(get_the_content());?></p>
								</div>
								<h4>Articulação territorial</h4>
								<?php
									$articulacao = wp_get_post_terms($post->ID, 'articulacoes');
									if(!empty($articulacao)):
										?>
											<p class="info"><?php echo $articulacao[0]->name;?></p>
										<?php
									endif;
								?>
								<h4>Secretaria e unidade<br /> responsável</h4>
								<?php
									$secretaria = wp_get_post_terms($post->ID, 'secretarias');
									if(!empty($secretaria)):
										?>
											<p class="info"><?php echo $secretaria[0]->name;?></p>
										<?php
									endif;
								?>
								<p class="custo"><?php echo get_post_meta($post->ID, 'meta_custo_total', true);?></p>
								<div class="comentarios">
									<span class="balao"></span>
									<span class="numero">
										<?php
											$countComments = wp_count_comments($post->ID);
										?>
										<b><?php echo $countComments->approved;?></b> comentários
									</span>
								</div>
							</div>
						</a>
					</li>
				<?php
					echo ($i%3 == 0) ? '</div><div style="width:100%;float:left;">' : '';
					$i++;
			endwhile;
			?>
		</ul>
	<?php
	else:
		?>
			<!--p class="not-found">Nenhuma meta encontrada</p-->
		<?php
	endif;
}

function load_metas() {
	global $post;
	$eixo = 'eixo-1';
	$filters = array();
	$tax_query = array();
	
	if (!empty($_POST['eixo'])) {
		$eixo = $_POST['eixo'];
		$tax_query[] = array(
			'taxonomy' => 'eixos',
			'field' => 'slug',
			'terms' => $eixo
		);	
	}
	
	if (!empty($_POST['objetivo'])) {
		$objetivo = get_term_by('slug', $_POST['objetivo'], 'objetivos');
		$splitedObj = explode('-', $objetivo->slug);
		if ($splitedObj[1] >= 12) {
			$eixo = 'eixo-2';
		}
		$tax_query[] = array(
			'taxonomy' => 'objetivos',
			'field' => 'slug',
			'terms' => $objetivo
		);
	} else {
		$objetivo = get_terms('objetivos', array('orderby' => 'id', 'order' => 'ASC'));
	}
	foreach($objetivo as $o):
		
	endforeach;
	
	$WP_query = new WP_Query(array('post_type' => 'metas',
		'order' => 'ASC',
		'orderby' => 'date',
		'posts_per_page' => -1,
		'tax_query' => $tax_query
	));
	
	if($WP_query->have_posts()):
	?>
		<div class="objetivo <?php echo $eixo;?>">
			<h2><?php echo $objetivo->name;?></h2>
			<p><?php echo $objetivo->description;?></p>
		</div>
		
		<ul class="grid <?php echo $eixo;?>">
			<?php
				$i = 1;
				echo '<div style="width:100%;float:left;">';
				while ($WP_query->have_posts()) : $WP_query->the_post();
					?>
					<li>
						<a href="javascript:void(0);" class="meta-single" data-post="<?php echo $post->ID;?>" data-eixo="<?php echo $eixo;?>">
							<h3><?php the_title();?></h3>
							<div class="conteudo">
								<div class="texto">
									<?php
										if (has_post_thumbnail($post->ID)) {
											echo get_the_post_thumbnail($post->ID);    
										}
									?>
									<p><?php echo remove_images(get_the_content());?></p>
								</div>
								<h4>Articulação territorial</h4>
								<?php
									$articulacao = wp_get_post_terms($post->ID, 'articulacoes');
									if(!empty($articulacao)):
										?>
											<p class="info"><?php echo $articulacao[0]->name;?></p>
										<?php
									endif;
								?>
								<h4>Secretaria e unidade<br /> responsável</h4>
								<?php
									$secretaria = wp_get_post_terms($post->ID, 'secretarias');
									if(!empty($secretaria)):
										?>
											<p class="info"><?php echo $secretaria[0]->name;?></p>
										<?php
									endif;
								?>
								<p class="custo"><?php echo get_post_meta($post->ID, 'meta_custo_total', true);?></p>
								<div class="comentarios">
									<span class="balao"></span>
									<span class="numero">
										<?php
											$countComments = wp_count_comments($post->ID);
										?>
										<b><?php echo $countComments->approved;?></b> comentários
									</span>
								</div>
							</div>
						</a>
					</li>
				<?php
					echo ($i%3 == 0) ? '</div><div style="width:100%;float:left;">' : '';
					$i++;
			endwhile;
			?>
		</ul>
	<?php
	endif;
}

add_action('wp_ajax_infinite_scroll', 'load_metas');
add_action('wp_ajax_nopriv_infinite_scroll', 'load_metas');

function load_by_sub() {
	global $post;
	if (!empty($_POST['subprefeitura'])) {
		$subPrefeituras = explode(',', $_POST['subprefeitura']);
		
		if (count($subPrefeituras) > 0) {
			foreach ($subPrefeituras as $sub) {
				$WP_query = new WP_Query(array('post_type' => 'metas',
					'order' => 'ASC',
					'orderby' => 'date',
					'posts_per_page' => -1,
					'tax_query' => array(
						array(
							'taxonomy' => 'subprefeituras',
							'field' => 'slug',
							'terms' => $sub
						)
					)
				));
				if($WP_query->have_posts()):
					$nomeSub = get_term_by('slug', $sub, 'subprefeituras', ARRAY_A);
				?>
				<div class="nome-sub">
					<?php if(!empty($nomeSub)):?>
						<?php echo $nomeSub['name'];?>
					<?php endif;?>
				</div>
				
				<ul class="grid">
				<?php
				$i = 1;
				echo '<div style="width:100%;float:left;">';
				while ($WP_query->have_posts()) : $WP_query->the_post();
					?>
					<li>
						<?php
							$eixo = wp_get_post_terms($post->ID, 'eixos');
							if(!empty($eixo)):
								$eixo = $eixo[0]->slug;
							endif;
						?>
						<a href="javascript:void(0);" class="meta-single <?php echo $eixo;?>" data-post="<?php echo $post->ID;?>" data-eixo="<?php echo $eixo;?>">
							<h3><?php the_title();?></h3>
							<div class="conteudo">
								<div class="texto">
									<?php
										if (has_post_thumbnail($post->ID)) {
											echo get_the_post_thumbnail($post->ID);    
										}
									?>
									<p><?php echo remove_images(get_the_content());?></p>
								</div>
								<h4>Articulação territorial</h4>
								<?php
									$articulacao = wp_get_post_terms($post->ID, 'articulacoes');
									if(!empty($articulacao)):
										?>
											<p class="info"><?php echo $articulacao[0]->name;?></p>
										<?php
									endif;
								?>
								<h4>Secretaria e unidade<br /> responsável</h4>
								<?php
									$secretaria = wp_get_post_terms($post->ID, 'secretarias');
									if(!empty($secretaria)):
										?>
											<p class="info"><?php echo $secretaria[0]->name;?></p>
										<?php
									endif;
								?>
								<p class="custo"><?php echo get_post_meta($post->ID, 'meta_custo_total', true);?></p>
								<div class="comentarios">
									<span class="balao"></span>
									<span class="numero">
										<?php
											$countComments = wp_count_comments($post->ID);
										?>
										<b><?php echo $countComments->approved;?></b> comentários
									</span>
								</div>
							</div>
						</a>
					</li>
				<?php
					echo ($i%3 == 0) ? '</div><div style="width:100%;float:left;">' : '';
					$i++;
			endwhile;
			?>
				</ul>
			<?php
			endif;
			}
		}
	}die;
}

add_action('wp_ajax_load_by_sub', 'load_by_sub');
add_action('wp_ajax_nopriv_load_by_sub', 'load_by_sub');

add_action('wp_ajax_load_metas_filter_mapa', 'load_metas_filter_mapa');
add_action('wp_ajax_nopriv_load_metas_filter_mapa', 'load_metas_filter_mapa');

function load_metas_filter_mapa() {
	
}

function get_post_data(){
    error_reporting(0); //see later to understand why it is here
    global $post;
    $post_id = $_REQUEST['pid'];
    if($post_id){
        $post = get_post($post_id);
        setup_postdata($post);
        get_template_part('single');
        die();
    }
}

function get_post_data_bkp() {
	if (!empty($_POST['pid'])) {
		$postId = $_POST['pid'];
		$terms = wp_get_post_terms($postId, 'metas-category');
		$post = get_post($postId, ARRAY_A);
		if (!empty($post)) {
			?>
				<div class="texto-meta">
					<h2>Meta <?php echo $post['post_title'];?></h2>
					<p><?php echo $post['post_content'];?></p>
				</div>
				
				<div class="detalhes">
					<?php
						foreach($terms as $t):
							if($t->parent == 0 && strpos($t->slug, 'eixo') !== false):
								$n = explode('-', $t->slug);
								$n = $n[1];
					?>
								<h4>Eixo Temático <?php echo $n;?>. <?php echo $t->description?></h4>
					<?php
							endif;
						endforeach;
					?>
					<h4>Objetivo temático associado</h4>
					<?php
						foreach($terms as $t):
							if(strpos($t->name, 'Objetivo') !== false):
					?>
								<p class="info"><b><?php echo $t->name;?>.</b> <?php echo $t->description;?></p>
					<?php
							endif;
						endforeach;
					?>
					<h4>Secretaria e unidade responsável</h4>
					<?php
						foreach($terms as $t):
							if($t->parent == 25):
					?>
								<p class="info"><?php echo $t->name;?></p>
					<?php
							endif;
						endforeach;
					?>
					<h4>Articulação territorial associada</h4>
					<?php
						foreach($terms as $t):
							if($t->parent == 53):
					?>
								<p class="info"><?php echo $t->name;?></p>
					<?php
							endif;
						endforeach;
					?>
					
					<div class="detalhamento">
						<h4>Detalhamento da Meta</h4>
						<div class="informacoes">
							<div class="termos">
								<p class="titulo">Definição dos termos técnicos</p>
								<p class="info"><?php echo get_post_meta($post['ID'], 'meta_termos_tecnicos', true);?></p>
							</div>
							
							<div class="entrega">
								<p class="titulo">O que vai ser entregue ?</p>
								<p class="info"><?php echo get_post_meta($post['ID'], 'meta_entregue', true);?></p>
							</div>
						</div>
					</div>
					
					<h4>Observações</h4>
					<p class="info"><?php echo get_post_meta($post['ID'], 'meta_observacoes', true);?></p>
					<h4>Custo total da meta</h4>
					<p class="info"><?php echo get_post_meta($post['ID'], 'meta_custo_total', true);?></p>
					<div class="cronograma">
						<div class="conteudo">
							<h4>Cronograma de entrega</h4>
							<div class="um">
								<p class="titulo">2013-2014</p>
								<?php
								$cronograma1 = get_post_meta($post['ID'], 'meta_cronograma_1', true);
								if(!empty($cronograma1)):
									$parts = explode(',', $cronograma1);
									foreach($parts as $p):
									?>
										<p class="info"><?php echo $p;?></p>
									<?php
									endforeach;
								endif;
								?>
							</div>
							<div class="dois">
								<p class="titulo">2015-2016</p>
								<?php
								$cronograma2 = get_post_meta($post['ID'], 'meta_cronograma_2', true);
								if(!empty($cronograma2)):
									$parts = explode(',', $cronograma2);
									foreach($parts as $p):
									?>
										<p class="info"><?php echo $p;?></p>
									<?php
									endforeach;
								endif;
								?>
							</div>
						</div>	
					</div>
				</div>
			<?php
		}
	}die;
}

add_action('wp_ajax_get_post_by_id', 'get_post_data');
add_action('wp_ajax_nopriv_get_post_by_id', 'get_post_data');

function catch_that_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];
	
	// no image found display default image instead
	return $first_img;
}

function remove_images($content) {
   $postOutput = preg_replace('/<img[^>]+./','', $content);
   return $postOutput;
}
?>
