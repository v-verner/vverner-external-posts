<?php defined('ABSPATH') || exit('No direct script access allowed');
$id = get_the_ID();
$shortcode = new ExternalPostsShortcode($id);
?>

<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th scope="row">
                <label for="_vvep[search]">Termo de busca</label>
            </th>
            <td>
                <input type="text" class="large-text" name="_vvep[search]" id="_vvep[search]" value="<?= $shortcode->__get('search') ?>">
                <small>Utilize para retornar apenas os resultados que contenham o termo acima. Deixe em branco para não utilizar.</small>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="_vvep[style]">Estilo</label>
            </th>
            <td>
                <select name="_vvep[style]" id="_vvep[style]" class="large-text" style="width: 100%" required>
                    <option value="" hidden>Selecione</option>
                    <option <?php selected('slider', $shortcode->__get('style')) ?> value="slider">Slider</option>
                    <option <?php selected('grid', $shortcode->__get('style')) ?> value="grid">Grid</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="_vvep[per_page]">Quantidade de Posts (total)</label>
            </th>
            <td>
                <input type="number" class="large-text" name="_vvep[per_page]" id="_vvep[per_page]" min="1" step="1" value="<?= $shortcode->__get('per_page') ?>" required>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="_vvep[col_lg]">Quantidade de colunas (desktop)</label>
            </th>
            <td>
                <input type="number" class="large-text" name="_vvep[col_lg]" id="_vvep[col_lg]" min="1" step="1" max="6" value="<?= $shortcode->__get('col_lg') ?>" required>
                <small>Min: 1 | Max: 6</small>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="_vvep[col_sm]">Quantidade de colunas (mobile)</label>
            </th>
            <td>
                <input type="number" class="large-text" name="_vvep[col_sm]" id="_vvep[col_sm]" min="1" step="1" max="6" value="<?= $shortcode->__get('col_sm') ?>" required>
                <small>Min: 1 | Max: 6</small>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="_vvep[extra_classes]">Classes</label>
            </th>
            <td>
                <input type="text" class="large-text" name="_vvep[extra_classes]" id="_vvep[extra_classes]" value="<?= $shortcode->__get('classes') ?>">
                <small>Separe as classes apenas por um espaço</small>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label>Informações para exibir</label>
            </th>
            <td>
                <?php $display = $shortcode->__get('display') ? $shortcode->__get('display') : []; ?>
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
