<?php

function futura_futura_blocks_block_init() {
    require_once  __DIR__ . '/build/red-socios-grilla-emprendimientos/render.php';

    register_block_type( __DIR__ . '/build/links-a-botones');
    register_block_type( __DIR__ . '/build/red-socios-metabox');
    register_block_type( __DIR__ . '/build/red-socios-grilla-emprendimientos', [
        'render_callback' => 'Futura\Blocks\GrillaEmprendimientos\render',
    ]);
}
add_action( 'init', 'futura_futura_blocks_block_init' );
