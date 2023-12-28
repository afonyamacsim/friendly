<?php
add_action( 'acf/init', 'register_block_price_table_accordeon' );
function register_block_price_table_accordeon() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'prices_table_accordeon',
            'title'             => __( 'Акордеон таблица цен' ),
            'description'       => __( 'Таблица цен с заголовком и гармошкой' ),
            'render_callback'   => 'render_pricetable_accordeon',
            'category'          => 'fws',
            'icon'              => 'excerpt-view',
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'title'         => 'Фасадные работы',
                        'acordeon'           => [
                            [
                                'title'  => 'Крыльцо',
                                'row'  => [
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                ],
                            ],
                            [
                                'title'  => 'Крыльцо',
                                'row'  => [
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                    [ 'type' => 'Демонтаж керамогранита', 'price' => 'от 150 руб. м2' ],
                                ],
                            ]
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
function render_pricetable_accordeon( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="wrapper__accordion">
        <!-- start -->
        <? if ( $fields['title'] ): ?>
            <div class="accordion-title"><?= $fields['title'] ?></div>
        <? endif; ?>
        <? foreach ( $fields['acordeon'] as $acordeon ) : ?>
            <div class="accordion__content">
                <button class="accordions"><?= $acordeon['title'] ?></button>
                <div class="panels">
                    <div class="service-price__list">
                        <div class="service-price__row row-header">
                            <div class="service-price__title">Услуги</div>
                            <div class="service-price__value">Стоимость</div>
                        </div>
                        <? foreach ( $acordeon['row'] as $row ) : ?>
                            <div class="service-price__row row-header">
                                <div class="service-price__title"><?= $row['type'] ?></div>
                                <div class="service-price__value"><?= $row['price'] ?></div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
        <!-- END -->
    </div>
    <? if ( is_admin() ): ?>
        <script>
            ( ( $ ) => {
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
                }

                // Initialize each block on page load (front end).
                $( document ).ready( () => {
                    if ($('.accordions').length) {
                        $('.accordions').on('click', function (e) {
                            if ($(this).parents('.accordion__content').hasClass('open')) {
                                $(this).parents('.accordion__content').removeClass('open')
                                $('.panels').slideUp()
                            } else {
                                $('.panels').slideUp()
                                $(this).parents('.accordion__content').siblings().removeClass('open')
                                $(this).parents('.accordion__content').addClass('open');
                                $(this).parents('.accordion__content').find('.panels').slideDown()
                            }
                            return false
                        } )
                    }
                } )

                // Initialize dynamic block preview (editor).
                if ( window.acf ) {
                    window.acf.addAction( 'render_block_preview/type=prices_table_accordeon', initializeBlock )
                }

            } )( jQuery )
        </script>
    <? endif; ?>
<? } ?>