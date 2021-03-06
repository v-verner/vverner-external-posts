<?php defined('ABSPATH') || exit('No direct script access allowed');

add_action('wp_enqueue_scripts', 'vv_registerExternalPostsPublicAssets', 99);
function vv_registerExternalPostsPublicAssets(): void
{
   $base = plugin_dir_url(VVEP_FILE) . '/app/assets/public';
   $ver  = $_SERVER['REMOTE_ADDR'] === '::1' ? uniqid() : VVEP_VERSION;

   wp_enqueue_style('vvep-flickity', $base . '/css/dist/flickity.css', [], $ver);
   wp_enqueue_style('vvep-public', $base . '/css/dist/main.min.css', [], $ver);


   wp_enqueue_script('vvep-flickity', $base . '/js/dist/flickity.pkgd.min.js', ['jquery'], $ver, true);
   wp_enqueue_script('vvep-public', $base . '/js/dist/main.prod.js', ['jquery'], $ver, true);
}
