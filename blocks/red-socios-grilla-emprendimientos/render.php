<?php

namespace Futura\Blocks\GrillaEmprendimientos;

use WP_Query;

function render ($block_attributes, $content) {
    $query = new WP_Query([
        'cache_results' => true,
        'post_type' => 'emprendimiento-red',
        'posts_per_page' => -1,
    ]);

    $items = [];
    foreach ($query->posts as $post) {
        $thumb = get_the_post_thumbnail($post, 'medium');
        $title = $post->post_title;
        $link = get_post_meta($post->ID, 'main_link', true);

        $item = <<<HTML
                <div class="block-grilla-emprendimientos--item">
                    <a title="{$title}" href="{$link}" target="_blank">
                        {$thumb}
                    </a>
                </div>
        HTML;

        $items[] = $item;
    }

    $inner = join("\n", $items);

    $html = <<<HTML
        <div class="block-grilla-emprendimientos">
            {$inner}
        </div>
    HTML;

    return $html;
}