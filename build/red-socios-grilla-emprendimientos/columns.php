<?php

namespace Futura\Blocks\GrillaEmprendimientos;


function add_columns($columns) {
    unset($columns['comments']);
    unset($columns['likes']);

    $columns['link'] = 'Enlace';
    $columns['banner_image'] = 'Imagen';

    return $columns;
}
add_filter('manage_emprendimiento-red_posts_columns', 'Futura\Blocks\GrillaEmprendimientos\add_columns');


function render_custom_column($column, $id) {
    $post = get_post();
    $date = null;

    switch ($column) {

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
}
add_action('manage_emprendimiento-red_posts_custom_column', 'Futura\Blocks\GrillaEmprendimientos\render_custom_column', 10, 2);
