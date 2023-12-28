<?php
add_action( 'acf/init', 'register_block_cta' );
function register_block_cta() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'cta',
            'title'             => __( 'Призыв к действию' ),
            'description'       => __( 'Плашка призыва к действию' ),
            'render_callback'   => 'render_cta',
            'category'          => 'fws',
            'icon'              => 'embed-photo',
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'content'       => [
                            'icon'      => get_template_directory_uri() . '/img/operator.svg',
                            'text'      => 'Наш специалист готов проконсультировать вас прямо сейчас!',
                            'btn_text'  => 'Заказать звонок'
                        ]
                    ]
                ]
            ]
        ] );
    }
}

/**
 * Price table Block Callback Function.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
function render_cta( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="right-top">
        <div class="left-flex">
            <div class="right-top__img">
                <img src="<?= $fields['content']['icon'] ?>" alt="">
            </div>
            <div class="right-top__text"><?= $fields['content']['text'] ?></div>
        </div>
        <div class="right-top__btn">
            <div class="zvonok">
                <a href="#hidden" data-fancybox><?= $fields['content']['btn_text'] ?></a>
            </div>
        </div>
    </div>
<? } ?>