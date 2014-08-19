jQuery(document).ready(function() {

	// we have js
	jQuery('html').removeClass('no-js').addClass('js');

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

	// responsive tables
	var switched = false;
	var updateTables = function() {
		if ((jQuery(window).width() < 767) && !switched ){
			switched = true;
			jQuery("table.responsive").each(function(i, element) {
				splitTable(jQuery(element));
			});
			return true;
		} else if (switched && (jQuery(window).width() > 767)) {
			switched = false;
			jQuery("table.responsive").each(function(i, element) {
				unsplitTable(jQuery(element));
			});
		}
	};

	jQuery(window).load(updateTables);
	jQuery(window).bind("resize", updateTables);

	function splitTable(original) {
		original.wrap("<div class='table-wrapper' />");
		var copy = original.clone();
		copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
		copy.removeClass("responsive");
		original.closest(".table-wrapper").append(copy);
		copy.wrap("<div class='pinned' />");
		original.wrap("<div class='scrollable' />");
	}

	function unsplitTable(original) {
		original.closest(".table-wrapper").find(".pinned").remove();
		original.unwrap();
		original.unwrap();
	}
});