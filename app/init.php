<?php defined('ABSPATH') || exit('No direct script access allowed');

/**
 * Bootstrap file
 */

 require_once VVEP_PATH . '/app/controller/classes/ExternalPosts.php';
 require_once VVEP_PATH . '/app/controller/classes/ExternalPostsShortcode.php';

 require_once VVEP_PATH . '/app/controller/admin/ajax.php';
 require_once VVEP_PATH . '/app/controller/admin/helpers.php';
 require_once VVEP_PATH . '/app/controller/admin/setup.php';
 require_once VVEP_PATH . '/app/controller/admin/hooks.php';

 require_once VVEP_PATH . '/app/controller/public/setup.php';
 require_once VVEP_PATH . '/app/controller/public/shortcodes.php';
