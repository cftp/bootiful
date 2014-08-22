jQuery(document).ready(function() {

	// responsive sidebar
	jQuery('.sidebar-toggle').on('click', function(e) {

		e.preventDefault();
		jQuery('#wrapper').toggleClass('navigation-open');

	});

	// on the homepage open the sidebar by default on small screens
	if (Modernizr.mq('only screen and (max-width: 320px)')) {
		if (jQuery('body').hasClass('home')) {
			jQuery('#wrapper').addClass('navigation-open');
		}
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

	// widgets in tabs
	wit_current = sessionStorage.getItem('wit_current');

	jQuery(".widget_widgets_in_tabs").tabs({
		active: wit_current,
		activate: function(event, ui) {
			sessionStorage.setItem('wit_current', ui.newTab.index());
			// scroll to top of sidebar
			jQuery("#sidebar-scroll").animate({ scrollTop: 0 }, 200);
		}
	});

	// sticky widget header in tabs nav
	jQuery(".wit-nav").stickOnScroll({
		topOffset:          0,
		bottomOffset:       0,
		viewport:           jQuery("#sidebar-scroll"),
		setParentOnStick:   false,
		setWidthOnStick:    true
	});

	// sticky share tools - only when sidebar is out? - otherwise breaks stuff
	// not overly happy with this
	var $sidebar = jQuery('#sidebar');
	var sidebarpos = $sidebar.position();
	jQuery("article .share-tools").first().stickOnScroll({
		topOffset:          sidebarpos.top,
		setParentOnStick:   true,
		setWidthOnStick:    true
	});

	jQuery(document).on("infinite-scrolled", function(ev) {
		var $sidebar = jQuery('#sidebar');
		var sidebarpos = $sidebar.position();
		jQuery(ev.newElements).find(".share-tools").first().stickOnScroll({
			topOffset:          sidebarpos.top,
			setParentOnStick:   true,
			setWidthOnStick:    true
		});
	});

});