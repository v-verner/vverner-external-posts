<?php defined('ABSPATH') || exit('No direct script access allowed'); ?>
<div class="wrap">
    <h1><strong>VVerner - Posts Externos</strong></h1>
    <p>Com este plugin você pode inserir posts de qualquer outro site construído com WordPress em páginas do seu site através de shortcodes!</p>
    <p>O plugin utiliza a <strong>API Rest</strong> do WordPress para fazer a consulta em sites externos.</p>
    <p>Recomendamos que seja solicitada a permissão dos sites inseridos antes de veicular o conteúdo deles em seu site.</p>

    <br>

    <h2>Templates e Views</h2>
    <p>Você pode criar templates customizados para os shortcodes em seu tema. Para isso crie uma pasta "vverner" na raiz do seu tema e coloque nela um arquivo chamado <strong>vvep-grid.php</strong></p>
    <p>Com este arquivo criado, o plugin irá carregar o seu template ao invés dos templates padrões do plugin.</p>
    <p>Caso você prefira queira criar um template único para um shortcode específico, você também pode! Basta criar um arquivo chamado <strong>vvep-grid-ID_DO_SHORTCODE.php</strong>.</p>
    
    <h4>Ordem de prioridade dos templates para serem carregados</h4>
    <ol>
        <li>/seu-tema/vverner/vvep-grid-ID_DO_SHORTCODE.php</li>
        <li>/seu-tema/vverner/vvep-grid.php</li>
        <li>arquivo padrão do plugin</li>
    </ol>

    <br>

    <h2>Shortcodes do plugin</h2>
    <p>Você pode criar inúmeros shortcodes através <a href="<?= admin_url('edit.php?post_type=vvep_shortcode') ?>">deste link.</a></p>

    <br>

    <h2>Ações</h2>
    <a href="<?= getExternalPostsAdminPageUrl('Settings') ?>" class="button button-primary">Ir para as configurações.</a>
    <button id="clearExternalPostsCache" class="button button-secondary">Limpar cache dos posts</button>
</div>