<?php

function futura_futura_blocks_block_init() {
    register_block_type( __DIR__ . '/build/links-a-botones');
}
add_action( 'init', 'futura_futura_blocks_block_init' );
