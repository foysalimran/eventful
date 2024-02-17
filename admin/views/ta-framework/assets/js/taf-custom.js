;(function( $, window ) {
  'use strict';

/*  Keep the accordion field's first item opened */
$(window).load(function () {
  $('.efp-opened-accordion').each(function () {
    if (!$(this).hasClass('hidden')) {
      $(this).addClass('efp_saved_filter')
    }
  })
})
$('.efp-field-checkbox.efp_advanced_filter').change(function (event) {
  $('.efp-opened-accordion').each(function () {
    if ($(this).hasClass('hidden')) {
      $(this).removeClass('efp_saved_filter')
    } else {
      $(this).addClass('efp_saved_filter')
    }
    if (!$(this).hasClass('efp_saved_filter')) {
      if (
        $(this)
          .find('.efp-accordion-title')
          .siblings('.efp-accordion-content')
          .hasClass('efp-accordion-open')
      ) {
        $(this).find('.efp-accordion-title')
      } else {
        $(this)
          .find('.efp-accordion-title')
          .trigger('click')
        $(this)
          .find('.efp-accordion-content')
          .find('.efp-cloneable-add')
          .trigger('click')
      }
    }
  })
})

})( jQuery, window, document );