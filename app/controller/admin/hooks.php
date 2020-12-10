<?php defined('ABSPATH') || exit('No direct script access allowed');

add_filter('vvep_check_wizard_step_check_domain', 'vvep_checkExternalDomain', 10, 2);
function vvep_checkExternalDomain(array $res, array $userData): array
{
    $vvep       = new ExternalPosts();
    $domain     = esc_url($userData['domain']);
    $terms      = $vvep->getPostTypes($domain);

    if(!$terms): 
        $res['is_valid'] = false;
        $res['message']  = 'Não foi possível realizar a conexão com o domínio solicitado. Certifique-se de que ele é um site feito em WordPress e que o acesso aos endpoins da API de posts está ativa.';

    else: 
        $options = [];

        foreach ($terms as $k => $v) $options[ $v['rest_base'] ] = $v['name'];

        $vvep->__set('domain', $domain);

        $res['is_valid']  = true;
        $res['input']     = 'post_type';
        $res['options']   = $options;
        $res['next_step'] = $vvep->getNextWizardStep();
    endif;

    return $res;
}

add_filter('vvep_check_wizard_step_define_post_type', 'vvep_defineExternalPostType', 10, 2);
function vvep_defineExternalPostType(array $res, array $userData): array
{
    $vvep       = new ExternalPosts();
    $postType   = sanitize_text_field($userData['post_type']); 
    $vvep->__set('postType', $postType);

    $res['is_valid']  = true;
    $res['next_step'] = $vvep->getNextWizardStep();
    return $res;
}

add_filter('vvep_check_wizard_step_options', 'vvep_defineExternalPostOptions', 10, 2);
function vvep_defineExternalPostOptions(array $res, array $userData): array
{
    $vvep = new ExternalPosts();

    $vvep->__set('updatePeriod', (int) $userData['update_period']);

    $res['is_valid']  = true;
    $res['next_step'] = $vvep->getNextWizardStep();
    $res['message']   = 'Configurações realizadas com sucesso!';
    return $res;
}

add_filter('vvep_check_wizard_step_update_settings', 'vvep_updateExternalPostSettings', 10, 2);
function vvep_updateExternalPostSettings(array $res, array $userData): array
{
    $vvep = new ExternalPosts();

    $updateDomain   = vvep_checkExternalDomain($res, $userData);
    if(!$updateDomain['is_valid']): 
        return $updateDomain;
    endif;

    $updatePostType = vvep_defineExternalPostType($res, $userData);
    if(!$updatePostType['is_valid']): 
        return $updatePostType;
    endif;

    $updateOptions  = vvep_defineExternalPostOptions($res, $userData);
    if(!$updateOptions['is_valid']): 
        return $updateOptions;
    endif;

    $res['is_valid']  = true;
    $res['next_step'] = $vvep->getNextWizardStep();
    $res['message']   = 'Configurações salvas com sucesso';

    return $res;
}

add_action('save_post_vvep_shortcode', 'vvep_saveShortcodeAtts');
function vvep_saveShortcodeAtts(int $postId): void
{
    if(!isset($_POST['_vvep'])) return;

    $data = $_POST['_vvep'];
    $sc   = new ExternalPostsShortcode($postId);

    $sc->__set('style', sanitize_text_field($data['style']));
    $sc->__set('per_page', (int) $data['per_page']);
    $sc->__set('col_lg', (int) $data['col_lg']);
    $sc->__set('col_sm', (int) $data['col_sm']);
    $sc->__set('classes', sanitize_text_field($data['extra_classes']));
    
    if(isset($data['search'])): 
        $sc->__set('search', $data['search']);
    endif;

    if(isset($data['display'])): 
        $sc->__set('display', array_keys($data['display']));
    else: 
        $sc->__set('display', [null]);
    endif;
}