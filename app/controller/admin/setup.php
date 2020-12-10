<?php defined('ABSPATH') || exit('No direct script access allowed');

add_action('admin_enqueue_scripts', 'vvep_registerExternalPostsAdminAssets', 99);
function vvep_registerExternalPostsAdminAssets(): void
{
    $base = plugin_dir_url(VVEP_FILE) . '/app/assets/admin';
    $ver  = $_SERVER['REMOTE_ADDR'] === '::1' ? uniqid() : VVEP_VERSION;

    wp_enqueue_style('vvep-main', $base . '/css/dist/admin.min.css', [], $ver);
    wp_enqueue_script('vvep-main', $base . '/js/dist/admin.prod.js', ['jquery'], $ver, true);
    wp_localize_script('vvep-main', 'vvepData', [
        'ajaxUrl' => admin_url('admin-ajax.php')
    ]);
}

add_action( 'admin_menu', 'vvep_registerExternalPostsAdminPages' );
function vvep_registerExternalPostsAdminPages(): void
{
    $slug = 'vv-external-posts';

    add_menu_page( 
        'Introdução aos Posts Externos',
        'Posts Externos',
        'manage_options',
        $slug,
        'vv_displayExternalPostsAdminView',
        'dashicons-rss'
    ); 

    add_submenu_page(
        $slug,
        'Configurações',
        'Configurações',
        'manage_options',
        $slug . '-settings',
        'vv_displayExternalPostsAdminView'
    );

    add_submenu_page(
        $slug,
        'Shortcodes',
        'Shortcodes',
        'manage_options',
        'edit.php?post_type=vvep_shortcode',
    );
}

add_action('init', 'vvep_registerPostType', 0);
function vvep_registerPostType(): void
{
	$labels =  [
        'name'                  => _x( 'VVEP - Shortcodes', 'Post Type General Name' ),
		'singular_name'         => _x( 'Shortcode', 'Post Type Singular Name' ),
		'menu_name'             => __( 'Shortcodes' ),
    ];
	$args = [
        'label'                 => 'Shortcodes',
		'labels'                => $labels,
		'supports'              => ['title'],
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => 'admin.php?page=vv-external-posts',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
    ];
	register_post_type( 'vvep_shortcode', $args );
}

add_action('add_meta_boxes', 'vvep_registerPostTypeMetaBoxes');
function vvep_registerPostTypeMetaBoxes(): void
{
    add_meta_box(
        'vvep-config',
        'Configurações do Shortcode',
        'displayShortcodeConfigMetaBox',
        'vvep_shortcode',
    );
}

add_filter( 'manage_vvep_shortcode_posts_columns', 'vvep_registerShortcodeColumns' );
function vvep_registerShortcodeColumns(array $cols)
{
	$cols = [
		'cb'		=> $cols['cb'],	
		'title'	    => $cols['title'],
		'style'		=> 'Estilo',
		'shortcode'	=> 'Shortcode',
	];

    return $cols;
}

add_action( 'manage_vvep_shortcode_posts_custom_column' , 'vvep_populateShortcodeColumns', 10, 2 );
function vvep_populateShortcodeColumns( $col, $post_id ) {
	$sc = new ExternalPostsShortcode($post_id);

	switch ( $col ) :
		case 'style' : echo ucwords($sc->__get('style')); break;
		case 'shortcode' : echo '<input type="text" class="large-text" readonly value=\''. $sc .'\'>'; break;
	endswitch;
}