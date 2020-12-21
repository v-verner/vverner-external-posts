<?php defined('ABSPATH') || exit('No direct script access allowed');
$id         = get_the_ID();
$sc  = new ExternalPostsShortcode($id);
$domain     = $sc->__get('domain');
?>

<table class="form-table" role="presentation">
   <tbody>
      <tr>
         <th scope="row">
            <label for="_vvep-domain">Domínio</label>
         </th>
         <td style="display: flex">
            <input type="text" class="large-text" name="_vvep[domain]" id="_vvep-domain" value="<?= $domain ?>" required>
            <button class="button button-primary" id="vvep-testConnection">Testar Conexão</button>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="vvpe-post_type">Tipo de Post</label>
         </th>
         <td>
            <select style="width: 99%" name="_vvep[type]" id="vvpe-post_type" required>
               <option value="" hidden>Selecione</option>
               <?php if ($domain) : ?>
                  <?php $terms = ExternalPostsApi::getPostTypes($domain); ?>
                  <?php if ($terms) : ?>
                     <?php foreach ($terms as $k => $v) : ?>
                        <option value="<?= $v['rest_base'] ?>" <?php selected($sc->__get('type'), $v['rest_base']) ?>><?= $v['name'] ?></option>
                     <?php endforeach; ?>
                  <?php endif; ?>
               <?php endif; ?>
            </select>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[updatePeriod]">Tempo de atualização</label>
         </th>
         <td>
            <select style="width: 99%" name="_vvep[updatePeriod]" id="_vvep[updatePeriod]" required>
               <option value="" hidden>Selecione</option>
               <?php $current = $sc->__get('updatePeriod') ?>
               <option <?php selected($current, HOUR_IN_SECONDS / 2) ?> value="<?= HOUR_IN_SECONDS / 2 ?>">30 minutos</option>
               <option <?php selected($current, HOUR_IN_SECONDS) ?> value="<?= HOUR_IN_SECONDS ?>">1 hora</option>
               <option <?php selected($current, HOUR_IN_SECONDS * 3) ?> value="<?= HOUR_IN_SECONDS * 3 ?>">3 horas</option>
               <option <?php selected($current, HOUR_IN_SECONDS * 6) ?> value="<?= HOUR_IN_SECONDS * 6 ?>">6 horas</option>
               <option <?php selected($current, HOUR_IN_SECONDS * 12) ?> value="<?= HOUR_IN_SECONDS * 12 ?>">12 horas</option>
               <option <?php selected($current, DAY_IN_SECONDS) ?> value="<?= DAY_IN_SECONDS ?>">24 horas</option>
            </select>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[search]">Termo de busca</label>
         </th>
         <td>
            <input type="text" class="large-text" name="_vvep[search]" id="_vvep[search]" value="<?= $sc->__get('search') ?>">
            <small>Utilize para retornar apenas os resultados que contenham o termo acima. Deixe em branco para não utilizar.</small>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[style]">Estilo</label>
         </th>
         <td>
            <select name="_vvep[style]" id="_vvep[style]" class="large-text" style="width: 99%" required>
               <option value="" hidden>Selecione</option>
               <option <?php selected('slider', $sc->__get('style')) ?> value="slider">Slider</option>
               <option <?php selected('grid', $sc->__get('style')) ?> value="grid">Grid</option>
            </select>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[per_page]">Quantidade de Posts (total)</label>
         </th>
         <td>
            <input type="number" class="large-text" name="_vvep[per_page]" id="_vvep[per_page]" min="1" step="1" value="<?= $sc->__get('per_page') ?>" required>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[col_lg]">Quantidade de colunas (desktop)</label>
         </th>
         <td>
            <input type="number" class="large-text" name="_vvep[col_lg]" id="_vvep[col_lg]" min="1" step="1" max="6" value="<?= $sc->__get('col_lg') ?>" required>
            <small>Min: 1 | Max: 6</small>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[col_sm]">Quantidade de colunas (mobile)</label>
         </th>
         <td>
            <input type="number" class="large-text" name="_vvep[col_sm]" id="_vvep[col_sm]" min="1" step="1" max="6" value="<?= $sc->__get('col_sm') ?>" required>
            <small>Min: 1 | Max: 6</small>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label for="_vvep[extra_classes]">Classes</label>
         </th>
         <td>
            <input type="text" class="large-text" name="_vvep[extra_classes]" id="_vvep[extra_classes]" value="<?= $sc->__get('classes') ?>">
            <small>Separe as classes apenas por um espaço</small>
         </td>
      </tr>
      <tr class="<?= $domain ? '' : 'after-domain'; ?>">
         <th scope="row">
            <label>Informações para exibir</label>
         </th>
         <td>
            <?php $display = $sc->__get('display') ? $sc->__get('display') : []; ?>
            <input <?php checked(in_array('post_thumbnail', $display)) ?> type="checkbox" name="_vvep[display][post_thumbnail]" id="_vvep[display][post_thumbnail]">
            <label for="_vvep[display][post_thumbnail]">Imagem destacada</label><br>

            <input <?php checked(in_array('post_title', $display)) ?> type="checkbox" name="_vvep[display][post_title]" id="_vvep[display][post_title]">
            <label for="_vvep[display][post_title]">Título</label><br>

            <input <?php checked(in_array('post_content', $display)) ?> type="checkbox" name="_vvep[display][post_content]" id="_vvep[display][post_content]">
            <label for="_vvep[display][post_content]">Conteúdo do Post</label><br>

            <input <?php checked(in_array('excerpt', $display)) ?> type="checkbox" name="_vvep[display][excerpt]" id="_vvep[display][excerpt]">
            <label for="_vvep[display][excerpt]">Descrição do Post</label><br>

            <input <?php checked(in_array('button', $display)) ?> type="checkbox" name="_vvep[display][button]" id="_vvep[display][button]">
            <label for="_vvep[display][button]">Botão de ver mais</label><br>
         </td>
      </tr>
   </tbody>
</table>