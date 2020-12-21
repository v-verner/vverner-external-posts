<?php defined('ABSPATH') || exit('No direct script access allowed');

add_filter('vvep_check_wizard_step_domain', 'vvep_checkExternalDomain', 10, 2);
function vvep_checkExternalDomain(array $res, array $userData): array
{
   $domain     = esc_url($userData['domain']);
   $terms      = ExternalPostsApi::getPostTypes($domain);

   if (!$terms) :
      $res['is_valid'] = false;
      $res['message']  = 'Não foi possível realizar a conexão com o domínio solicitado. Certifique-se de que ele é um site feito em WordPress e que o acesso aos endpoins da API de posts está ativa.';

   else :
      $options = [];
      foreach ($terms as $k => $v) $options[$v['rest_base']] = $v['name'];

      $res['is_valid']  = true;
      $res['input']     = 'vvpe-post_type';
      $res['options']   = $options;
   endif;

   return $res;
}

add_action('save_post_vvep_shortcode', 'vvep_saveShortcodeAtts');
function vvep_saveShortcodeAtts(int $postId): void
{
   if (!isset($_POST['_vvep'])) return;

   $data = $_POST['_vvep'];
   $sc   = new ExternalPostsShortcode($postId);

   $sc->__set('style', sanitize_text_field($data['style']));
   $sc->__set('domain', sanitize_text_field($data['domain']));
   $sc->__set('type', sanitize_text_field($data['type']));
   $sc->__set('updatePeriod', (int) $data['updatePeriod']);
   $sc->__set('per_page', (int) $data['per_page']);
   $sc->__set('col_lg', (int) $data['col_lg']);
   $sc->__set('col_sm', (int) $data['col_sm']);
   $sc->__set('classes', sanitize_text_field($data['extra_classes']));

   if (isset($data['search'])) :
      $sc->__set('search', $data['search']);
   endif;

   if (isset($data['display'])) :
      $sc->__set('display', array_keys($data['display']));
   else :
      $sc->__set('display', [null]);
   endif;
}
