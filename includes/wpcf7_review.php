<?php
/*
 * WPCF7 Review: https://moivui.com/
 */
defined('ABSPATH') or die();

/*
 * Since 1.0.2
 * 
 */
$pagenow 	= sanitize_text_field( isset($GLOBALS['pagenow'])?$GLOBALS['pagenow']:'' );
if( $pagenow == 'plugins.php' ){
	
	function wpcf7_review_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
		
		array_unshift($actions, '<a href="http://photoboxone.com/donate?plugin=cf7-review" target="_blank">'.__("Donate", 'cf7-review' )."</a>");
		
		return $actions;
	}

	add_filter("plugin_action_links_".plugin_basename(wpcf7_review_index()), "wpcf7_review_plugin_actions", 10, 4);
}

/*
 * Since 1.0.0
 * 
 * return 
 * 
 * @array : $panels
 */
function wpcf7_review_editor_panels( $panels = array() ){
	if( is_array($panels) && count($panels) ) {
		$temp = array();

		foreach ($panels as $key => $value) {
			$temp[$key] = $value;
			if( $key == 'form-panel' ) {
				$temp['review-panel'] = array(
					'title' => __( 'Preview', 'cf7-review' ),
					'callback' => 'wpcf7_review_tab',
				);
			}
		}

		return $temp;
	}

	return $panels;
}
add_filter( 'wpcf7_editor_panels', 'wpcf7_review_editor_panels', 10, 99 );

/*
 * Since 1.0.0
 * 
 * Update 1.0.2
 * 
 * return;
 * 
 * @html : $tab
 */
function wpcf7_review_tab()
{
	$post_id = absint( isset($_GET['post']) ? $_GET['post'] : 0 );

	echo '<div class="wpcf7_review_tab_main">';

		echo '<h2>'. __( 'Form', 'cf7-review' ) . '</h2>';
		
		echo '<hr />';

		echo '<div id="wpcf7_review_tab_content">';

		if( $post_id>0 ) {

			$p = get_post($post_id);

			$form = do_shortcode( '[contact-form-7 id="'.$post_id.'" title="'. $p->post_title .'"]' );

			echo $form;

			// echo str_replace('form', 'div', $form );
		}

		echo '</div>';

		echo '<hr />';

		echo '<div class="wpcf7_review_list_page">';

		echo '<h3>'. __( 'Select Page to preview', 'cf7-review' ) .'</h3>';
		echo '<ol>';

		$pages = wpcf7_review_get_pages_has_cf7_form();
		if( $pages!=false && count($pages) ) {
			foreach( $pages as $page ) {

				$url = get_permalink( $page->ID );

				$url .= ( strpos($url,'?')>-1 ? '&' : '?' ) . 'cf7-preview=' . $post_id;

				echo '<li>';
				
				echo '<a href="'. esc_url( $url ) .'"  target="_blank">'. $page->post_title .'</a>';
				
				echo '</li>';
			}
		}

			// echo '<p>'. __( 'No page has [contact-form-7] to preview', 'cf7-review' ) . '!</p>';
		echo '</ol>';

		echo '<p><a class="button-secondary" href="'. esc_url( admin_url('post-new.php?post_type=page') ) .'" target="_blank">' 
				. __( 'Add new page', 'cf7-review' ) 
			. '</a></p>' ;

		echo '</div>';
	echo '</div>';
}

/*
 * Since 1.0.0
 */
function wpcf7_review_admin_scripts()
{
	wp_enqueue_script( 'cf7-review', wpcf7_review_url('/media/wpcf7_review.js') );
}
add_action('admin_enqueue_scripts','wpcf7_review_admin_scripts');

/*
 * Since 1.0.0
 * 
 * Update 1.0.2
 */
function wpcf7_review_form() 
{
	$content = sanitize_textarea_field( isset($_POST['content'])?$_POST['content']:'' );
	if( $content!='' ) {

		$post_id = absint( isset($_POST['post_id'])?$_POST['post_id']:0 );
		if( $post_id>0 ) {
			update_post_meta( $post_id, '_preview', $content );
		}

		if( preg_match( '/<(div|p)/i', $content ) == false ) {
			$rows = explode("\n",$content);

			if( count($rows) ) {
				foreach( $rows as $key => $row ) {
					if( $row == '' || sanitize_text_field($row) == '' ) {
						unset($rows[$key]);
					}
				}
				$content = '<p>' . implode( '</p><p>', $rows ) . '</p>';
			}

			// $content = '<p>' . str_replace( "\n", '</p><p>', $content ) . '</p>';
		}

		$form = wpcf7_do_shortcode( $content );
		
		$form = str_replace(array('\"',"\'"), array('"',"'"), $form );

		echo '<div role="form" class="wpcf7" id="wpcf7-preview-now" lang="'. get_user_locale() .'" dir="ltr">';
		echo '<div class="screen-reader-response"></div>';
		echo $form;
		echo '</div>';
	}

    // Don't forget to stop execution afterward.
    wp_die();
}
add_action( 'wp_ajax_wpcf7_review_form', 'wpcf7_review_form', 10, 2 );

/*
 * Since 1.0.3
 */
function wpcf7_review_donate_sidebar()
{
	// $img_url = 'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif';
	// btn_donate_SM.gif / btn_buynowCC_LG.gif

	$img_url = 'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif';
	
	$t = '';
?>
	<div id="donate" class="postbox postbox-donate" style="display:none">
		<!-- <h3><?php //echo $t = __('credits'  )?></h3> -->
		<div class="inside" align="center">
			<p>
				<?php _e('Contact Form 7', 'contact-form-7' )?>
			</p>
			<p>
				<a href="https://bit.ly/donate-cf7" target="_blank" title="<?php echo $t;?>">
					<img src="<?php echo $img_url;?>" alt="<?php echo $t;?>">
				</a>
			</p>
			<hr>
			<p>
				<?php _e('Contact Form 7 Preview', 'cf7-preview' )?>
			</p>
			<p>
				<a href="https://bit.ly/donate-cf7preview" target="_blank" title="<?php echo $t;?>">
					<img src="<?php echo $img_url;?>" alt="<?php echo $t;?>">
				</a>
			</p>
		</div>
	</div>
<?php	
}
add_action( 'wpcf7_admin_footer', 'wpcf7_review_donate_sidebar', 10, 2 );