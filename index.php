<?php
/*
Plugin Name: Contact Form 7 Preview
Plugin URI: https://wordpress.org/plugins/cf7-review
Description: Preview Form before save in edit form for Contact Form 7.
Author: MoiVui
Author URI: http://photoboxone.com/donate/?developer=moivui
Version: 1.0.8
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') or die();

function wpcf7_review_index()
{
	return __FILE__;
}

require( dirname(__FILE__). '/includes/functions.php');

if( is_admin() ) {
	
	wpcf7_review_include( 'wpcf7_review.php' );
	
} else {

	wpcf7_review_include( 'site.php' );

}