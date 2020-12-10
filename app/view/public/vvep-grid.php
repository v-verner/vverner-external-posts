<?php if(isset($posts) && isset($sc)): ?>
    <?php $display = $sc->__get('display'); ?>
    <div class="vvep__container <?= $sc->__get('classes') ?>" id="vvep-<?= $sc->ID ?>">
        <div class="vvep__row <?= ($sc->__get('style') === 'slider' && count($posts) > 3) ? 'vvep__slider' : '' ?>">
            <?php if(!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="vvep__col large-<?= $sc->__get('col_lg') ?> small-<?= $sc->__get('col_sm') ?>">
                        <div class="vvep__box" id="vvep-post-<?= $post->ID ?>">
                            <?php if($post->post_thumbnail && in_array('post_thumbnail', $display)): ?>
                                <div class="vvep__box-image">
                                    <a href="<?= $post->permalink ?>" target="_blank" rel="noopener">
                                        <img src="<?= $post->post_thumbnail->url ?>" alt="<?= $post->post_thumbnail->alt_text ? $post->post_thumbnail->alt_text : $post->post_thumbnail->title ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="vvep__box-content">
                                <?php if(in_array('post_title', $display)): ?>
                                    <div class="vvep__box-title">
                                        <h4><?= $post->post_title ?></h4>
                                    </div>
                                <?php endif; ?>
                                <div class="vvep__box-description">

                                    <?php if(in_array('post_content', $display)): ?>
                                        <?= $post->post_content ?>
                                    <?php endif; ?>
                                    <?php if(in_array('excerpt', $display)): ?>
                                        <?= $post->excerpt ?>
                                    <?php endif; ?>

                                    <?php if(in_array('button', $display)): ?>
                                        <a href="<?= $post->permalink ?>" target="_blank" class="vvep__box-btn" rel="noopener">Ver mais</a>
                                    <?php endif; ?>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col text-center" style="width: 100%; flex-basis: 100%">
                    <p>Nenhum post localizado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <p>Nenhum post localizado.</p>
<?php endif; ?>
