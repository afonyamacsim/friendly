<?php
add_action( 'acf/init', 'register_block_reviews' );
function register_block_reviews() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'reviews',
            'title'             => __( 'Отзывы' ),
            'description'       => __( 'Отзывы для страницы' ),
            'render_callback'   => 'render_reviews',
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
function render_reviews( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="wrapper__slider ">
        <? if ( $fields['title'] ): ?>
            <div class="slaid-title"><?= $fields['title'] ?></div>
        <? endif; ?>
        <div class="main__slider">
            <? foreach ( $fields['reviews'] as $review ) : ?>
                <div class="main__slider-col">
                    <div class="main__slider-fon">
                        <div class="main__slider-text">
                            <?= $review['review']['content'] ?>
                        </div>
                        <div class="main__slider-bottom">
                            <div class="main__slider-logo">
                                <img src="<?= $review['review']['avatar'] ?>" alt="">
                            </div>
                            <div class="main__slider-right">
                                <div class="slider-mame"><?= $review['review']['author']['name'] ?></div>
                                <div class="slider-prof"><?= $review['review']['author']['position'] ?></div>
                            </div>
                        </div>
                    </div>
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
                    $( '.main__slider' ).slick( {
                        infinite: false,
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        arrows: false,
                        dots: true,
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                    dots: true,
                                }
                            }
                        ]
                    } )
                } )

                // Initialize dynamic block preview (editor).
                if ( window.acf ) {
                    window.acf.addAction( 'render_block_preview/type=reviews', initializeBlock );
                }

            })( jQuery )
        </script>
    <? else: ?>
        <script>
            document.addEventListener( 'DOMContentLoaded', () => {
                    jQuery( '.main__slider' ).slick( {
                    infinite: false,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                                dots: true,
                            }
                        }
                    ]
                } )
            } )
        </script>
    <? endif; ?>
<? } ?>
