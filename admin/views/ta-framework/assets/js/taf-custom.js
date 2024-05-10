;(function( $, window ) {
  'use strict';

/*  Keep the accordion field's first item opened */
$(window).load(function () {
  $('.eventful-opened-accordion').each(function () {
    if (!$(this).hasClass('hidden')) {
      $(this).addClass('eful_saved_filter')
    }
  })
})
$('.eventful-field-checkbox.eful_advanced_filter').change(function (event) {
  $('.eventful-opened-accordion').each(function () {
    if ($(this).hasClass('hidden')) {
      $(this).removeClass('eful_saved_filter')
    } else {
      $(this).addClass('eful_saved_filter')
    }
    if (!$(this).hasClass('eful_saved_filter')) {
      if (
        $(this)
          .find('.eventful-accordion-title')
          .siblings('.eventful-accordion-content')
          .hasClass('eventful-accordion-open')
      ) {
        $(this).find('.eventful-accordion-title')
      } else {
        $(this)
          .find('.eventful-accordion-title')
          .trigger('click')
        $(this)
          .find('.eventful-accordion-content')
          .find('.eventful-cloneable-add')
          .trigger('click')
      }
    }
  })
})

})( jQuery, window, document );