<?php
add_action( 'acf/init', 'register_block_btns' );
function register_block_btns() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'btns',
            'title'             => __( 'Группа кнопок' ),
            'description'       => __( 'Группа кнопок на скачку' ),
            'render_callback'   => 'render_btns',
            'category'          => 'fws',
            'icon'              => 'button',
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'content'       => [
                            'icon'      => get_template_directory_uri() . '/img/pdf.svg',
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
function render_btns( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="dowload-wrap">
        <? foreach ( $fields['btns'] as $btn ) : ?>
            <a href="<?= $btn['link'] ?>" class="dowload-card">
                <img src="<?= $btn['icon'] ?>"><?= $btn['text'] ?>
            </a>
        <? endforeach; ?>
    </div>
<? } ?>