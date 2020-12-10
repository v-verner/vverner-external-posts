<?php defined('ABSPATH') || exit('No direct script access allowed');

function getExternalPostsAdminPageUrl(string $page): string
{
    $page = sanitize_title($page);
    $base = admin_url('admin.php?page=vv-external-posts-' . $page);
    return $base;
}

function vv_displayExternalPostsAdminView(): void
{   
    $endpoint = (isset($_GET['page'])) ? $_GET['page'] : null;
    if(!$endpoint) return;

    $slug = str_replace('vv-external-posts-', '', $endpoint);
    $slug = ($slug === 'vv-external-posts') ? 'instructions' : $slug;
    
    $file = VVEP_PATH . '/app/view/admin/'. $slug .'.php';

    if(file_exists($file)): 
        require_once $file;
    else: 
        echo 'View not found for endpoint ' . $endpoint;
    endif;
}

function displayShortcodeConfigMetaBox(): void
{
    require_once VVEP_PATH . '/app/view/admin/mb-shortcode.php';
}