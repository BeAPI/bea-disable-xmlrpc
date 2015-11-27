<?php
/*
  Plugin Name: BEA Disable XMLRPC
  Plugin URI: http://www.beapi.fr
  Description: Remove XMLRPC from header, remove feature from WP
  Author: BeAPI
  Author URI: http://www.beapi.fr
  Version: 0.1
 */

function remove_x_pingback( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}

add_filter( 'wp_headers', 'remove_x_pingback' );
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );
