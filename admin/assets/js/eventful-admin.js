; (function ($) {
	'use strict'
  
	/**
	 * JavaScript code for admin dashboard.
	 *
	 */
  
	$(function () {
	  /* Preloader */
	  $("#eful_view_options .eventful-metabox").css("visibility", "hidden");
  
	  var PCP_layout_type = $(
		'#eventful-section-eful_layouts_1 .eventful-field-layout_preset .eventful-siblings .eventful--sibling'
	  )
	  var PCP_get_layout_value = $(
		'#eventful-section-eful_layouts_1 .eventful-field-layout_preset .eventful-siblings .eventful--sibling.eventful--active'
	  )
		.find('input')
		.val()
  
	  // Carousel Layout.
	  if (PCP_get_layout_value !== 'carousel_layout') {
		$(
		  '#eful_view_options .eventful-nav ul li.menu-item_eful_view_options_3'
		).hide()
		$(
		  '#eful_view_options .eventful-nav ul li.menu-item_eful_view_options_1 a'
		).trigger('click');
	  } else {
		$(
		  '#eful_view_options .eventful-nav ul li.menu-item_eful_view_options_3'
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
			'#eful_view_options .eventful-nav ul li.menu-item_eful_view_options_3'
		  ).hide()
		  $(
			'#eful_view_options .eventful-nav ul li.menu-item_eful_view_options_1 a'
		  ).trigger('click');
		} else {
		  $(
			'#eful_view_options .eventful-nav ul li.menu-item_eful_view_options_3'
		  ).show()
		}
	  })
  
	  /* Preloader js */
	  $("#eful_view_options .eventful-metabox").css({ "backgroundImage": "none", "visibility": "visible", "minHeight": "auto" });
	  $("#eful_view_options .eventful-nav-metabox li").css("opacity", 1);
  
	  /* Copy to clipboard */
	  $('.eventful-shortcode-selectable').on('click',function (e) {
		e.preventDefault();
		eful_copyToClipboard($(this));
		eful_SelectText($(this));
		$(this).trigger("focus").select();
		$('.eventful-after-copy-text').animate({
		  opacity: 1,
		  bottom: 25
		}, 300);
		setTimeout(function () {
		  jQuery(".eventful-after-copy-text").animate({
			opacity: 0,
		  }, 200);
		  jQuery(".eventful-after-copy-text").animate({
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
		$('.eventful-after-copy-text').animate({
		  opacity: 1,
		  bottom: 25
		}, 300);
		setTimeout(function () {
		  jQuery(".eventful-after-copy-text").animate({
			opacity: 0,
		  }, 200);
		  jQuery(".eventful-after-copy-text").animate({
			bottom: 0
		  }, 0);
		}, 2000);
	  });
	  function eful_copyToClipboard(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	  }
	  function eful_SelectText(element) {
		var r = document.createRange();
		var w = element.get(0);
		r.selectNodeContents(w);
		var sel = window.getSelection();
		sel.removeAllRanges();
		sel.addRange(r);
	  }
  
	})
  })(jQuery)
  