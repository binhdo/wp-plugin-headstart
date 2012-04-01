<?php
/*
 * Headstart plugin settings
 */

add_action( 'admin_menu', 'headstart_settings_page_setup' );

function headstart_settings_page_setup() {

	global $headstart;

	$headstart -> select1 = array(
		'key1' => 'value1',
		'key2' => 'value2'
	);

	/* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $funtion ); */
	$headstart -> settings_page = add_options_page( 'Headstart Settings', 'Headstart', 'manage_options', 'headstart-settings-page', 'headstart_display_settings_page' );

	add_action( 'admin_init', 'headstart_register_settings' );

	add_action( 'load-' . $headstart -> settings_page, 'headstart_settings_sections' );

	/* Admin scripts & Styles */
	add_action( 'admin_print_scripts-' . $headstart -> settings_page, 'headstart_admin_scripts' );
	add_action( 'admin_print_styles-' . $headstart -> settings_page, 'headstart_admin_styles' );

}

function headstart_register_settings() {

	/* register_setting( $option_group, $option_name, $sanitize_callback ); */
	register_setting( 'headstart_settings', 'headstart_settings', 'headstart_validate_settings' );
}

function headstart_settings_sections() {

	/* add_settings_section( $id, $title, $callback, $page ); */
	add_settings_section( 'main_settings', 'Main Settings', 'headstart_section_main', 'headstart-settings-page' );

}

function headstart_section_main() {

	global $headstart;

}

function headstart_create_setting($args = array(), $before = '<p>', $after = '</p>') {

	extract( $args );

	$field_value = headstart_get_option( $id );
	$prefix = 'headstart_settings';

	$html = $before . "\n";

	switch ($type) {
		case 'text':
			$html .= "\t" . '<input type="text" id="' . $id . '" name="' . $prefix . '[' . $id . ']" ';
			if ( isset( $class ) )
				$html .= 'class="' . $class . '" ';
			$html .= 'value="' . esc_attr( $field_value ) . '" />' . "\n";
			if ( isset( $label ) )
				$html .= "\t" . '<label for="' . $id . '">' . $label . '</label>' . "\n";
			if ( isset( $desc ) )
				$html .= '<span class="description">' . esc_attr( $desc ) . '</span>' . "\n";
			break;

		case 'checkbox':
			$html .= "\t" . '<input type="checkbox" id="' . $id . '" name="' . $prefix . '[' . $id . ']" ';
			if ( isset( $class ) )
				$html .= 'class="' . $class . '" ';
			$html .= 'value="' . $value . '"' . checked( $value, $field_value, false ) . ' />' . "\n";
			if ( isset( $label ) )
				$html .= "\t" . '<label for="' . $id . '">' . $label . '</label>' . "\n";
			if ( isset( $desc ) )
				$html .= '<span class="description">' . esc_attr( $desc ) . '</span>' . "\n";
			break;

		case 'select':
			$html .= "\t" . '<select id="' . $id . '" name="' . $prefix . '[' . $id . ']"';
			if ( isset( $class ) )
				$html .= ' class="' . $class . '"';
			$html .= '>';
			foreach ( $options as $value => $label ) {
				$html .= "\t\t" . '<option value="' . esc_attr( $value ) . '"' . selected( $value, $field_value, false ) . '>' . esc_attr( $label ) . '</option>' . "\n";
			}
			$html .= "\t" . '</select>' . "\n";
			if ( isset( $label ) )
				$html .= "\t" . '<label for="' . $id . '">' . $label . '</label>' . "\n";
			if ( isset( $desc ) )
				$html .= '<span class="description">' . esc_attr( $desc ) . '</span>' . "\n";
			break;

		default:
			break;
	}

	$html .= $after . "\n";

	return $html;

}

function headstart_display_settings_page() {

	echo '<div class="wrap">' . "\n";

	screen_icon( );

	echo '<h2>Headstart Settings</h2>' . "\n";

	settings_errors( );

	echo '<form method="post" action="options.php">' . "\n";

	settings_fields( 'headstart_settings' );
	do_settings_sections( $_GET['page'] );
	submit_button( esc_attr__( 'Update Settings' ) );

	echo '</form>' . "\n";
	echo '</div>' . "\n";

}

function headstart_validate_settings($input) {

	global $headstart;

	$integer_options = array(
		'int1',
		'int2'
	);

	foreach ( $integer_options as $integer_option ) {
		$settings[$integer_option] = is_numeric( $input[$integer_option] ) ? intval( $input[$integer_option] ) : headstart_get_option( $integer_option );
	}

	$checkbox_options = array(
		'checkbox1',
		'checkbox2',
	);

	foreach ( $checkbox_options as $checkbox_option ) {
		$settings[$checkbox_option] = isset( $input[$checkbox_option] ) ? true : false;
	}

	if ( array_key_exists( $input['select1'], $headstart -> select1 ) )
		$settings['select1'] = $input['select1'];

	return $settings;

}

function headstart_admin_scripts() {

	wp_enqueue_script( 'headstart-admin-script', HEADSTART_URI . 'js/admin-script.js' );

}

function headstart_admin_styles() {

	wp_enqueue_style( 'headstart-admin-style', HEADSTART_URI . 'css/admin-style.css' );

}
?>