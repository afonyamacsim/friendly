<?php
add_action( 'acf/init', 'register_block_portfolio' );
function register_block_portfolio() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'portfolio',
            'title'             => __( 'Портфолио' ),
            'description'       => __( 'Слайдер работ' ),
            'render_callback'   => 'render_portfolio',
            'category'          => 'fws',
            'icon'              => 'money',
            'enqueue_assets' => function() {
                wp_enqueue_script( 'block-reviews', get_template_directory_uri() . '/js/slick.min.js', ['jquery'], false, true );
            },
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'title'         => 'Работы',
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
function render_portfolio( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="wrapper__slider ">
        <? if ( $fields['title'] ): ?>
            <div class="slaid-title"><?= $fields['title'] ?></div>
        <? endif; ?>
        <div class="works__slider">
            <? foreach ( $fields['portfolio'] as $item ) : ?>
                <div class="works__slider-col">
                    <?
                    $link = ( $fields['auto'] === true ) ? get_the_permalink( $item ) : $item['item']['link'];
                    $name = ( $fields['auto'] === true ) ? get_the_title( $item ) : $item['item']['name'];
                    $img = ( $fields['auto'] === true ) ? get_the_post_thumbnail_url( $item ) : $item['item']['img'];
                    $text = ( $fields['auto'] === true ) ? get_the_excerpt( $item ) : $item['item']['text'];
                    ?>
                    <a href="<?= $link ?>" class="works__slider-fon">
                        <div class="works__slider-img">
                            <img src="<?= $img ?>" alt="">
                        </div>
                        <div class="works__slider-bottom">
                            <div class="works-adress"><?= $name ?></div>
                            <div class="works-name"><?= $text ?></div>
                        </div>
                    </a>
                </div>
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
                    if ( $( '.works__slider' ).length ) {
                        $( '.works__slider' ).slick( {
                            infinite: false,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            arrows: true,
                            dots: false,
                            responsive: [
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 1,
                                        arrows: false,
                                        dots: true,
                                    }
                                }
                            ]
                        } )
                    }
                } )

                // Initialize dynamic block preview (editor).
                if ( window.acf ) {
                    window.acf.addAction( 'render_block_preview/type=portfolio', initializeBlock );
                }

            })( jQuery )
        </script>
    <? else: ?>
        <script>
            document.addEventListener( 'DOMContentLoaded', () => {
                jQuery( '.works__slider' ).slick( {
                    infinite: false,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                                arrows: false,
                                dots: true,
                            }
                        }
                    ]
                } )
            } )
        </script>
    <? endif; ?>
<? } ?>
