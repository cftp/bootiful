// fix for jQuery UI tabs and the customiser https://core.trac.wordpress.org/ticket/23225
var makeTabs = function(selector) {
	jQuery( selector ).find( "ul a" ).each( function() {
		var href = jQuery( this ).attr( "href" ),
		newHref = window.location.protocol + '//' + window.location.hostname +
		window.location.pathname + href;

		if ( href.indexOf( "#" ) == 0 ) {
			jQuery( this ).attr( "href", newHref );
		}
	})
};

// sidebar position vars
var $sidebar, sidebarpos, sidebartop;

jQuery(document).ready(function() {

	// sidebar position
	$sidebar = jQuery('#sidebar');
	sidebarpos = $sidebar.position();
 	sidebartop = sidebarpos.top;

	var originaloffset = false;

	// responsive sidebar
	jQuery('.sidebar-toggle').on('click', function(e) {

		e.preventDefault();
		jQuery('#wrapper').toggleClass('navigation-open');

		// fixes for stuck share tools
		//var $stuck = jQuery('article .stickOnScroll-on');
		//var stuckoffset = $stuck.offset();

		//if (! originaloffset) {
		//	originaloffset = stuckoffset.left;
		//}
		//if (jQuery('#wrapper').hasClass('navigation-open')) {
		//	$stuck.css('left', stuckoffset.left + 320 + 'px');
		//} else {
		//	$stuck.css('left', originaloffset + 'px');
		//}

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
	makeTabs('.widget_widgets_in_tabs');
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
	// when window resizes we could do with destroying them

	jQuery("article .share-tools").first().stickOnScroll({
		topOffset:          sidebartop,
		setParentOnStick:   true,
		setWidthOnStick:    true
	});

	jQuery(document).on("infinite-scrolled", function(ev) {
		var $sidebar = jQuery('#sidebar');
		var sidebarpos = $sidebar.position();
		jQuery(ev.newElements).find(".share-tools").first().stickOnScroll({
			topOffset:          sidebartop,
			setParentOnStick:   true,
			setWidthOnStick:    true
		});
	});

});

// window resized
jQuery(window).on("debouncedresize", function( event ) {

	// update sidebar position
	sidebarpos = $sidebar.position();
	sidebartop = sidebarpos.top;

});