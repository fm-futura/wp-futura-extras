<?php


function futura_register_cpt () {
    register_post_type(
        'emprendimiento-red',
        [
            'description' => 'Emprendimientos adheridos a la Red de Socios',
            'label' => 'Emprendimientos Red de Socios',
            'labels' => [
                'singular_name' => 'Emprendimiento Red de Socios',
                'all_items' => 'Ver todos',
                'view_items' => 'Ver todos',
                'view_item' => 'Ver',
            ],
            'public' => true,
            'menu_icon' => 'dashicons-groups',
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'rest_base' => 'red-socios/emprendimientos-adheridos',
            'rewrite' => [
                'slug' => 'red-socios/emprendimientos-adheridos'
            ],
            'supports' => [
                'title', 'editor', 'thumbnail', 'custom-fields', 'post-formats',
            ],
            'taxonomies' => [
                'category', 'post_tag',
            ],
        ]
    );

    register_post_meta(
        'emprendimiento-red',
        'main_link',
        [
            'single' => true,
            'type' => 'string',
            'description' => 'Sitio web del emprendimiento',
            'show_in_rest' => true,
        ]
    );
}
add_action( 'init', 'futura_register_cpt' );
