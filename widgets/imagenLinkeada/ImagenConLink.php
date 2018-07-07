<?php

class ImagenConLink extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'image_link', 'description' => __('Inserte en la barra lateral una imagen que redireccione a una URL.'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('imagen_link', __('Imagen con link'), $widget_ops, $control_ops);
    }

    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
        $imagen = apply_filters( 'widget_title', empty( $instance['image'] ) ? '' : $instance['image'], $instance, $this->id_base );

        $url = apply_filters( 'widget_text', empty( $instance['link'] ) ? '' : $instance['link'], $instance );
        echo $args['before_widget'];
                include('front.php');
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['image'] = strip_tags($new_instance['image']);
        if ( current_user_can('unfiltered_html') )
            $instance['link'] =  $new_instance['link'];
        else
            $instance['link'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['link']) ) ); // wp_filter_post_kses() expects slashed
        $instance['filter'] = isset($new_instance['filter']);
        return $instance;
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'image' => '', 'link' => '' ) );
        $imagen = strip_tags($instance['image']);
        $url = esc_textarea($instance['link']);
                include('back.php');
                ?>

    <?php
    }
}
function imagen_con_link_load_widget() {
    register_widget( 'ImagenConLink' );
}
add_action( 'widgets_init', 'imagen_con_link_load_widget' );
