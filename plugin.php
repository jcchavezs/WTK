<?php
/**
 * Plugin Name:  Widget Toolkit
 * Plugin URI:   https://github.com/jcchavezs/wtk
 * Description:	 A toolkit for creating widgets in an easy way.
 * Author:       José Carlos Chávez <jcchavezs@gmail.com>
 * Author URI:   http://github.com/jcchavezs
 * Version:      1.0.0
 * Github Plugin URI: https://github.com/jcchavezs/wtk
 * Github Branch: master
 */

require __DIR__ . '/classes/widget.php';
require __DIR__ . '/classes/widget_form.php';
require __DIR__ . '/classes/widget_form_element.php';

add_action( 'admin_init', 'wtk_enqueue_scripts' );

/**
 * Registers and enqueues the assets.
 */
function wtk_enqueue_scripts() {
	wp_enqueue_style(
		'wtk',
		plugins_url('/css/wtk.css', __FILE__),
		array(),
		'1.0.0'
	);

	wp_register_script(
		'wtk',
		plugins_url('/js/base.js', __FILE__),
		array( 'jquery' ),
		'1.0.0',
		true
	);

	wp_register_script(
		'wtk-image',
		plugins_url('/js/image.js', __FILE__),
		array( 'wtk' ),
		'1.0.0',
		true
	);
}

add_action( 'plugins_loaded', 'wtk_load_textdomain' );

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function wtk_load_textdomain() {
	load_plugin_textdomain( 'wtk', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}