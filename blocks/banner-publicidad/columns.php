<?php

namespace Futura\Blocks\BannerPublicidad;


function add_columns($columns) {
    unset($columns['date']);
    unset($columns['comments']);
    unset($columns['likes']);

    $columns['start_date'] = 'Fecha inicio';
    $columns['end_date'] = 'Fecha finalización';
    $columns['link'] = 'Enlace';
    $columns['banner_image'] = 'Imagen';

    return $columns;
}
add_filter('manage_banner-publicidad_posts_columns', 'Futura\Blocks\BannerPublicidad\add_columns');


function render_custom_column($column, $id) {
    $post = get_post();
    $date = null;

    switch ($column) {
    case 'start_date':
        $date = $post->start_date;
        break;

    case 'end_date':
        $date = $post->end_date;
        break;

    case 'link':
        $target = $post->main_link;
        if ($target) {
            $target = esc_url($target);
            echo "<a target=\"_blank\" href=\"{$target}\"> {$target} </a>";
        }
        break;

    case 'banner_image':
        echo get_the_post_thumbnail($post, [80, 80]);
        break;
    }


    if ($date) {
        $date = date_create_immutable_from_format( 'Y-m-d\TH:i:s', $date);
        echo $date->format(get_option('date_format'));
    }
}
add_action('manage_banner-publicidad_posts_custom_column', 'Futura\Blocks\BannerPublicidad\render_custom_column', 10, 2);
