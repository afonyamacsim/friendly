<?php
add_action( 'acf/init', 'register_block_list' );
function register_block_list() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'list',
            'title'             => __( 'Список' ),
            'description'       => __( 'Маркированный/нумерованный список в стилистике сайта' ),
            'render_callback'   => 'render_list',
            'category'          => 'fws',
            'icon'              => 'editor-ul',
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'list_type'     => true,
                        'title'         => 'ОСНОВНЫЕ РАБОТЫ',
                        'subtitle'      => 'Ремонт подъездов — это целый комплекс различных работ, включающий:',
                        'ul'            => [
                            [ 'li'  => 'Монтаж или замену окон/дверей.' ],
                            [ 'li'  => 'Удаление старой отделки.' ],
                            [ 'li'  => 'Удаление старой отделки.' ],
                            [ 'li'  => 'Удаление старой отделки.' ],
                            [ 'li'  => 'Удаление старой отделки.' ],
                            [ 'li'  => 'Удаление старой отделки.' ]
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
function render_list( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="partner__content">
        <div class="partner__content-wrap">
            <? if ( $fields['title'] ): ?>
                <div class="partner__title"><?= $fields['title'] ?></div>
            <? endif; ?>
            <? if ( $fields['subtitle'] ): ?>
                <div class="partner__subtitle"><?= $fields['subtitle'] ?></div>
            <? endif; ?>
            <div class="partner__text">
                <<?= ( $fields['list_type'] === true ) ? 'ul' : 'ol' ?> class="for__whom-ul__list">
                    <? foreach ( $fields['ul'] as $i => $li ) {
                        echo "<li>{$li['li']}</li>";
                    } ?>
                </<?= ( $fields['list_type'] === true ) ? 'ul' : 'ol' ?>>
            </div>
        </div>
    </div>
<? } ?>