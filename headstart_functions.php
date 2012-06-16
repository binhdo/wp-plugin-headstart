<?php
/*
 * Headstart plugin functions
 */

add_action( 'plugins_loaded', 'headstart_functions_setup' );

function headstart_functions_setup() {

	$old_version = headstart_get_option( 'version' );

	if ( false === get_option( 'headstart_settings' ) ) {
		add_option( 'headstart_settings', headstart_get_default_settings( ) );
	} elseif ( $old_version !== HEADSTART_VERSION ) {
		headstart_update_settings( );
	}

}

function headstart_get_option($option) {
	$settings = get_option( 'headstart_settings' );

	if ( ! is_array( $settings ) || ! array_key_exists( $option, $settings ) )
		return false;

	return $settings[$option];
}

function headstart_update_settings() {

	$settings = get_option( 'headstart_settings' );
	$default_settings = headstart_get_default_settings( );
	$settings['version'] = HEADSTART_VERSION;

	foreach ( $default_settings as $setting_key => $setting_value ) {
		if ( ! isset( $settings[$setting_key] ) )
			$settings[$setting_key] = $setting_value;
	}

	update_option( 'headstart_settings', $settings );

}

function headstart_get_default_settings() {

	$settings = array( 'version' => HEADSTART_VERSION );

	return $settings;

}
?>