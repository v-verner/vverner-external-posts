<?php defined('ABSPATH') || exit('No direct script access allowed');

add_action('wp_ajax_vvep_setting_wizard', 'vvajax_processWizardStep');
function vvajax_processWizardStep(): void
{
   if(!isset($_POST['step'])) wp_send_json_error(['message' => 'Step not found.']);

   $step   = sanitize_text_field($_POST['step']);
   $filter = 'vvep_check_wizard_step_' . $step;
   $data   = [
      'next_step' => '',
      'is_valid'  => '',
      'message'   => '',
      'input'     => '',
      'options'   => [],
   ];

   $data = apply_filters($filter, $data, $_POST);

   wp_send_json_success($data);
}

add_action('wp_ajax_vvep_remove_cache', 'vvajax_remove_cache');
function vvajax_remove_cache(): void
{
   ExternalPostsApi::deletePostsCache();
   wp_send_json_success();
}