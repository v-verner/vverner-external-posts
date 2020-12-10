<?php defined('ABSPATH') || exit('No direct script access allowed');

add_shortcode('vvep-grid', 'displayExternalPostsGrid');
function displayExternalPostsGrid($atts)
{
    $a = shortcode_atts([
        'id'     => null,
    ], $atts);

    if(!$a['id']) return '<p>VVEP: Por favor, informe o ID do shortcode para exibir</p>';

    $sc     = new ExternalPostsShortcode((int) $a['id']); // usado na view
    $vvep   = new ExternalPosts();
    $posts  = $vvep->getPosts($sc->__get('per_page'), $sc->__get('search')); // usado na view

    ob_start();
    $themeFileSpec  = get_stylesheet_directory() . '/vverner/vvep-grid-'. $sc->ID .'.php';
    $themeFile      = get_stylesheet_directory() . '/vverner/vvep-grid.php';
    $pluginFile     = VVEP_PATH . '/app/view/public/vvep-grid.php';

    if(file_exists($themeFileSpec)): 
        require $themeFileSpec;
    elseif(file_exists($themeFile)):
        require $themeFile;
    else: 
        require $pluginFile;
    endif;

    return ob_get_clean();
}