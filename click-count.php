<?php
/**
 * Plugin Name: Click Count
 * Plugin URI: https://github.com/Vyygir/click-count
 * Version: 0.1.0
 * Author: Matt Royce
 * Description: A simple way to add click counting to specific elements
**/
define('CLCO_DIR', plugins_url('/', __FILE__));

add_action('init', 'clco_load_resources');
add_action('wp_head', 'clco_create_global_js_variables');
add_action('wp_ajax_clco_count', 'clco_count');
add_action('wp_ajax_nopriv_clco_count', 'clco_count');

function clco_load_resources() {
	wp_enqueue_script('click-count', CLCO_DIR . 'js/click-count.js', array('jquery'), false, true);
}

function clco_create_global_js_variables() {
	$output = '';
	$variables = array(
		'clco_domain' => '"' . home_url() . '"',
		'clco_callbacks' => '{}'
	);
	
	foreach ($variables as $name => $value) {
		$output .= sprintf('window.%s = %s;', $name, $value);
	}

	echo '<script>' . $output . '</script>';
}

function clco_count() {
	$id = filter_input(INPUT_POST, 'id');
	$total = ($v = get_post_meta($id, 'clco_clicks', true)) ? $v : '0';
	
	update_post_meta($id, 'clco_clicks', ($total + 1));

	/* output the new total for the response */
	echo ($total + 1);

	/* kill the script to prevent a false return value */
	exit;
}