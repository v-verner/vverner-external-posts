<?php defined('ABSPATH') || exit('No direct script access allowed'); ?>
<h1>Configurações</h1>
<p>Siga o wizard abaixo para configurar o plugin.</p>

<?php $vvep = new ExternalPosts(); ?>
<?php $data = $vvep->getAllData(); ?>

<form id="vvep-setting-wizard" class="vvep-wizard">

    <div class="vvep-wizard__step active" id="step-check_domain">

        <div class="input-container">
            <label for="domain">Insira abaixo a URL do site</label>
            <input type="url" name="domain" id="domain" value="<?= $data['domain'] ?>">
        </div>

    </div>

    <div class="vvep-wizard__step <?= $data['domain'] ? 'active' : '' ?>" id="step-define_post_type">

        <div class="input-container">
            <label for="post_type">
                Escolha o tipo de Post para capturar
                <span title="Clique para recarregar os tipos de post disponíveis" id="vvep-reloadPosts" class="dashicons dashicons-update"></span>
            </label>
            <select name="post_type" id="post_type">
                <option value="" hidden>Selecione</option>
                <?php if($data['domain']): ?>
                    <?php $terms = $vvep->getPostTypes(); ?>
                    <?php if($terms): ?>
                        <?php foreach ($terms as $k => $v): ?>
                            <option value="<?= $v['rest_base'] ?>" <?php selected($data['postType'], $v['rest_base']) ?>><?= $v['name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- JS -->
            </select>
        </div>

    </div>

    <div class="vvep-wizard__step <?= $data['postType'] ? 'active' : '' ?>" id="step-options">

        <div class="input-container">
            <label for="update_period">Período para atualização de posts externos</label>
            <select name="update_period" id="update_period">
                <?php $current = $data['updatePeriod']; ?>
                <option value="" hidden>Selecione</option>
                <option <?php selected($current, HOUR_IN_SECONDS / 2) ?> value="<?= HOUR_IN_SECONDS / 2 ?>">30 minutos</option>
                <option <?php selected($current, HOUR_IN_SECONDS) ?> value="<?= HOUR_IN_SECONDS ?>">1 hora</option>
                <option <?php selected($current, HOUR_IN_SECONDS * 3) ?> value="<?= HOUR_IN_SECONDS * 3 ?>">3 horas</option>
                <option <?php selected($current, HOUR_IN_SECONDS * 6) ?> value="<?= HOUR_IN_SECONDS * 6 ?>">6 horas</option>
                <option <?php selected($current, HOUR_IN_SECONDS * 12) ?> value="<?= HOUR_IN_SECONDS * 12 ?>">12 horas</option>
                <option <?php selected($current, DAY_IN_SECONDS) ?> value="<?= DAY_IN_SECONDS ?>">24 horas</option>
            </select>
        </div>

    </div>

    <div class="vvep-wizard__wait">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>

    <div class="vvep-wizard__submit active">
        <input type="hidden" name="step" value="<?= $vvep->getNextWizardStep() ?>">
        <input type="hidden" name="action" value="vvep_setting_wizard">
        <?php wp_nonce_field('vvep_setting_wizard') ?>
        <button class="button button-primary">Continuar</button>
    </div>



</form>