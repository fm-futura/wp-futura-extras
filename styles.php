<?php

function wp_futura_styles_init()
{
    wp_enqueue_style('futura_author_styles',   plugins_url('css/author.css', __FILE__));
}
add_action('init', 'wp_futura_styles_init');
