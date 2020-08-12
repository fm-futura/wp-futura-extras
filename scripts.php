<?php

function wp_futura_scripts_init()
{
    if (!is_user_logged_in()) {
        wp_enqueue_script('futura_turbolinks',    plugins_url('libs/turbolinks/turbolinks.js',  __FILE__));
    }
}
add_action('wp_enqueue_scripts', 'wp_futura_scripts_init');
