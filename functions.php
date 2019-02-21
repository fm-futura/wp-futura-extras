<?php

function futura_get_post_excerpt($post, $limit = '', $strip_tags = TRUE, $show_read_more = FALSE)
{
    global $preview;
    $more_link_text = null;
    $strip_teaser = false;

    if ( null === $more_link_text ) {
        $more_link_text = sprintf(
            '<span aria-label="%1$s">%2$s</span>',
            sprintf(
                /* translators: %s: Name of current post */
                __( 'Continue reading %s' ),
                the_title_attribute( array( 'echo' => false ) )
            ),
            __( '(more&hellip;)' )
        );
    }

    $output = '';
    $has_teaser = false;

    // If post password required and it doesn't match the cookie.
    if ( post_password_required( $post ) )
        return get_the_password_form( $post );

    $content = $post->post_content;
    if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
        $content = explode( $matches[0], $content, 2 );
        if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
            $more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );

        $has_teaser = true;
    } else {
        $content = array( $content );
    }

    if ( false !== strpos( $post->post_content, '<!--noteaser-->' ) )
        $strip_teaser = true;

    $teaser = $content[0];
    if ($strip_tags) {
        $teaser = strip_tags($teaser);
    }

    if ($limit != '') {
        $teaser = explode(' ', $teaser, $limit);

        if (count($teaser)>=$limit) {
            array_pop($teaser);
            $teaser = implode(" ",$teaser).'...';
        } else {
            $teaser = implode(" ",$teaser);
        }

        if (trim($teaser) == '...') {
            $teaser = '';
        }
    }

    $output .= $teaser;

    if ( count( $content ) > 1 ) {
        if ( !empty($more_link_text) && $show_read_more ) {

            /**
             * Filters the Read More link text.
             *
             * @since 2.8.0
             *
             * @param string $more_link_element Read More link element.
             * @param string $more_link_text    Read More text.
             */
            $output .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink($post) . "#more-{$post->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
        }
        $output = force_balance_tags( $output );
    }

    if ( $preview ) // Preview fix for JavaScript bug with foreign languages.
        $output =   preg_replace_callback( '/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output );

    return $output;
}
