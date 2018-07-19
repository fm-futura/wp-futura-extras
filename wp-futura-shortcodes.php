<?php
/*
Plugin Name:        FM Futura Shortcodes
Plugin URI:         https://github.com/fm-futura/wp-futura-shortcodes
GitHub Plugin URI:  https://github.com/fm-futura/wp-futura-shortcodes
Description:        Shortcodes para FM Futura
Version:            20180707
Author:             FM Futura
Author URI:         https://fmfutura.com.ar
License:            AGPL-3.0
License URI:        https://www.gnu.org/licenses/agpl-3.0.html

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/

function futura_shortcode_reproductoraudio($atts)
{
    $a = shortcode_atts(array(
        'mp3' => '',
        'ogg' => '',
        'type' => 'small',
        'color' => 'violet'
    ), $atts);
    if($a['mp3']!=''){
        include('widgets/audioPlayer/audioPlayer.php');
        return ob_get_clean();
    }
}

function futura_audiohome_filter($content)
{
    $pod = pods('post', get_the_ID());
    if ($pod->field('audio_home')) {
        $urls = explode(',', $pod->field('audio_home'));
        $home_player_content =  do_shortcode('[reproductoraudio type="small" mp3="' . $urls[0] . '" ogg="' . $urls[1] . '"]');
        return $home_player_content . $content;
    } else {
        return $content;
    }
}


function wp_futura_shortcodes_init()
{
    include_once('widgets/registerWidgets.php');
    wp_enqueue_style('futura_reproductoraudio_materialicons',   plugins_url('libs/materialicons/MaterialDesignIcons.css', __FILE__));
    wp_enqueue_script('futura_reproductoraudio_audioPlayer',    plugins_url('widgets/audioPlayer/audioPlayer.js',  __FILE__), array('jquery'));
    wp_enqueue_style('futura_reproductoraudio_audioPlayer',     plugins_url('widgets/audioPlayer/audioPlayer.css', __FILE__), array('futura_reproductoraudio_materialicons'));

    add_shortcode( 'reproductoraudio', 'futura_shortcode_reproductoraudio' );
    add_filter('the_content', 'futura_audiohome_filter');
}
add_action('init', 'wp_futura_shortcodes_init');
