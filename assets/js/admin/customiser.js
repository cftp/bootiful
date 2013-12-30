jQuery(document).ready(function() {

	var original_variants = [];

	// on load set the correctly selected weight
	jQuery('.font-select').each(function() {
		var $select = jQuery(this);
		var variants = $select.find(':selected').data('weights');
		var variants_array = variants.split(',');
		var $variant_select = $select.closest('.customize-control-google-font-custom-control').next().find('.variant-select');
		
		original_variants[$select.attr('id')] = $variant_select.find('option').clone();

		$variant_select.html(original_variants[$select.attr('id')].filter(function() {
			return jQuery.inArray(jQuery(this).val(), variants_array) >= 0;
		}));
	});

	// when changing the font update the closest weight control
	jQuery('.font-select').on('change', function() {
		var $select = jQuery(this);
		var variants = $select.find(':selected').data('weights');
		var variants_array = variants.split(',');

		$select.closest('.customize-control-google-font-custom-control').next().find('.variant-select').html(original_variants[$select.attr('id')].filter(function() {
			return jQuery.inArray(jQuery(this).val(), variants_array) >= 0;
		}));
	});
});