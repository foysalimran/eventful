; (function ($) {
	'use strict'
  
	/**
	 * JavaScript code for admin dashboard.
	 *
	 */
  
	$(function () {
	  /* Preloader */
	  $("#ta_efp_view_options .efp-metabox").css("visibility", "hidden");
  
	  var PCP_layout_type = $(
		'#efp-section-ta_efp_layouts_1 .efp-field-layout_preset .efp-siblings .efp--sibling'
	  )
	  var PCP_get_layout_value = $(
		'#efp-section-ta_efp_layouts_1 .efp-field-layout_preset .efp-siblings .efp--sibling.efp--active'
	  )
		.find('input')
		.val()
  
	  // Carousel Layout.
	  if (PCP_get_layout_value !== 'carousel_layout') {
		$(
		  '#ta_efp_view_options .efp-nav ul li.menu-item_ta_efp_view_options_3'
		).hide()
		$(
		  '#ta_efp_view_options .efp-nav ul li.menu-item_ta_efp_view_options_1 a'
		).trigger('click');
	  } else {
		$(
		  '#ta_efp_view_options .efp-nav ul li.menu-item_ta_efp_view_options_3'
		).show()
	  }
  
	  /**
	   * Show/Hide tabs on changing of layout.
	   */
	  $(PCP_layout_type).on('change', 'input', function (event) {
		var PCP_get_layout_value = $(this).val();
  
		// Carousel Layout.
		if (PCP_get_layout_value !== 'carousel_layout') {
		  $(
			'#ta_efp_view_options .efp-nav ul li.menu-item_ta_efp_view_options_3'
		  ).hide()
		  $(
			'#ta_efp_view_options .efp-nav ul li.menu-item_ta_efp_view_options_1 a'
		  ).trigger('click');
		} else {
		  $(
			'#ta_efp_view_options .efp-nav ul li.menu-item_ta_efp_view_options_3'
		  ).show()
		}
	  })
  
	  /* Preloader js */
	  $("#ta_efp_view_options .efp-metabox").css({ "backgroundImage": "none", "visibility": "visible", "minHeight": "auto" });
	  $("#ta_efp_view_options .efp-nav-metabox li").css("opacity", 1);
  
	  /* Copy to clipboard */
	  $('.efp-shortcode-selectable').on('click',function (e) {
		e.preventDefault();
		efp_copyToClipboard($(this));
		efp_SelectText($(this));
		$(this).trigger("focus").select();
		$('.efp-after-copy-text').animate({
		  opacity: 1,
		  bottom: 25
		}, 300);
		setTimeout(function () {
		  jQuery(".efp-after-copy-text").animate({
			opacity: 0,
		  }, 200);
		  jQuery(".efp-after-copy-text").animate({
			bottom: 0
		  }, 0);
		}, 2000);
	  });
	  $('.ta_efp_input').on('click',function (e) {
		e.preventDefault();
		/* Get the text field */
		var copyText = $(this);
		/* Select the text field */
		copyText.select();
		document.execCommand("copy");
		$('.efp-after-copy-text').animate({
		  opacity: 1,
		  bottom: 25
		}, 300);
		setTimeout(function () {
		  jQuery(".efp-after-copy-text").animate({
			opacity: 0,
		  }, 200);
		  jQuery(".efp-after-copy-text").animate({
			bottom: 0
		  }, 0);
		}, 2000);
	  });
	  function efp_copyToClipboard(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	  }
	  function efp_SelectText(element) {
		var r = document.createRange();
		var w = element.get(0);
		r.selectNodeContents(w);
		var sel = window.getSelection();
		sel.removeAllRanges();
		sel.addRange(r);
	  }
  
	})
  })(jQuery)
  