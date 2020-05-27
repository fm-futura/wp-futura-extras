<?php

function wp_futura_styles_init()
{
    wp_enqueue_style('futura_author_styles',        plugins_url('css/author.css', __FILE__));
    wp_enqueue_style('futura_social_icons_styles',  plugins_url('css/futura-social-icons.css', __FILE__));
    wp_enqueue_style('futura_google_fonts',         plugins_url('css/google-fonts.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'wp_futura_styles_init');
