<?php
// Compatibility mode
define('DM_COMPATIBILITY', 'yes');

// domain mapping plugin to handle VHOST and non VHOST installation
global $wpdb;

// No if statement needed as the code was the same for both VHOST and non VHOST installations
if(defined('DM_COMPATIBILITY')) {
	$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';
} else {
	$wpdb->dmtable = $wpdb->base_prefix . 'domain_map';
}


$wpdb->suppress_errors();

$using_domain = $wpdb->escape( preg_replace( "/^www\./", "", $_SERVER[ 'HTTP_HOST' ] ) );

$mapped_id = $wpdb->get_var( "SELECT blog_id FROM {$wpdb->dmtable} WHERE domain = '{$using_domain}' LIMIT 1 /* domain mapping */" );

$wpdb->suppress_errors( false );

if( $mapped_id ) {
	$current_blog = $wpdb->get_row("SELECT * FROM {$wpdb->blogs} WHERE blog_id = '{$mapped_id}' LIMIT 1 /* domain mapping */");
	$current_blog->domain = $_SERVER[ 'HTTP_HOST' ];

	$blog_id = $mapped_id;
	$site_id = $current_blog->site_id;

	define( 'COOKIE_DOMAIN', $_SERVER[ 'HTTP_HOST' ] );

	$current_site = $wpdb->get_row( "SELECT * from {$wpdb->site} WHERE id = '{$current_blog->site_id}' LIMIT 0,1 /* domain mapping */" );

	$current_blog->path = $current_site->path;

	define( 'DOMAIN_MAPPING', 1 );

	// Added for belt and braces
	if ( !defined('WP_CONTENT_URL') ) {
		$protocol = ( 'on' == strtolower( $_SERVER['HTTPS' ] ) ) ? 'https://' : 'http://';
		define( 'WP_CONTENT_URL', $protocol . $current_blog->domain . $current_blog->path . 'wp-content'); // full url - WP_CONTENT_DIR is defined further up
	}

}

?>
