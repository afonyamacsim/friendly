<?php
add_action( 'acf/init', 'register_block_sidebar' );
function register_block_sidebar() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'sidebar',
            'title'             => __( 'Боковое меню' ),
            'description'       => __( 'Боковое меню для страниц' ),
            'render_callback'   => 'render_sidebar',
            'category'          => 'fws',
            'icon'              => 'money',
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'title'         => 'Отзывы',
                        'reviews'       => [
                            [ 'review' => [
                                'content' => '<p>Текст отзыва...</p>',
                                'avatar'    => '//brigadil.dev.friendly.ws/wp-content/uploads/2021/08/ellipse.jpg',
                                'author'    => [ 'name' => 'Алёна Булганина', 'position' => 'Актриса' ]
                            ] ],
                            [ 'review' => [
                                'content' => '<p>Текст отзыва...</p>',
                                'avatar'    => '//brigadil.dev.friendly.ws/wp-content/uploads/2021/08/ellipse.jpg',
                                'author'    => [ 'name' => 'Алёна Булганина', 'position' => 'Актриса' ]
                            ] ]
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
function render_sidebar( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="left-sidbar">
        <? if ( $fields['title'] ): ?>
            <div class="left-sidbar__title"><?= $fields['title'] ?></div>
        <? endif; ?>
        <div class="wrapper__accordion">
                <? foreach ( $fields['cats'] as $term ) : ?>
                    <? if ( $fields['menu_type'] == true ): ?>
                        <div class="accordion__conten">
                            <? $posts = get_posts( [
                                    'post_type' => 'services',
                                    'numberposts' => ( isset( $fields['links_count'] ) && $fields['links_count'] !== 0 ) ? $fields['links_count'] : -1,
                                    'tax_query' => [
                                        [
                                            'taxonomy' => 'servicescat',
                                            'field' => 'term_id',
                                            'terms' => $term->term_id,
                                            'include_children' => false
                                        ]
                                    ]
                            ] ); ?>
                            <? if ( !empty( $posts ) ): ?>
                                <button class="accordion"><?= $term->name ?></button>
                                <div class="panel">
                                    <? foreach ( $posts as $post ) : ?>
                                        <p>
                                            <a href="<?= get_the_permalink( $post->ID ) ?>">
                                                <?= $post->post_title ?>
                                            </a>
                                        </p>
                                    <? endforeach; ?>
                                </div>
                            <? endif; ?>
                        </div>
                    <? else: ?>
                        <? if ( !empty( $term['title'] ) ): ?>
                            <div class="accordion__conten">
                                <button class="accordion"><?= $term['title'] ?></button>
                                <div class="panel">
                                    <? foreach ( $term['links'] as $link ) : ?>
                                        <p>
                                            <a href="<?= $link['href'] ?>">
                                                <?= $link['text'] ?>
                                            </a>
                                        </p>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        <? endif; ?>
                    <? endif; ?>
                <? endforeach; ?>
        </div>
    </div>
    <? if ( is_admin() ): ?>
        <script>
            ( function( $ ) {
                /**
                 * initializeBlock
                 *
                 * Adds custom JavaScript to the block HTML.
                 *
                 * @date    15/4/19
                 * @since   1.0.0
                 *
                 * @param   object $block The block jQuery element.
                 * @param   object attributes The block attributes (only available when editing).
                 * @return  void
                 */
                var initializeBlock = ( $block ) => {
                    // some code...
                }

                // Initialize each block on page load (front end).
                $( document ).ready( () => {
                    if ( $( '.accordion' ).length ) {
                        $( '.accordion' ).on( 'click', function ( e ) {
                            if ( $( this ).parents( '.accordion__conten' ).hasClass( 'open' ) ) {
                                $( this ).parents( '.accordion__conten ').removeClass( 'open' );
                                $( '.panel' ).slideUp();
                            } else {
                                $( '.panel' ).slideUp();
                                $( this ).parents( '.accordion__conten' ).siblings().removeClass( 'open' );
                                $( this ).parents( '.accordion__conten' ).addClass( 'open' );
                                $( this ).parents( '.accordion__conten' ).find( '.panel' ).slideDown();
                            }
                            return false;
                        } )
                    }
                } )

                // Initialize dynamic block preview (editor).
                if ( window.acf ) {
                    window.acf.addAction( 'render_block_preview/type=sidebar', initializeBlock );
                }

            } )( jQuery )
        </script>
    <? else: ?>
        <script>
            document.addEventListener( 'DOMContentLoaded', () => {
                jQuery( '.accordion' ).on( 'click', function ( e ) {
                    if ( jQuery( this ).parents( '.accordion__conten' ).hasClass( 'open' ) ) {
                        jQuery( this ).parents( '.accordion__conten ').removeClass( 'open' );
                        jQuery( '.panel' ).slideUp();
                    } else {
                        jQuery( '.panel' ).slideUp();
                        jQuery( this ).parents( '.accordion__conten' ).siblings().removeClass( 'open' );
                        jQuery( this ).parents( '.accordion__conten' ).addClass( 'open' );
                        jQuery( this ).parents( '.accordion__conten' ).find( '.panel' ).slideDown();
                    }
                } )
            } )
        </script>
    <? endif; ?>
<? } ?>
