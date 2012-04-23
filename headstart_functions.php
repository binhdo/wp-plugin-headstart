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

	return $settings[$option];
}

function headstart_update_settings() {

	/* Get the settings from the database. */
	$settings = get_option( 'headstart_settings' );
	/* Get the default plugin settings. */
	$default_settings = headstart_get_default_settings( );
	/* Loop through each of the default plugin settings. */
	foreach ( $default_settings as $setting_key => $setting_value ) {
		/* If the setting didn't previously exist, add the default value to the $settings array. */
		if ( ! isset( $settings[$setting_key] ) )
			$settings[$setting_key] = $setting_value;
	}
	$settings['version'] = HEADSTART_VERSION;
	/* Update the plugin settings. */
	update_option( 'headstart_settings', $settings );

}

function headstart_get_default_settings() {

	$settings = array( 'version' => HEADSTART_VERSION );

	return $settings;

}
?>