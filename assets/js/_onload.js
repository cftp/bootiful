jQuery(document).ready(function() {

	// we have js
	jQuery('html').removeClass('no-js').addClass('js');

	// responsive sidebar
	jQuery('.sidebar-toggle').on('click', function(e) {

		e.preventDefault();
		jQuery('#wrapper').toggleClass('navigation-open');

	});

	// on the homepage open the sidebar by default
	if (jQuery('body').hasClass('home')) {
		jQuery('#wrapper').addClass('navigation-open');
	}

	// bind a click event to the 'skip' link
	jQuery(".skip-content").click(function(event){

		// strip the leading hash and declare
		// the content we're skipping to
		var skipTo="#"+this.href.split('#')[1];

		// Setting 'tabindex' to -1 takes an element out of normal
		// tab flow but allows it to be focused via javascript
		jQuery(skipTo).attr('tabindex', -1).on('blur focusout', function () {

			// when focus leaves this element,
			// remove the tabindex attribute
			jQuery(this).removeAttr('tabindex');

		}).focus(); // focus on the content container
	});
});