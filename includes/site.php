<?php

/*
 * Since 1.0.2
 */
function wpcf7_review_filter_wpcf7_form_hidden_fields()
{
	$hidden_fields = array();

	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']:0 );
	if( $post_id>0 ) {
		$hidden_fields = array(
			'_wpcf7_preview_id' => $post_id,
		);
	}

	return $hidden_fields;
}
add_filter( 'wpcf7_form_hidden_fields', 'wpcf7_review_filter_wpcf7_form_hidden_fields' );

/*
 * Since 1.0.2
 */
function wpcf7_review_filter_contact_form_properties( $properties = array()  )
{
	if( is_array( $properties ) == false ) return $properties;

	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']: 0 );
	if( $post_id == 0 ) {
		$post_id = absint( isset($_POST['_wpcf7_preview_id'])?$_POST['_wpcf7_preview_id']: 0 );
		if( $post_id>0 ) {
			$_POST['_wpcf7_id'] = $_POST['_wpcf7_preview_id'];
		}
	}

	if( $post_id>0 ) {
		$content = (string) get_post_meta( $post_id, '_preview', $single = true );
		if( $content!='' ) {
			$properties['form'] = $content;			
		}
	}

	return $properties;
}
add_filter( 'wpcf7_contact_form_properties', 'wpcf7_review_filter_contact_form_properties' );

// Development 

/*
 * Since 1.0.2
 */
function wpcf7_review_page_has_cf7_form( $wpcf7 = false )
{
	if( $wpcf7 == false ) return $wpcf7;

	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']:0 );
	if( $post_id>0 ) {
		// $content = (string) get_post_meta( $post_id, '_preview', $single = true );
		// if( $content!='' ) {
		// 	$properties = $wpcf7->get_properties();

		// 	$properties['form'] = $content;
		
		// 	$wpcf7->set_properties( $properties );
		// }

		$wpcf7->set( 'id', $post_id  );
	}

	return $wpcf7;
}
// add_action( 'wpcf7_contact_form', 'wpcf7_review_page_has_cf7_form', 10, 2 );

/*
 * Since 1.0.2
 */
function wpcf7_review_filter_contact_form_default_pack( $contact_form = false, $args )
{
	if( $contact_form == false ) return $contact_form;

	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']:0 );
	if( $post_id>0 ) {
		$content = (string) get_post_meta( $post_id, '_preview', $single = true );
		if( $content!='' ) {
			$properties = $contact_form->get_properties();

			$properties['form'] = $content;
			
			$contact_form->set_properties( $properties );
		}
	}

	return $contact_form;
}
// add_filter( 'wpcf7_contact_form_default_pack', 'wpcf7_review_filter_contact_form_default_pack' );

/*
 * Since 1.0.2
 */
function wpcf7_review_pre_do_shortcode_tag( $false, $tag, $attr, $m )
{
	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']: 0 );
	if( $post_id>0 ) {

	}

	return $content;
}
// add_filter( 'pre_do_shortcode_tag', 'wpcf7_review_pre_do_shortcode_tag', 10, 4 );

/*
 * Since 1.0.2
 */
function wpcf7_review_add_shortcode( $atts )
{
	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']: 0 );
	if( $post_id>0 ) {

		$atts['id'] = $post_id;

	}

	return '[contact-form-7 id="'. $atts['id'] .'"]';
}
// add_shortcode( 'contact-form-7', 'wpcf7_review_add_shortcode' );

/*
 * Since 1.0.2
 */
function wpcf7_review_site_scripts()
{
	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']:0 );
	if( $post_id>0 ) {
		// wp_enqueue_script( 'cf7-review', wpcf7_review_url('/media/wpcf7_review_page.js') );
	}
}
// add_action('wp_enqueue_scripts','wpcf7_review_site_scripts');

/*
 * Since 1.0.2
 */
function wpcf7_review_wp()
{
	$post_id = absint( isset($_GET['cf7-preview'])?$_GET['cf7-preview']:0 );
	
	$expire = intval( current_time( 'U' ) ) + YEAR_IN_SECONDS;

	@setcookie( 'cf7-preview', $post_id, $expire, COOKIEPATH, COOKIE_DOMAIN );
}
// add_action('wp','wpcf7_review_wp');