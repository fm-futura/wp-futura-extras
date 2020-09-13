<?php

// Shamlesly based on https://github.com/hlashbrooke/WordPress-Plugin-Template/
// https://hugh.blog/2014/02/26/complete-versatile-options-page-class-wordpress-plugin/

if ( ! defined( 'ABSPATH' ) ) exit;

class Futura_Extras_Settings {
    private $dir;
    private $file;
    private $assets_dir;
    private $assets_url;
    private $settings_base;
    private $settings;

    public function __construct( $file ) {
        $this->file = $file;
        $this->dir = dirname( $this->file );
        $this->assets_dir = trailingslashit( $this->dir ) . 'assets';
        $this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
        $this->settings_base = 'futura_';

        // Initialise settings
        add_action( 'admin_init', array( $this, 'init' ) );

        // Register plugin settings
        add_action( 'admin_init' , array( $this, 'register_settings' ) );

        // Add settings page to menu
        add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

        // Add settings link to plugins page
        add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this, 'add_settings_link' ) );
    }

    /**
     * Initialise settings
     * @return void
     */
    public function init() {
        $this->settings = $this->settings_fields();
    }

    /**
     * Add settings page to admin menu
     * @return void
     */
    public function add_menu_item() {
        $page = add_options_page( __( 'Futura Extras', 'futura' ) , __( 'Futura', 'futura' ) , 'manage_options' , 'futura_settings' ,  array( $this, 'settings_page' ) );
        add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
    }

    /**
     * Load settings JS & CSS
     * @return void
     */
    public function settings_assets() {

    }

    /**
     * Add settings link to plugin list table
     * @param  array $links Existing links
     * @return array        Modified links
     */
    public function add_settings_link( $links ) {
        $settings_link = '<a href="options-general.php?page=futura_settings">' . __( 'Futura', 'futura' ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }

    /**
     * Build settings fields
     * @return array Fields to be displayed on settings page
     */
    private function settings_fields() {

        $settings['Extras'] = array(
            'title'                 => __( 'Extras', 'futura' ),
            'description'           => __( '', 'futura' ),
            'fields'                => array(
                array(
                    'id'            => 'enable_turbolinks',
                    'label'         => __( 'Habilitar Turbolinks', 'futura' ),
                    'description'   => __( 'Habilitar Turbolinks (ojo, puede romper la navegación en el sitio)', 'futura' ),
                    'type'          => 'checkbox',
                    'default'       => ''
                ),
            )
        );

        return $settings;
    }

    /**
     * Register plugin settings
     * @return void
     */
    public function register_settings() {
        if( is_array( $this->settings ) ) {
            foreach( $this->settings as $section => $data ) {

                // Add section to page
                add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'futura_settings' );

                foreach( $data['fields'] as $field ) {

                    // Validation callback for field
                    $validation = '';
                    if( isset( $field['callback'] ) ) {
                        $validation = $field['callback'];
                    }

                    // Register field
                    $option_name = $this->settings_base . $field['id'];
                    register_setting( 'futura_settings', $option_name, $validation );

                    // Add field to page
                    add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'futura_settings', $section, array( 'field' => $field ) );
                }
            }
        }
    }

    public function settings_section( $section ) {
        $html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
        echo $html;
    }

    /**
     * Generate HTML for displaying fields
     * @param  array $args Field data
     * @return void
     */
    public function display_field( $args ) {

        $field = $args['field'];

        $html = '';

        $option_name = $this->settings_base . $field['id'];
        $option = get_option( $option_name );

        $data = '';
        if( isset( $field['default'] ) ) {
            $data = $field['default'];
            if( $option ) {
                $data = $option;
            }
        }

        switch( $field['type'] ) {

            case 'text':
            case 'password':
            case 'number':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . $data . '"/>' . "\n";
            break;

            case 'text_secret':
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value=""/>' . "\n";
            break;

            case 'textarea':
                $html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . $data . '</textarea><br/>'. "\n";
            break;

            case 'checkbox':
                $checked = '';
                if( $option && 'on' == $option ){
                    $checked = 'checked="checked"';
                }
                $html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
            break;

            case 'checkbox_multi':
                foreach( $field['options'] as $k => $v ) {
                    $checked = false;
                    if( in_array( $k, $data ) ) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
                }
            break;

            case 'radio':
                foreach( $field['options'] as $k => $v ) {
                    $checked = false;
                    if( $k == $data ) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
                }
            break;

            case 'select':
                $html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
                foreach( $field['options'] as $k => $v ) {
                    $selected = false;
                    if( $k == $data ) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
                }
                $html .= '</select> ';
            break;

            case 'select_multi':
                $html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
                foreach( $field['options'] as $k => $v ) {
                    $selected = false;
                    if( in_array( $k, $data ) ) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . $v . '</label> ';
                }
                $html .= '</select> ';
            break;

            case 'image':
                $image_thumb = '';
                if( $data ) {
                    $image_thumb = wp_get_attachment_thumb_url( $data );
                }
                $html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
                $html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . __( 'Upload an image' , 'futura' ) . '" data-uploader_button_text="' . __( 'Use image' , 'futura' ) . '" class="image_upload_button button" value="'. __( 'Upload new image' , 'futura' ) . '" />' . "\n";
                $html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="'. __( 'Remove image' , 'futura' ) . '" />' . "\n";
                $html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
            break;

            case 'color':
                ?><div class="color-picker" style="position:relative;">
                    <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>" />
                    <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
                </div>
                <?php
            break;

        }

        switch( $field['type'] ) {

            case 'checkbox_multi':
            case 'radio':
            case 'select_multi':
                $html .= '<br/><span class="description">' . $field['description'] . '</span>';
            break;

            default:
                $html .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
            break;
        }

        echo $html;
    }

    /**
     * Validate individual settings field
     * @param  string $data Inputted value
     * @return string       Validated value
     */
    public function validate_field( $data ) {
        if( $data && strlen( $data ) > 0 && $data != '' ) {
            $data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
        }
        return $data;
    }

    /**
     * Load settings page content
     * @return void
     */
    public function settings_page() {

        // Build page HTML
        $html = '<div class="wrap" id="futura_settings">' . "\n";
            $html .= '<h2>' . __( 'Configuración específica de Futura' , 'futura' ) . '</h2>' . "\n";
            $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

                // Setup navigation
                $html .= '<ul id="settings-sections" class="subsubsub hide-if-no-js">' . "\n";
                    $html .= '<li><a class="tab all current" href="#all">' . __( 'All' , 'futura' ) . '</a></li>' . "\n";

                    foreach( $this->settings as $section => $data ) {
                        $html .= '<li>| <a class="tab" href="#' . $section . '">' . $data['title'] . '</a></li>' . "\n";
                    }

                $html .= '</ul>' . "\n";

                $html .= '<div class="clear"></div>' . "\n";

                // Get settings fields
                ob_start();
                settings_fields( 'futura_settings' );
                do_settings_sections( 'futura_settings' );
                $html .= ob_get_clean();

                $html .= get_submit_button();
                $html .= "\n";

            $html .= '</form>' . "\n";
        $html .= '</div>' . "\n";

        echo $html;
    }

}

new Futura_Extras_Settings(__FILE__);
