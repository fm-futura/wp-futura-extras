<p>
<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Imagen:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $imagen ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'URL:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
</p>

