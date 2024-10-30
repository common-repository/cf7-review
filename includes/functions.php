<?php
/*
 * Since 1.0.0
 * 
 * return 
 * 
 * @string : url
 */
defined('ABSPATH') or die();

/*
 * Since 1.0.0
 * 
 * return 
 * 
 * @string : url
 */
function wpcf7_review_url( $path = '' )
{
	return plugins_url( $path, wpcf7_review_index());
}

/*
 * Since 1.0.0
 * 
 * return 
 * 
 * @string : path
 */
function wpcf7_review_path( $path = '' )
{
	return dirname(wpcf7_review_index()) . ( substr($path,0,1) !== '/' ? '/' : '' ) . $path;
}

/*
 * Since 1.0.0
 * 
 * return 
 * 
 * @boolean
 */
function wpcf7_review_include( $path_file = '' )
{
	if( $path_file!='' && file_exists( $p = wpcf7_review_path('includes/'.$path_file ) ) ) {
		require $p;
		return true;
	}
	return false;
}

/*
 * Since 1.0.2
 * 
 * return  
 * 
 * @array WP_Post : pages
 */
function wpcf7_review_get_pages_has_cf7_form()
{
	global $wpdb;

	$key = '[contact-form-7';
	
	$list = $wpdb->get_results( " SELECT * FROM `$wpdb->posts` WHERE `post_type` = 'page' AND `post_content` LIKE '%$key%' " );

	return $list;
}