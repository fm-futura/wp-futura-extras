<?php

namespace Futura\Blocks\BannerPublicidad;

use WP_Query;

function render ($block_attributes, $content) {
    $today = (new \DateTime())->format('Y-m-d');

    $query = new WP_Query([
        //'cache_results' => true,
        //'post_status' => 'any',
        'post_type' => 'banner-publicidad',
        'posts_per_page' => 1,
        'orderby' => 'rand',
        'meta_query' => [
            [
                'key' => 'start_date',
                'value' => $today,
                'type' => 'date',
                'compare' => '<=',
            ],
            [
                'key' => 'end_date',
                'value' => $today,
                'type' => 'date',
                'compare' => '>=',
            ],
        ],
    ]);

    $items = [];
    foreach ($query->posts as $post) {
        $thumb = get_the_post_thumbnail($post, 'full');
        $title = $post->post_title;
        $link = esc_url($post->main_link);
        $start_date = $post->start_date;
        $end_date = $post->end_date;

        $item = <<<HTML
                <div class="block-banner-publicidad--item">
                    <a title="{$title}" href="{$link}" target="_blank">
                        {$thumb}
                    </a>
                </div>
        HTML;

        $items[] = $item;
    }

    $inner = join("\n", $items);

    $html = <<<HTML
        <div class="block-banner-publicidad--container">
            <div class="block-banner-publicidad">
                {$inner}
            </div>
        </div>
    HTML;

    return $html;
}

