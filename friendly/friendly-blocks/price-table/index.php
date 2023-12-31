<?php
add_action( 'acf/init', 'register_block_price_table' );
function register_block_price_table() {

    // check function exists.
    if( function_exists( 'acf_register_block_type' ) ) {

        // register a price table block.
        acf_register_block_type( [
            'name'              => 'prices_table',
            'title'             => __( 'Таблица цен' ),
            'description'       => __( 'Таблица цен для страницы услуги' ),
            'render_callback'   => 'render_pricetable',
            'enqueue_style' => get_template_directory_uri() . '/css/style.css',
            'category'          => 'fws',
            'icon'              => 'list-view',
            'example'           => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'is_preview'    => true,
                        'row'           => [
                            [
                                'type'  => 'Очистка поверхностей от старой краски, мела',
                                'unit'  => 'кв.м',
                                'price' => 'от 70'
                            ],
                            [
                                'type'  => 'Очистка поверхностей от старой краски, мела',
                                'unit'  => 'кв.м',
                                'price' => 'от 70'
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
function render_pricetable( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    
    $fields = get_fields() ?: $block['data']; ?>

    <div class="wrapper__content">
        <table class="table">
            <thead>
                <tr>
                    <th>Вид работ</th>
                    <th>Единица измерения</th>
                    <th>Цена, руб.</th>
                </tr>
            </thead>
            <tbody>
                <? foreach ( $fields['row'] as $row ) : ?>
                    <tr>
                        <td data-label="Вид работ"><?= $row['type'] ?></td>
                        <td data-label="Единица измерения">
                            <div class="is__included"><?= $row['unit'] ?></div>
                        </td>
                        <td data-label="Цена, руб.">
                            <div class="is__included"><?= $row['price'] ?></div>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <div class="table-btn">
            <a href="#">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.6249 16.5539H12.8882V10.875C12.8882 10.7719 12.8038 10.6875 12.7007 10.6875H11.2944C11.1913 10.6875 11.1069 10.7719 11.1069 10.875V16.5539H9.37489C9.21786 16.5539 9.13114 16.7344 9.22723 16.8563L11.8522 20.1773C11.8698 20.1998 11.8922 20.2179 11.9178 20.2303C11.9433 20.2428 11.9714 20.2493 11.9999 20.2493C12.0283 20.2493 12.0564 20.2428 12.082 20.2303C12.1076 20.2179 12.13 20.1998 12.1475 20.1773L14.7725 16.8563C14.8686 16.7344 14.7819 16.5539 14.6249 16.5539Z"
                        fill="white" />
                    <path
                        d="M19.0172 8.59453C17.9438 5.76328 15.2086 3.75 12.0047 3.75C8.80078 3.75 6.06563 5.76094 4.99219 8.59219C2.98359 9.11953 1.5 10.95 1.5 13.125C1.5 15.7148 3.59766 17.8125 6.18516 17.8125H7.125C7.22813 17.8125 7.3125 17.7281 7.3125 17.625V16.2188C7.3125 16.1156 7.22813 16.0312 7.125 16.0312H6.18516C5.39531 16.0312 4.65234 15.7172 4.09922 15.1477C3.54844 14.5805 3.25547 13.8164 3.28125 13.0242C3.30234 12.4055 3.51328 11.8242 3.89531 11.3344C4.28672 10.8352 4.83516 10.4719 5.44453 10.3102L6.33281 10.0781L6.65859 9.22031C6.86016 8.68594 7.14141 8.18672 7.49531 7.73438C7.8447 7.28603 8.25857 6.89191 8.72344 6.56484C9.68672 5.8875 10.8211 5.52891 12.0047 5.52891C13.1883 5.52891 14.3227 5.8875 15.2859 6.56484C15.7523 6.89297 16.1648 7.28672 16.5141 7.73438C16.868 8.18672 17.1492 8.68828 17.3508 9.22031L17.6742 10.0758L18.5602 10.3102C19.8305 10.6523 20.7188 11.8078 20.7188 13.125C20.7188 13.9008 20.4164 14.632 19.868 15.1805C19.599 15.451 19.2791 15.6655 18.9266 15.8115C18.5742 15.9576 18.1963 16.0323 17.8148 16.0312H16.875C16.7719 16.0312 16.6875 16.1156 16.6875 16.2188V17.625C16.6875 17.7281 16.7719 17.8125 16.875 17.8125H17.8148C20.4023 17.8125 22.5 15.7148 22.5 13.125C22.5 10.9523 21.0211 9.12422 19.0172 8.59453Z"
                        fill="white" />
                </svg> Скачать прайс-лист </a>
        </div>
    </div>

<? } ?>