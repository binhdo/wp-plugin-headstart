<?php
/*
 * Plugin Name: Headstart Plugin Template
 * Plugin URI: http://wordpress.org
 * Description: A simple wordpress plugin template.
 * Version: 0.1
 * Author: Plugin Author
 * Author URI: http://binaryhideout.com
 * License: GPLv2 or later
 */

$headstart = new HeadStart();

class HeadStart {

    function __construct() {

        add_action( 'plugins_loaded', array(
            &$this,
            'headstart_initialise'
        ) );

    }

    function headstart_initialise() {

        /* Plugin constants */
        define( 'HEADSTART_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'HEADSTART_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
        define( 'HEADSTART_VERSION', '0.1' );

        /* Include plugin functions */
        require_once (FBOXWP_DIR . 'headstart_functions.php');

        /* Include settings page /*/
        if ( is_admin( ) ) {
            require_once (FBOXWP_DIR . 'headstart_settings.php');
            add_filter( 'plugin_action_links', array(
                &$this,
                'headstart_plugin_action_links'
            ), 10, 2 );
            register_deactivation_hook( __FILE__, array(
                &$this,
                'headstart_deactivate_plugin'
            ) );
        }
		
		load_plugin_textdomain( 'headstart', false, PRETTYPHOTO_DIR . 'languages/' );
    }

    function headstart_plugin_action_links($links, $file) {

        if ( $file == plugin_basename( dirname( __FILE__ ) . '/fancybox-wp.php' ) ) {
            $links[] = '<a href="options-general.php?page=headstart-settings-page">' . __( 'Settings' ) . '</a>';
        }
        return $links;

    }

    function headstart_deactivate_plugin() {

        delete_option( 'headstart_settings' );

    }

}
?>