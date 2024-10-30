/*
 * WPCF7 Review: https://moivui.com/
 *
 * Admin
 * 
 */
(function($){

	$(document).ready(function(){		
		if( typeof ajaxurl == 'undefined' ) {
			return false;
		}

		set_no_click();

		$('#review-panel-tab').click(function(e){

			// console.log( ajaxurl );

			var tab = $('#wpcf7_review_tab_content'),
				old = tab.html(),
				content = $('#wpcf7-form').val();

			if( content && content!='' && content!=old ) {

				tab.html('Please waiting .... !');

				$.post(
					ajaxurl, 
					{
						'action': 'wpcf7_review_form',
						'post_id': $('#post_ID').val(),
						'content':   content
					},
					function(response) {

						// console.log('The server responded: ', response);

						if( response ) {
							tab.html(response);
						} else {
							tab.html(old);
						}

						set_no_click();
						
					}
				);

			}

		});

		$('#informationdiv').after($('.postbox-donate').show());
		
	} );


	function set_no_click()
	{
		$('#wpcf7_review_tab_content').each(function(){
			
			$('form', this).submit(function(e){
				e.preventDefault();
			});
			
		});
	}
	
})(jQuery);