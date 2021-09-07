<?php

function futura_futura_blocks_block_init() {
    register_block_type( __DIR__ . '/build/links-a-botones');
    register_block_type( __DIR__ . '/build/red-socios-metabox');
}
add_action( 'init', 'futura_futura_blocks_block_init' );
