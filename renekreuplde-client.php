<?php
/**
 * Plugin Name: renekreupl.de Client
 * Text Domain: rkClient
 * Domain Path: /languages
 * Plugin URI:  http://
 * Description:	Brings some Function to Client WP
 * Author:      Rene Kreupl
 * Author URI:  http://www.renekreupl.de/
 * Version:     1.2
 *
 *
 *
 * License:
 * ==============================================================================
 * Copyright 2013 Rene Kreupl  (email : info@renekreupl.de)
 *
 * Requirements:
 * ==============================================================================
 * This plugin requires WordPress >= 3.6 and was tested with PHP Interpreter >= 5.3
 */

//TODO: All Function to class.rkclient.php with Config Options

function custom_login_logo() {
	echo '<style type="text/css">
	.login h1 a { background-image:url('.plugins_url( 'media/renekreupl-login.jpg' , __FILE__ ).') !important; background-size: 312px 82px !important; margin: 0 auto; width: 312px; }
	.login form {margin-top:0;}
	</style>';
}
add_action('login_head', 'custom_login_logo');

function remove_dashboard_widgets() {
	$user = wp_get_current_user();
	if ( ! $user->has_cap( 'manage_options' ) ) {
		//remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	}
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

function add_dashboard_widgets() {
	wp_add_dashboard_widget( 'dashboard_welcome', 'Info', 'add_info_widget' );
}
function add_info_widget() {
	echo '
			<img src="'.plugins_url( 'media/renekreupl-login.jpg' , __FILE__ ).'" alt="renekreupl.de">
			<p><b>Kontakt & Support</b></p>
			<p>info@renekreupl.de<br>www.renekreupl.de</p>
	';
}
add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );


function change_footer_admin () {
	echo 'Powered by <a href="http://www.renekreupl.de" title="renekreupl.de">renekreupl.de</a>';
}
add_filter('admin_footer_text', 'change_footer_admin');

function change_names( $translated ) {
	$translated = str_ireplace('Dashboard', 'Übersicht', $translated );
	return $translated;
}
add_filter('gettext', 'change_names');
add_filter('ngettext', 'change_names');

function hide_update_notice() {
	remove_action('admin_notices', 'update_nag', 3);
}
add_action('admin_menu', 'hide_update_notice');


foreach ( array( 'the_content', 'the_title', 'comment_text' ) as $filter ) {
	remove_filter( $filter, 'capital_P_dangit' );
}

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');


/*remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'index_rel_link'); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.*/
