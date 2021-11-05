<?php

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


function futura_shortcode_social_icons($atts)
{
    ob_start();
    $a = shortcode_atts([
        'no-logo' => false,
        'class' => '',
    ], $atts);

    $show_logo = !$a['no-logo'];
    $class = $a['class'];

    if (!$show_logo) {
      $class .= ' no-logo';
    }

    include('shortcodes/futura_social_icons.php');
    return ob_get_clean();
}


function futura_shortcode_links($atts)
{
    ob_start();
    include('shortcodes/futura_links.php');
    return ob_get_clean();
}


// XXX FIXME: later cache this for non logged in users
function futura_shortcode_tags($atts)
{
    $args = [
        'post_type' => [
            'podcast',
            'post'
        ],
        'date_query' => [
            'after' => '1 week ago'
        ]
    ];

    $q = new WP_Query($args);
    $ids = wp_list_pluck($q->posts, 'ID');
    // slug -> name
    $slug_name_map = [];
    // slug -> tag
    $slug_tag_map = [];
    // slug -> count
    $tags_counts = [];

    foreach ($q->posts as $post) {
        $tags = get_the_tags($post);
        if (!$tags) { continue; }
        foreach ($tags as $idx => $tag) {
            $slug = $tag->slug;
            $slug_tag_map[$slug] = $tag;
            $slug_name_map[$slug] = $tag->name;
            $count = ($tags_counts[$slug] ?? 0) + 1;
            $tags_counts[$slug] = $count;
        }
    }

    asort($tags_counts, SORT_NUMERIC);
    $tags_counts = array_reverse($tags_counts);

    $tags = [];
    foreach ($tags_counts as $slug => $count) {
        $tags[$slug_name_map[$slug]] = get_tag_link($slug_tag_map[$slug]);
    }

    ob_start();
    include('shortcodes/futura_tags.php');
    return ob_get_clean();
}


function wp_futura_shortcodes_init()
{
    wp_enqueue_style('futura_reproductoraudio_materialicons',   plugins_url('libs/materialicons/MaterialDesignIcons.css', __FILE__));
    wp_enqueue_script('futura_reproductoraudio_audioPlayer',    plugins_url('widgets/audioPlayer/audioPlayer.js',  __FILE__), array('jquery'));
    wp_enqueue_style('futura_reproductoraudio_audioPlayer',     plugins_url('widgets/audioPlayer/audioPlayer.css', __FILE__), array('futura_reproductoraudio_materialicons'));

    add_shortcode( 'reproductoraudio',      'futura_shortcode_reproductoraudio' );
    add_shortcode( 'futura-social-icons',   'futura_shortcode_social_icons' );
    add_shortcode( 'futura-links',          'futura_shortcode_links' );
    add_shortcode( 'futura-tags',           'futura_shortcode_tags' );
}
add_action('init', 'wp_futura_shortcodes_init');
