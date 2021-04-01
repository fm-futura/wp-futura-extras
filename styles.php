<?php

function wp_futura_styles_init()
{
    wp_enqueue_style('futura_author_styles',        plugins_url('css/author.css', __FILE__));
    wp_enqueue_style('futura_social_icons_styles',  plugins_url('css/futura-social-icons.css', __FILE__));
    wp_enqueue_style('futura_google_fonts',         plugins_url('css/google-fonts.css', __FILE__));
    wp_enqueue_style('futura_futura_fonts',         plugins_url('css/futura-fonts.css', __FILE__));
    wp_enqueue_style('futura_links',                plugins_url('css/links.css', __FILE__));
    wp_enqueue_style('futura_yotu',                 plugins_url('css/yotu.css', __FILE__));
    wp_enqueue_style('futura_main',                 plugins_url('css/main.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'wp_futura_styles_init');
add_action('admin_enqueue_scripts', 'wp_futura_styles_init');
