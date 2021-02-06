<?php
/**
 * Basic Wordpress Plugin
 * 
 * @package           Basic Wordpress Plugin Package
 * @author            
 * @version 
 * @copyright         
 * @license   
 * @link        
 *
 * @wordpress-plugin
 * Plugin Name:       Basic Wordpress Plugin
 * Plugin URI:        
 * Description:       
 * Version:           1.0.0
 * Requires at least: 
 * Requires PHP:      
 * Author:            
 * Author URI:        
 * Text Domain:       
 * License:           
 * License URI:       
 */



class Wpplugin {
    private $wpplugin_options;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'wpplugin_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'wpplugin_page_init' ) );
        add_shortcode('simple-shortcode', array( $this, 'wpplugin_shortcode' ) );
    }

    public function wpplugin_add_plugin_page() {
        add_menu_page(
            'Wpplugin', 
            'Wpplugin', // название в меню
            'manage_options', 
            'wpplugin', // ссылка на страницу плагина
            array( $this, 'wpplugin_create_admin_page' ), // function
            'dashicons-admin-generic', // иконка перед названием
            99 // позиция
        );
    }

    public function wpplugin_create_admin_page() {
        $this->wpplugin_options = get_option( 'wpplugin_option_name' ); ?>

        <div class="wrap">
            <h2>Basic Wordpress Plugin</h2>
            <p>Lorem ipsum dolor, sit amet.</p>
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                    settings_fields( 'wpplugin_option_group' );
                    do_settings_sections( 'wpplugin-admin' );
                    submit_button();
                ?>
            </form>

            <?php 
            //Test
            //$test = get_option( 'wpplugin_option_name' );
            //print_r($test);
             
            ?>

        </div>
    <?php }

    public function wpplugin_page_init() {
        register_setting(
            'wpplugin_option_group',
            'wpplugin_option_name', 
            array( $this, 'wpplugin_sanitize' ) // sanitize_callback
        );

        add_settings_section(
            'wpplugin_setting_section', // id
            'Настройки или какой нибудь текст', // title
            array( $this, 'wpplugin_section_info' ), // callback
            'wpplugin-admin' // page
        );

        add_settings_field(
            'wpplug', // id
            'Введите текст', // перед полем ввода
            array( $this, 'wpplug_callback' ), // callback
            'wpplugin-admin', // page
            'wpplugin_setting_section' // section
        );
    }

    public function wpplugin_sanitize($input) {
        $sanitary_values = array();
        if ( isset( $input['wpplug'] ) ) {
            $sanitary_values['wpplug'] = sanitize_text_field( $input['wpplug'] );
        }

        return $sanitary_values;
    }

    public function wpplugin_section_info() {
        
    }

    public function wpplug_callback() {
        printf(
            '<input class="regular-text" type="text" name="wpplugin_option_name[wpplug]" id="wpplug" value="%s">',
            isset( $this->wpplugin_options['wpplug'] ) ? esc_attr( $this->wpplugin_options['wpplug']) : ''
        );
    }

    //шорткод для отображения введеного текста [simple-shortcode]   
    public function wpplugin_shortcode(){     
       $option_plug = get_option( 'wpplugin_option_name' );
        return $option_plug['wpplug'];
    }

}

 new Wpplugin();

