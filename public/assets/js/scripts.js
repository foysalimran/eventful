jQuery(document).ready(function ($) {
  "use strict";
  var eful_myScript = function () {
    if ($(".ta-container").length > 0) {
      $(".ta-container").each(function () {
        var eful_container = $(this),
          eful_container_id = eful_container.attr("id"),
          eful_Wrapper_ID = "#" + eful_container_id,
          pc_sid = $(eful_Wrapper_ID).data("sid"), // The Shortcode ID.
          eventfulCarousel = $("#" + eful_container_id + " .ta-eventful-carousel"),
          eventfulAccordion = $("#" + eful_container_id + " .ta-collapse"),
          eventfulfilter = $("#" + eful_container_id + ".eventful-filter-wrapper"),
          ajaxurl = speventful.ajaxurl,
          nonce = speventful.nonce,
          eventfulCarouselDir = eventfulCarousel.attr("dir"),
          eventfulSwiper,
          eventfulCarouselData = eventfulCarousel.data("carousel");
       
        if (eventfulCarousel.length > 0) {
          var mobile_land = parseInt(
              eventfulCarouselData.responsive.mobile_landscape
            ),
            tablet_size = parseInt(eventfulCarouselData.responsive.tablet),
            desktop_size = parseInt(eventfulCarouselData.responsive.desktop),
            lg_desktop_size = parseInt(eventfulCarouselData.responsive.lg_desktop);
        }

        // Carousel Init function.
        function eful_carousel_init() {
          // Carousel ticker mode.
          if (eventfulCarouselData.mode == "ticker") {
            var item = eventfulCarousel.find(".swiper-wrapper .swiper-slide").length;
            eventfulSwiper = eventfulCarousel.find(".swiper-wrapper").bxSlider({
              mode: "horizontal",
              moveSlides: 1,
              slideMargin: eventfulCarouselData.spaceBetween,
              infiniteLoop: eventfulCarouselData.loop,
              slideWidth: eventfulCarouselData.ticker_width,
              minSlides: eventfulCarouselData.slidesPerView.mobile,
              maxSlides: eventfulCarouselData.slidesPerView.lg_desktop,
              speed: eventfulCarouselData.ticker_speed * item,
              ticker: true,
              tickerHover: eventfulCarouselData.stop_onHover,
              autoDirection: eventfulCarouselDir,
            });
          }

          // Carousel Swiper for Standard & Center mode.
          if (
            eventfulCarouselData.mode == "standard" ||
            eventfulCarouselData.mode == "center"
          ) {
            if (
              eventfulCarouselData.effect == "fade" ||
              eventfulCarouselData.effect == "cube" ||
              eventfulCarouselData.effect == "flip"
            ) {
              if ($(window).width() > lg_desktop_size) {
                slidePerView = eventfulCarouselData.slidesPerView.lg_desktop;
              } else if ($(window).width() > desktop_size) {
                slidePerView = eventfulCarouselData.slidesPerView.desktop;
              } else if ($(window).width() > tablet_size) {
                slidePerView = eventfulCarouselData.slidesPerView.tablet;
              } else if ($(window).width() > 0) {
                slidePerView = eventfulCarouselData.slidesPerView.mobile_landscape;
              }
              $(
                eful_Wrapper_ID +
                  " .ta-eventful-carousel .swiper-wrapper > .ta-eventful-item"
              )
                .css("width", 100 / slidePerView + "%")
                .removeClass("swiper-slide");
              var fade_items = $(
                eful_Wrapper_ID +
                  " .ta-eventful-carousel .swiper-wrapper > .ta-eventful-item"
              );
              var style =
                eventfulCarouselDir == "rtl" ? "marginLeft" : "marginRight";
              for (var i = 0; i < fade_items.length; i += slidePerView) {
                fade_items
                  .slice(i, i + slidePerView)
                  .wrapAll('<div class="swiper-slide"></div>');
                fade_items.eq(i - 1).css(style, 0);
              }
              eventfulSwiper = new Swiper(
                "#" + eful_container_id + " .ta-eventful-carousel",
                {
                  speed: eventfulCarouselData.speed,
                  slidesPerView: 1,
                  spaceBetween: eventfulCarouselData.spaceBetween,
                  loop:
                    eventfulCarouselData.slidesRow.lg_desktop > "1" ||
                    eventfulCarouselData.slidesRow.desktop > "1" ||
                    eventfulCarouselData.slidesRow.tablet > "1" ||
                    eventfulCarouselData.slidesRow.mobile_landscape > "1" ||
                    eventfulCarouselData.slidesRow.mobile > "1"
                      ? false
                      : eventfulCarouselData.loop,
                  effect: eventfulCarouselData.effect,
                  slidesPerGroup: eventfulCarouselData.slideToScroll.mobile,
                  preloadImages: false,
                  observer: true,
                  runCallbacksOnInit: false,
                  initialSlide: 0,
                  slidesPerColumn: eventfulCarouselData.slidesRow.mobile,
                  slidesPerColumnFill: "row",
                  autoHeight:
                    eventfulCarouselData.slidesRow.lg_desktop > "1" ||
                    eventfulCarouselData.slidesRow.desktop > "1" ||
                    eventfulCarouselData.slidesRow.tablet > "1" ||
                    eventfulCarouselData.slidesRow.mobile_landscape > "1" ||
                    eventfulCarouselData.slidesRow.mobile > "1"
                      ? false
                      : eventfulCarouselData.autoHeight,
                  simulateTouch: eventfulCarouselData.simulateTouch,
                  allowTouchMove: eventfulCarouselData.allowTouchMove,
                  mousewheel: eventfulCarouselData.slider_mouse_wheel,
                  centeredSlides: eventfulCarouselData.center_mode,
                  lazy: eventfulCarouselData.lazy,
                  pagination:
                    eventfulCarouselData.pagination == true
                      ? {
                          el: ".swiper-pagination",
                          clickable: true,
                          dynamicBullets: eventfulCarouselData.dynamicBullets,
                          renderBullet: function (index, className) {
                            if (eventfulCarouselData.bullet_types == "number") {
                              return (
                                '<span class="' +
                                className +
                                '">' +
                                (index + 1) +
                                "</span>"
                              );
                            } else {
                              return '<span class="' + className + '"></span>';
                            }
                          },
                        }
                      : false,
                  autoplay: {
                    delay: eventfulCarouselData.autoplay_speed,
                  },
                  navigation:
                    eventfulCarouselData.navigation == true
                      ? {
                          nextEl: ".eventful-button-next",
                          prevEl: ".eventful-button-prev",
                        }
                      : false,
                  fadeEffect: {
                    crossFade: true,
                  },
                  ally: {
                    enabled: eventfulCarouselData.enabled,
                    prevSlideMessage: eventfulCarouselData.prevSlideMessage,
                    nextSlideMessage: eventfulCarouselData.nextSlideMessage,
                    firstSlideMessage: eventfulCarouselData.firstSlideMessage,
                    lastSlideMessage: eventfulCarouselData.lastSlideMessage,
                    paginationBulletMessage:
                      eventfulCarouselData.paginationBulletMessage,
                  },
                  keyboard: {
                    enabled: eventfulCarouselData.keyboard === "true" ? true : false,
                  },
                }
              );
            } else {
              eventfulSwiper = new Swiper(
                "#" + eful_container_id + " .ta-eventful-carousel",
                {
                  speed: eventfulCarouselData.speed,
                  slidesPerView: eventfulCarouselData.slidesPerView.mobile,
                  spaceBetween: eventfulCarouselData.spaceBetween,
                  loop:
                    eventfulCarouselData.slidesRow.lg_desktop > "1" ||
                    eventfulCarouselData.slidesRow.desktop > "1" ||
                    eventfulCarouselData.slidesRow.tablet > "1" ||
                    eventfulCarouselData.slidesRow.mobile_landscape > "1" ||
                    eventfulCarouselData.slidesRow.mobile > "1"
                      ? false
                      : eventfulCarouselData.loop,
                  effect: eventfulCarouselData.effect,
                  slidesPerGroup: eventfulCarouselData.slideToScroll.mobile,
                  preloadImages: false,
                  observer: true,
                  runCallbacksOnInit: false,
                  initialSlide: 0,
                  slidesPerColumn: eventfulCarouselData.slidesRow.mobile,
                  slidesPerColumnFill: "row",
                  autoHeight:
                    eventfulCarouselData.slidesRow.lg_desktop > "1" ||
                    eventfulCarouselData.slidesRow.desktop > "1" ||
                    eventfulCarouselData.slidesRow.tablet > "1" ||
                    eventfulCarouselData.slidesRow.mobile_landscape > "1" ||
                    eventfulCarouselData.slidesRow.mobile > "1"
                      ? false
                      : eventfulCarouselData.autoHeight,
                  simulateTouch: eventfulCarouselData.simulateTouch,
                  allowTouchMove: eventfulCarouselData.allowTouchMove,
                  mousewheel: eventfulCarouselData.slider_mouse_wheel,
                  centeredSlides: eventfulCarouselData.center_mode,
                  lazy: eventfulCarouselData.lazy,
                  pagination:
                    eventfulCarouselData.pagination == true
                      ? {
                          el: ".swiper-pagination",
                          clickable: true,
                          dynamicBullets: eventfulCarouselData.dynamicBullets,
                          renderBullet: function (index, className) {
                            if (eventfulCarouselData.bullet_types == "number") {
                              return (
                                '<span class="' +
                                className +
                                '">' +
                                (index + 1) +
                                "</span>"
                              );
                            } else {
                              return '<span class="' + className + '"></span>';
                            }
                          },
                        }
                      : false,
                  autoplay: {
                    delay: eventfulCarouselData.autoplay_speed,
                  },
                  navigation:
                    eventfulCarouselData.navigation == true
                      ? {
                          nextEl: ".eventful-button-next",
                          prevEl: ".eventful-button-prev",
                        }
                      : false,
                  breakpoints: {
                    [mobile_land]: {
                      slidesPerView:
                        eventfulCarouselData.slidesPerView.mobile_landscape,
                      slidesPerGroup:
                        eventfulCarouselData.slideToScroll.mobile_landscape,
                      slidesPerColumn:
                        eventfulCarouselData.slidesRow.mobile_landscape,
                      navigation:
                        eventfulCarouselData.navigation_mobile == true
                          ? {
                              nextEl: ".eventful-button-next",
                              prevEl: ".eventful-button-prev",
                            }
                          : false,
                      pagination:
                        eventfulCarouselData.pagination_mobile == true
                          ? {
                              el: ".swiper-pagination",
                              clickable: true,
                              dynamicBullets: eventfulCarouselData.dynamicBullets,
                              renderBullet: function (index, className) {
                                if (eventfulCarouselData.bullet_types == "number") {
                                  return (
                                    '<span class="' +
                                    className +
                                    '">' +
                                    (index + 1) +
                                    "</span>"
                                  );
                                } else {
                                  return (
                                    '<span class="' + className + '"></span>'
                                  );
                                }
                              },
                            }
                          : false,
                    },
                    [tablet_size]: {
                      slidesPerView: eventfulCarouselData.slidesPerView.tablet,
                      slidesPerGroup: eventfulCarouselData.slideToScroll.tablet,
                      slidesPerColumn: eventfulCarouselData.slidesRow.tablet,
                    },
                    [desktop_size]: {
                      slidesPerView: eventfulCarouselData.slidesPerView.desktop,
                      slidesPerGroup: eventfulCarouselData.slideToScroll.desktop,
                      slidesPerColumn: eventfulCarouselData.slidesRow.desktop,
                    },
                    [lg_desktop_size]: {
                      slidesPerView: eventfulCarouselData.slidesPerView.lg_desktop,
                      slidesPerGroup: eventfulCarouselData.slideToScroll.lg_desktop,
                      slidesPerColumn: eventfulCarouselData.slidesRow.lg_desktop,
                    },
                  },
                  fadeEffect: {
                    crossFade: true,
                  },
                  ally: {
                    enabled: eventfulCarouselData.enabled,
                    prevSlideMessage: eventfulCarouselData.prevSlideMessage,
                    nextSlideMessage: eventfulCarouselData.nextSlideMessage,
                    firstSlideMessage: eventfulCarouselData.firstSlideMessage,
                    lastSlideMessage: eventfulCarouselData.lastSlideMessage,
                    paginationBulletMessage:
                      eventfulCarouselData.paginationBulletMessage,
                  },
                  keyboard: {
                    enabled: eventfulCarouselData.keyboard === "true" ? true : false,
                  },
                }
              );
            }
            if (eventfulCarouselData.autoplay === false) {
              eventfulSwiper.autoplay.stop();
            }
            if (eventfulCarouselData.stop_onHover && eventfulCarouselData.autoplay) {
              $(eventfulCarousel).on({
                mouseenter: function () {
                  eventfulSwiper.autoplay.stop();
                },
                mouseleave: function () {
                  eventfulSwiper.autoplay.start();
                },
              });
            }
            $(window).on("resize", function () {
              eventfulSwiper.update();
            });
            $(window).trigger("resize");
          }
        }
        if (eventfulCarousel.length > 0) {
          eful_carousel_init();
        }
        $(
          ".ta-overlay.ta-eventful-post,.ta-content-box.ta-eventful-post",
          eful_Wrapper_ID
        ).on("mouseover", function () {
          $(this)
            .find(".eful__item__content.animated:not(.eful_hover)")
            .addClass("eful_hover");
        });

        
        /**
         *  Isotope Filter layout.
         */
        if (eventfulfilter.length > 0) {
          if (eventfulfilter.data("grid") == "masonry") {
            var layoutMode = "masonry";
          } else {
            var layoutMode = "fitRows";
          }
          var $grid = $(".grid", eful_Wrapper_ID).isotope({
            itemSelector: ".item",
            //layoutMode: 'fitRows'
            layoutMode: layoutMode,
          });
          $grid.imagesLoaded().progress(function () {
            $grid.isotope("layout");
          });

          // This function added for eventful-Lazyload.
          function eful_lazyload() {
            $is_find = $(".ta-eventful-post-thumb-area img").hasClass(
              "eventful-lazyload"
            );
            if ($is_find) {
              $("img.eventful-lazyload")
                .eful_lazyload({ effect: "fadeIn", effectTime: 2000 })
                .removeClass("eventful-lazyload")
                .addClass("eventful-lazyloaded");
            }
            $grid.isotope("layout");
          }

          // Store filter for each group.
          var filters = {};
          $(".eventful-shuffle-filter .taxonomy-group", eful_Wrapper_ID).on(
            "change",
            function (event) {
              var $select = $(event.target);
              // get group key
              var filterGroup = $select.attr("data-filter-group");
              // set filter for group
              filters[filterGroup] = event.target.value;
              // combine filters
              var filterValue = concatValues(filters);
              // set filter for Isotope
              $grid.isotope({ filter: filterValue });
              $grid.on("layoutComplete", function () {
                $(window).trigger("scroll");
              });
            }
          );

          $(".eventful-shuffle-filter", eful_Wrapper_ID).on(
            "click",
            ".eventful-button",
            function (event) {
              var $button = $(event.currentTarget);
              // get group key
              var $taxonomyGroup = $button.parents(".taxonomy-group");
              var filterGroup = $taxonomyGroup.attr("data-filter-group");
              // taxonomy = $taxonomyGroup.attr('data-filter-group');
              // set filter for group
              filters[filterGroup] = $button.attr("data-filter");
              //  term_id = $button.attr('data-termid');
              // combine filters
              var filterValue = concatValues(filters);
              // set filter for Isotope
              $grid.isotope({ filter: filterValue });
              $grid.on("layoutComplete", function () {
                $(window).trigger("scroll");
              });
            }
          );
          // Change is-active class on buttons.
          $(".taxonomy-group", eful_Wrapper_ID).each(function (
            i,
            taxonomyGroup
          ) {
            var $taxonomyGroup = $(taxonomyGroup);
            var $find_active_button = $taxonomyGroup.find(".is-active");
            if ($find_active_button.length == 0) {
              $taxonomyGroup
                .find("button:nth-child(1)")
                .addClass("is-active")
                .click();
            }
            $taxonomyGroup.on("click", "button", function (event) {
              $taxonomyGroup.find(".is-active").removeClass("is-active");
              var $button = $(event.currentTarget);
              $button.addClass("is-active");
            });
          });
          // Flatten object by concatenation values.
          function concatValues(obj) {
            var value = "";
            for (var prop in obj) {
              value += obj[prop];
            }
            return value;
          }
        }

        function eful_item_same_height() {
          var maxHeight = 0;
          $(eful_Wrapper_ID + ".eful_same_height .item").each(function () {
            if ($(this).find(".ta-eventful-post").height() > maxHeight) {
              maxHeight = $(this).find(".ta-eventful-post").height();
            }
          });
          $(eful_Wrapper_ID + ".eful_same_height .ta-eventful-post").height(maxHeight);
        }
        if (
          $(eful_Wrapper_ID + ".eful_same_height").hasClass("eventful-filter-wrapper")
        ) {
          eful_item_same_height();
        }

        // Ajax Action for Live filter.
        var keyword = "",
          orderby = "",
          taxonomy = "",
          order = "",
          term_id = "",
          page = "",
          spsp_lang = $(eful_Wrapper_ID).data("lang");
          var author_id = "",
          eful_hash_url = Array(),
          eful_last_filter = "",
          is_pagination_url_change = true;
        function eful_ajax_action(selected_term_list = null) {
          jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
              action: "eful_post_order",
              id: pc_sid,
              lang: spsp_lang,
              order: order,
              keyword: keyword,
              orderby: orderby,
              taxonomy: taxonomy,
              term_id: term_id,
              author_id: author_id,
              nonce: nonce,
              term_list: selected_term_list,
            },
            success: function (data) {
              var $data = $(data);
              var $newElements = $data;

              if ($(eful_Wrapper_ID).hasClass("eventful-masonry")) {
                var $post_wrapper = $(".ta-row", eful_Wrapper_ID);
                $post_wrapper.masonry("destroy");
                $post_wrapper.html($newElements).imagesLoaded(function () {
                  $post_wrapper.masonry();
                });
              } else if ($(eful_Wrapper_ID).hasClass("eventful-filter-wrapper")) {
                $(
                  ".ta-row, .eventful-timeline-grid, .ta-collapse, .table-responsive tbody",
                  eful_Wrapper_ID
                ).html($newElements);
                $grid
                  .append($newElements)
                  .isotope("appended", $newElements)
                  .imagesLoaded(function () {
                    $grid.isotope("layout");
                  });
                eful_item_same_height();
              } else if (eventfulCarousel.length > 0) {
                if (eventfulCarouselData.mode == "ticker") {
                  eventfulSwiper.destroySlider();
                  $(".swiper-wrapper", eful_Wrapper_ID).html($newElements);
                  eful_carousel_init();
                  eventfulSwiper.reloadSlider();
                } else {
                  eventfulSwiper.destroy(true, true);
                  $(".swiper-wrapper", eful_Wrapper_ID).html($newElements);
                  eful_carousel_init();
                }
              } else {
                var $newElements = $data.css({
                  opacity: 0,
                });
                $(
                  ".ta-row, .eventful-timeline-grid, .ta-collapse, .table-responsive tbody",
                  eful_Wrapper_ID
                ).html($newElements);
                if (eventfulAccordion.length > 0) {
                  eventfulAccordion.accordion("refresh");
                  if (accordion_mode === "multi-open") {
                    eventfulAccordion
                      .find(".eventful-collapse-header")
                      .next()
                      .slideDown();
                    eventfulAccordion
                      .find(".eventful-collapse-header .fa")
                      .removeClass("fa-plus")
                      .addClass("fa-minus");
                  }
                }
                var $newElements = $data.css({
                  opacity: 1,
                });
              }
              eful_lazyload();
            },
          });
        }

        // Pagination.
        function eful_pagination_action(selected_term_list = null) {
          var LoadMoreText = $(".ta-eventful-pagination-data", eful_Wrapper_ID).data(
            "loadmoretext"
          );
          var EndingMessage = $(".ta-eventful-pagination-data", eful_Wrapper_ID).data(
            "endingtext"
          );
          jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
              action: "post_pagination_bar_mobile",
              id: pc_sid,
              order: order,
              lang: spsp_lang,
              keyword: keyword,
              orderby: orderby,
              taxonomy: taxonomy,
              author_id: author_id,
              term_id: term_id,
              page: page,
              nonce: nonce,
              term_list: selected_term_list,
            },
            success: function (data) {
              var $data = $(data);
              var $newElements = $data;
              $(
                ".eventful-post-pagination.eventful-on-mobile:not(.no_ajax)",
                eful_Wrapper_ID
              ).html($newElements);
              if (
                Pagination_Type == "infinite_scroll" ||
                Pagination_Type == "ajax_load_more"
              ) {
                $(".eventful-load-more", eful_Wrapper_ID)
                  .removeClass("finished")
                  .removeClass("eventful-hide")
                  .html(
                    '<button eventfulcessing="0">' + LoadMoreText + "</button>"
                  );
                if (!$(".eventful-post-pagination a", eful_Wrapper_ID).length) {
                  $(".eventful-load-more", eful_Wrapper_ID)
                    .show()
                    .html(EndingMessage);
                }
              }
              if (Pagination_Type == "infinite_scroll") {
                $(".eventful-load-more", eful_Wrapper_ID).addClass("eventful-hide");
              }
            },
          });
          jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
              action: "post_pagination_bar",
              id: pc_sid,
              order: order,
              lang: spsp_lang,
              keyword: keyword,
              orderby: orderby,
              taxonomy: taxonomy,
              author_id: author_id,
              term_id: term_id,
              page: page,
              nonce: nonce,
              term_list: selected_term_list,
            },
            success: function (data) {
              var $data = $(data);
              var $newElements = $data;
              $(
                ".eventful-post-pagination.eventful-on-desktop:not(.no_ajax)",
                eful_Wrapper_ID
              ).html($newElements);
              if (
                Pagination_Type == "infinite_scroll" ||
                Pagination_Type == "ajax_load_more"
              ) {
                $(".eventful-load-more", eful_Wrapper_ID)
                  .removeClass("finished")
                  .removeClass("eventful-hide")
                  .html(
                    '<button eventfulcessing="0">' + LoadMoreText + "</button>"
                  );
              }
              if (Pagination_Type == "infinite_scroll") {
                $(".eventful-load-more", eful_Wrapper_ID).addClass("eventful-hide");
              }
              if (!$(".eventful-post-pagination a", eful_Wrapper_ID).length) {
                $(".eventful-load-more", eful_Wrapper_ID).show().html(EndingMessage);
              }
              eful_lazyload();
            },
          });
        }
        // Live filter button reset on ajax call.
        function eful_live_filter_reset(selected_term_list = null) {
          jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
              action: "eful_live_filter_reset",
              id: pc_sid,
              order: order,
              lang: spsp_lang,
              keyword: keyword,
              orderby: orderby,
              taxonomy: taxonomy,
              term_id: term_id,
              author_id: author_id,
              nonce: nonce,
              term_list: selected_term_list,
              last_filter: eful_last_filter,
            },
            success: function (data) {
              var $data = $(data);
              var $newElements = $data.animate({
                opacity: 0.5,
              });
              $(".eventful-filter-bar", eful_Wrapper_ID).html($newElements);
              $newElements.animate({
                opacity: 1,
              });
            },
          });
        }
        // Update Hash url array.
        function eful_hash_update_arr(eful_filter_keyword, filter_arr, key) {
          if (eful_hash_url.length > 0) {
            eful_hash_url.forEach(function (row) {
              if ($.inArray(eful_filter_keyword, row.eful_filter_keyword)) {
                row[key] = eful_filter_keyword;
              } else {
                eful_hash_url.push(filter_arr);
              }
            });
          } else {
            eful_hash_url.push(filter_arr);
          }
          return eful_hash_url;
        }
        // On normal pagination go to current shortcode.
        var url_hash = window.location.search;
        if (url_hash.indexOf("paged") >= 0) {
          var s_id = /paged(\d+)/.exec(url_hash)[1];
          var spscurrent_id = document.getElementById("eful_wrapper-" + s_id);
          spscurrent_id.scrollIntoView();
        }
        // Update url.
        var selected_term_list = Array();
        function eful_update_url() {
          var p_search = window.location.search;
          if (p_search.indexOf("page_id") >= 0) {
            var eful_page = /page_id\=(\d+)/.exec(p_search)[1];
            var eful_url = "?page_id=" + eful_page + "&";
          } else {
            var eful_url = "&";
          }
          if (eful_hash_url.length > 0) {
            $.map(eful_hash_url, function (value, index) {
              $.map(value, function (value2, index2) {
                if (
                  value2 == "all" ||
                  value2 == "none" ||
                  value2 == "" ||
                  value2 == "page"
                ) {
                  eful_url += "";
                } else {
                  eful_url += "eful_" + index2 + "=" + value2 + "&";
                }
              });
            });
          }
          if (selected_term_list.length > 0) {
            var term_total_length = selected_term_list.length;
            $.map(selected_term_list, function (value, index) {
              if (value.term_id == "all" || value.term_id == "") {
                eful_url += "";
              } else {
                if (index == term_total_length - 1) {
                  eful_url += "tx_" + value.taxonomy + "=" + value.term_id + "";
                } else {
                  eful_url += "tx_" + value.taxonomy + "=" + value.term_id + "&";
                }
              }
            });
          }
          
          if (eful_hash_url.length < 0 || selected_term_list.length < 0) {
            eful_url = "";
          }
          if (eful_url.length > 1) {
            var slf = "";
            if (eful_last_filter.length > 0) {
              var slf = "&slf=" + eful_last_filter;
            }

            eful_url = "?eventful=" + pc_sid + slf + eful_url;
            history.pushState(null, null, encodeURI(eful_url));
          } else {
            var uri = window.location.toString();
            if (uri.indexOf("?") > 0) {
              var clean_uri = uri.substring(0, uri.indexOf("?"));
              window.history.replaceState({}, document.title, clean_uri);
            }
          }
        }

        // Ajax post search.
        $("input.eventful-search-field", eful_Wrapper_ID).on("keyup", function () {
          var that = $(this);
          keyword = that.val();
          eful_last_filter = "keyword";
          var eful_search_arr = { keyword, keyword };
          eful_live_filter_reset(selected_term_list);
          eful_hash_update_arr(keyword, eful_search_arr, "keyword");
          eful_update_url();
          eful_ajax_action(selected_term_list);
          eful_pagination_action();
          is_pagination_url_change = false;
          eful_hash_update_arr("page", { page: "" }, "page");
          eful_update_url();
        });

        // Post order by.
        $(".eventful-order-by", eful_Wrapper_ID).on("change", function () {
          var that;
          $(this)
            .find("option:selected, input:radio:checked")
            .each(function () {
              that = $(this);
              orderby = that.val();
            });
          var orerbyarr = { orderby, orderby };
          eful_hash_update_arr(orderby, orerbyarr, "orderby");
          eful_update_url();
          eful_ajax_action();
          eful_pagination_action();
          eful_hash_update_arr("page", { page: "" }, "page");
          eful_update_url();
        });

        function eful_filter_push(myarr, item) {
          var found = false;
          var i = 0;
          while (i < myarr.length) {
            if (myarr[i] === item) {
              // Do the logic (delete or replace)
              found = true;
              break;
            }
            i++;
          }
          // Add the item
          if (!found) myarr.push(item);
          return myarr;
        }

        // Pre Filter Init.
        var tax_list = Array();
        $(".eventful-filter-by", eful_Wrapper_ID)
          .find("option:selected, input:radio:checked")
          .each(function () {
            term_id = $(this).val();
            taxonomy = $(this).data("taxonomy");
            var selected_tax_length = selected_term_list.length;
            if (selected_tax_length > 0) {
              var selected_tax =
                selected_term_list[selected_tax_length - 1]["taxonomy"];
              selected_term_list.map(function (person) {
                if (person.taxonomy === taxonomy) {
                  person.term_id = term_id;
                }
              });
              // if ($.inArray(taxonomy, tax_list) == -1) {
              selected_term_list.push({
                taxonomy,
                term_id,
              });
              //  }
              if (
                selected_term_list[selected_tax_length - 1]["term_id"] ==
                  "all" &&
                selected_tax === taxonomy
              ) {
                tax_list = tax_list.filter(function (val) {
                  return val !== taxonomy;
                });
              } else {
                tax_list = eful_filter_push(tax_list, taxonomy);
              }
              selected_term_list = $.grep(selected_term_list, function (e, i) {
                return e.term_id != "all";
              });
            } else {
              selected_term_list.push({
                taxonomy,
                term_id,
              });
              selected_term_list = $.grep(selected_term_list, function (e, i) {
                return e.term_id != "all";
              });
              tax_list = Array(taxonomy);
            }
          });
        $(".eventful-author-filter", eful_Wrapper_ID)
          .find("option:selected, input:radio:checked")
          .each(function () {
            var that;
            that = $(this);
            author_id = that.val();
          });
        $(".eventful-order", eful_Wrapper_ID)
          .find("option:selected, input:radio:checked")
          .each(function () {
            var that;
            that = $(this);
            order = $(this).val();
          });
        $(".eventful-order-by", eful_Wrapper_ID)
          .find("option:selected, input:radio:checked")
          .each(function () {
            var that;
            that = $(this);
            orderby = that.val();
          });
        $("input.eventful-search-field", eful_Wrapper_ID).each(function () {
          var that = $(this);
          keyword = that.val();
        });
        $(".eventful-filter-by-checkbox", eful_Wrapper_ID).each(function () {
          var current_tax = $(this).data("taxonomy");
          var term_ids = "";
          $(this)
            .find("input[name='" + current_tax + "']:checkbox:checked")
            .each(function () {
              term_ids += $(this).val() + ",";
              taxonomy = $(this).data("taxonomy");
            });
          term_id = term_ids.replace(/,(?=\s*$)/, "");
          selected_term_list.map(function (person) {
            if (person.taxonomy === current_tax) {
              person.term_id = term_id;
            }
          });
          selected_term_list.push({
            taxonomy,
            term_id,
          });
        });
        selected_term_list = $.grep(selected_term_list, function (e, i) {
          return e.term_id.length;
        });
        selected_term_list = selected_term_list
          .map(JSON.stringify)
          .reverse() // convert to JSON string the array content, then reverse it (to check from end to beginning)
          .filter(function (item, index, arr) {
            return arr.indexOf(item, index + 1) === -1;
          }) // check if there is any occurence of the item in whole array
          .reverse()
          .map(JSON.parse);
        // Filter by checkbox.
        $(eful_Wrapper_ID).on("change", ".eventful-filter-by-checkbox", function (e) {
          e.stopPropagation();
          e.preventDefault();
          $(".eventful-filter-by-checkbox", eful_Wrapper_ID).each(function () {
            var current_tax = $(this).data("taxonomy");
            var term_ids = "";
            $(this)
              .find("input[name='" + current_tax + "']:checkbox:checked")
              .each(function () {
                term_ids += $(this).val() + ",";
                taxonomy = $(this).data("taxonomy");
              });
            term_id = term_ids.replace(/,(?=\s*$)/, "");
            selected_term_list.map(function (person) {
              if (person.taxonomy === current_tax) {
                person.term_id = term_id;
              }
            });
            selected_term_list.push({
              taxonomy,
              term_id,
            });
          });
          selected_term_list = $.grep(selected_term_list, function (e, i) {
            return e.term_id.length;
          });
          selected_term_list = selected_term_list
            .map(JSON.stringify)
            .reverse() // convert to JSON string the array content, then reverse it (to check from end to beginning)
            .filter(function (item, index, arr) {
              return arr.indexOf(item, index + 1) === -1;
            }) // check if there is any occurence of the item in whole array
            .reverse()
            .map(JSON.parse);
          var term_ids = "";
          $(this)
            .find("input:checkbox:checked")
            .each(function () {
              term_ids += $(this).val() + ",";
              taxonomy = $(this).data("taxonomy");
            });
          taxonomy = $(this).data("taxonomy");
          term_id = term_ids.replace(/,(?=\s*$)/, "");
          if (term_id.length > 0) {
            eful_last_filter = taxonomy;
          } else {
            eful_last_filter = eful_last_filter;
          }
          eful_hash_update_arr("page", { page: "" }, "page");
          eful_update_url();
          eful_live_filter_reset(selected_term_list);
          eful_ajax_action(selected_term_list);
          eful_pagination_action(selected_term_list);
        });

        // Filter by taxonomy.
        $(eful_Wrapper_ID).on("change", ".eventful-filter-by", function (e) {
          e.stopPropagation();
          e.preventDefault();
          $(this)
            .find("option:selected, input:radio:checked")
            .each(function () {
              term_id = $(this).val();
              taxonomy = $(this).data("taxonomy");
              var selected_tax_length = selected_term_list.length;
              if (selected_tax_length > 0) {
                var selected_tax =
                  selected_term_list[selected_tax_length - 1]["taxonomy"];
                selected_term_list.map(function (person) {
                  if (person.taxonomy === taxonomy) {
                    person.term_id = term_id;
                  }
                });
                // if ($.inArray(taxonomy, tax_list) == -1) {
                selected_term_list.push({
                  taxonomy,
                  term_id,
                });
                //  }
                if (
                  selected_term_list[selected_tax_length - 1]["term_id"] ==
                    "all" &&
                  selected_tax === taxonomy
                ) {
                  tax_list = tax_list.filter(function (val) {
                    return val !== taxonomy;
                  });
                } else {
                  tax_list = eful_filter_push(tax_list, taxonomy);
                }
                selected_term_list = $.grep(
                  selected_term_list,
                  function (e, i) {
                    return e.term_id != "all";
                  }
                );
              } else {
                selected_term_list.push({
                  taxonomy,
                  term_id,
                });
                tax_list = Array(taxonomy);
              }
            });
          if (term_id == "all") {
            eful_last_filter = eful_last_filter;
          } else {
            eful_last_filter = taxonomy;
          }
          selected_term_list = selected_term_list
            .map(JSON.stringify)
            .reverse()
            .filter(function (item, index, selected_term_list) {
              return selected_term_list.indexOf(item, index + 1) === -1;
            })
            .reverse()
            .map(JSON.parse);
          eful_hash_update_arr("page", { page: "" }, "page");
          eful_update_url();
          // if ($('.eventful-filter-by', eful_Wrapper_ID).length > 1) {
          eful_live_filter_reset(selected_term_list);
          //}
          eful_ajax_action(selected_term_list);
          eful_pagination_action(selected_term_list);
        });
        // Author filter.
        $(eful_Wrapper_ID).on("change", ".eventful-author-filter", function (e) {
          var that;
          $(this)
            .find("option:selected, input:radio:checked")
            .each(function () {
              var that;
              that = $(this);
              author_id = that.val();
            });
          var author_arr = { author_id, author_id };
          if (author_id == "all") {
            eful_last_filter = eful_last_filter;
          } else {
            eful_last_filter = "author_id";
          }
          eful_hash_update_arr(author_id, author_arr, "author_id");
          eful_update_url();
          eful_live_filter_reset(selected_term_list);
          eful_ajax_action();
          eful_pagination_action();
        });

        // Post order asc/dsc.
        $(eful_Wrapper_ID).on("change", ".eventful-order", function (e) {
          var that;
          $(this)
            .find("option:selected, input:radio:checked")
            .each(function () {
              var that;
              that = $(this);
              order = $(this).val();
            });
          var order_arr = { order, order };
          eful_hash_update_arr(order, order_arr, "order");
          eful_update_url();
          eful_ajax_action();
          eful_pagination_action();
          eful_hash_update_arr("page", { page: "" }, "page");
          eful_update_url();
        });
        /**
         * Grid masonry.
         */
        if ($(eful_Wrapper_ID).hasClass("eventful-masonry")) {
          var $post_wrapper = $(".ta-row", eful_Wrapper_ID);
          $post_wrapper.imagesLoaded(function () {
            $post_wrapper.masonry(/* {
                itemSelector: 'div[class*=ta-col-]',
                //fitWidth: true,
                percentPosition: true
              } */);
          });
        }

        /**
         * The Pagination effects.
         *
         * The effects for pagination to work for both mobile and other screens.
         */
        var Pagination_Type = $(eful_Wrapper_ID).data("pagination");
        if ($(window).width() <= 480) {
          var Pagination_Type = $(eful_Wrapper_ID).data("pagination_mobile");
        }
        // Ajax number pagination
        if (Pagination_Type == "ajax_pagination") {
          $(eful_Wrapper_ID).on("click", ".eventful-post-pagination a", function (e) {
            e.preventDefault();
            var that = $(this);
            var totalPage = $(
                ".eventful-post-pagination.eventful-on-desktop a:not(.eful_next, .eful_prev)",
                eful_Wrapper_ID
              ).length,
              currentPage = parseInt(
                $(
                  ".eventful-post-pagination.eventful-on-desktop .active:not(.eful_next, .eful_prev)",
                  eful_Wrapper_ID
                ).data("page")
              );
            if ($(window).width() <= 480) {
              var totalPage = $(
                  ".eventful-post-pagination.eventful-on-mobile a:not(.eful_next, .eful_prev)",
                  eful_Wrapper_ID
                ).length,
                currentPage = parseInt(
                  $(
                    ".eventful-post-pagination.eventful-on-mobile .active:not(.eful_next, .eful_prev)",
                    eful_Wrapper_ID
                  ).data("page")
                );
            }
            page = parseInt(that.data("page"));
            if (that.hasClass("eful_next")) {
              if (totalPage > currentPage) {
                var page = currentPage + 1;
              } else {
                return;
              }
            }
            if (that.hasClass("eful_prev")) {
              if (currentPage > 1) {
                var page = currentPage - 1;
              } else {
                return;
              }
            }
            var eful_paged = { page, page };
            $.ajax({
              url: ajaxurl,
              type: "post",
              data: {
                page: page,
                id: pc_sid,
                action: "post_grid_ajax",
                order: order,
                lang: spsp_lang,
                keyword: keyword,
                orderby: orderby,
                taxonomy: taxonomy,
                term_id: term_id,
                author_id: author_id,
                term_list: selected_term_list,
                nonce: nonce,
              },
              error: function (response) {
              },
              success: function (response) {
                var $data = $(response);
                var $newElements = $data;
                if ($(eful_Wrapper_ID).hasClass("eventful-masonry")) {
                  var $post_wrapper = $(".ta-row", eful_Wrapper_ID);
                  $post_wrapper.masonry("destroy");
                  $post_wrapper.html($newElements).imagesLoaded(function () {
                    $post_wrapper.masonry();
                  });
                } else if ($(eful_Wrapper_ID).hasClass("eventful-filter-wrapper")) {
                  $grid
                    .html($newElements)
                    .isotope("appended", $newElements)
                    .imagesLoaded(function () {
                      $grid.isotope("layout");
                    });
                  eful_item_same_height();
                } else {
                  $(
                    ".ta-row, .eventful-timeline-grid, .ta-collapse, .table-responsive tbody",
                    eful_Wrapper_ID
                  ).html($newElements);
                  if (eventfulAccordion.length > 0) {
                    eventfulAccordion.accordion("refresh");
                    if (accordion_mode === "multi-open") {
                      eventfulAccordion
                        .find(".eventful-collapse-header")
                        .next()
                        .slideDown();
                      eventfulAccordion
                        .find(".eventful-collapse-header .fa")
                        .removeClass("fa-plus")
                        .addClass("fa-minus");
                    }
                  }
                  var $newElements = $data.css({
                    opacity: 1,
                  });
                }
                $(".page-numbers", eful_Wrapper_ID).removeClass("active");
                $(".page-numbers", eful_Wrapper_ID).each(function () {
                  // if (parseInt($('.eventful-post-pagination a').data('page')) === page) {
                  $(
                    ".eventful-post-pagination a[data-page=" + page + "]",
                    eful_Wrapper_ID
                  ).addClass("active");
                  // }
                });
                $(".eful_next", eful_Wrapper_ID).removeClass("active");
                $(".eful_prev", eful_Wrapper_ID).removeClass("active");
                $(".eventful-post-pagination a.active", eful_Wrapper_ID).each(
                  function () {
                    if (parseInt($(this).data("page")) === totalPage) {
                      $(".eful_next", eful_Wrapper_ID).addClass("active");
                    }
                    if (parseInt($(this).data("page")) === 1) {
                      $(".eful_prev", eful_Wrapper_ID).addClass("active");
                    }
                  }
                );
                if (eventfulAccordion.length > 0) {
                  eventfulAccordion.accordion("refresh");
                  if (accordion_mode === "multi-open") {
                    eventfulAccordion
                      .find(".eventful-collapse-header")
                      .next()
                      .slideDown();
                    eventfulAccordion
                      .find(".eventful-collapse-header .fa")
                      .removeClass("fa-plus")
                      .addClass("fa-minus");
                  }
                }
                $newElements.animate({
                  opacity: 1,
                });
                eful_lazyload();
                // Ajax Number pagination go to current shortcode top.
                var url_hash = window.location.search;
                if (url_hash.indexOf("eful_page") >= 0) {
                  var current_screen_id =
                    document.querySelector(eful_Wrapper_ID);
                  current_screen_id.scrollIntoView();
                }
              },
            });
            eful_hash_update_arr(page, eful_paged, "page");
            eful_update_url();
          });
        }

        /**
         * Ajax load on click and Infinite scroll.
         */
        if (
          Pagination_Type == "infinite_scroll" ||
          Pagination_Type == "ajax_load_more"
        ) {
          $(eful_Wrapper_ID).each(function () {
            var EndingMessage = $(this)
              .find(".ta-eventful-pagination-data")
              .data("endingtext");
            var LoadMoreText = $(this)
              .find(".ta-eventful-pagination-data")
              .data("loadmoretext");
            if (
              !$(this)
                .find(".eventful-load-more")
                .hasClass("eventful-load-more-initialize")
            ) {
              if ($(".eventful-post-pagination a", eful_Wrapper_ID).length) {
                $(".eventful-post-pagination", eful_Wrapper_ID)
                  .eq(0)
                  .before(
                    '<div class="eventful-load-more"><button eventfulcessing="0">' +
                      LoadMoreText +
                      "</button></div>"
                  );
              }
              if (Pagination_Type == "infinite_scroll") {
                $(".eventful-load-more", eful_Wrapper_ID).addClass("eventful-hide");
              }
              $(".eventful-post-pagination", eful_Wrapper_ID).addClass("eventful-hide");
              $(".ta-row div[class*=ta-col-]", eful_Wrapper_ID).addClass(
                "eventful-added"
              );
              $(this)
                .find(".eventful-load-more")
                .addClass("eventful-load-more-initialize");
              $(this).on("click", ".eventful-load-more button", function (e) {
                e.preventDefault();
                if (
                  $(
                    ".eventful-post-pagination a.active:not(.eful_next, .eful_prev)",
                    eful_Wrapper_ID
                  ).length
                ) {
                  $(".eventful-load-more button").attr("eventfulcessing", 1);
                  var current_page = parseInt(
                    $(
                      ".eventful-post-pagination a.active:not(.eful_next, .eful_prev)",
                      eful_Wrapper_ID
                    ).data("page")
                  );
                  current_page = current_page + 1;
                  $(".eventful-load-more", eful_Wrapper_ID).hide();
                  $(".eventful-post-pagination", eful_Wrapper_ID)
                    .eq(0)
                    .before(
                      '<div class="eventful-infinite-scroll-loader"><svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#444"><g fill="none" fill-rule="evenodd" stroke-width="2"><circle cx="22" cy="22" r="1"><animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/></circle></g></svg></div>'
                    );
                  var totalPage = $(
                    ".eventful-post-pagination.eventful-on-desktop.infinite_scroll a:not(.eful_next, .eful_prev), .eventful-post-pagination.eventful-on-desktop.ajax_load_more a:not(.eful_next, .eful_prev)",
                    eful_Wrapper_ID
                  ).length;
                  if ($(window).width() <= 480) {
                    var totalPage = $(
                      ".eventful-post-pagination.eventful-on-mobile.infinite_scroll a:not(.eful_next, .eful_prev), .eventful-post-pagination.ajax_load_more.eventful-on-mobile  a:not(.eful_next, .eful_prev)",
                      eful_Wrapper_ID
                    ).length;
                  }
                  page = current_page;
                  $.ajax({
                    url: ajaxurl,
                    type: "post",
                    data: {
                      page: page,
                      id: pc_sid,
                      action: "post_grid_ajax",
                      order: order,
                      lang: spsp_lang,
                      keyword: keyword,
                      orderby: orderby,
                      taxonomy: taxonomy,
                      term_id: term_id,
                      author_id: author_id,
                      term_list: selected_term_list,
                      nonce: nonce,
                    },
                    error: function (response) {
                    },
                    success: function (response) {
                      var $data = $(response);
                      var $newElements = $data;
                      if ($(eful_Wrapper_ID).hasClass("eventful-masonry")) {
                        var $post_wrapper = $(".ta-row", eful_Wrapper_ID);
                        $post_wrapper.masonry("destroy");
                        $post_wrapper
                          .append($newElements)
                          .imagesLoaded(function () {
                            $post_wrapper.masonry();
                          });
                      } else if (
                        $(eful_Wrapper_ID).hasClass("eventful-filter-wrapper")
                      ) {
                        $grid
                          .append($newElements)
                          .isotope("appended", $newElements)
                          .imagesLoaded(function () {
                            $grid.isotope("layout");
                          });
                        eful_item_same_height();
                      } else {
                        var $newElements = $data.css({
                          opacity: 0,
                        });
                        $(
                          ".ta-row, .eventful-timeline-grid, .ta-collapse, .table-responsive tbody",
                          eful_Wrapper_ID
                        ).append($newElements);
                        if (eventfulAccordion.length > 0) {
                          eventfulAccordion.accordion("refresh");
                          if (accordion_mode === "multi-open") {
                            eventfulAccordion
                              .find(".eventful-collapse-header")
                              .next()
                              .slideDown();
                            eventfulAccordion
                              .find(".eventful-collapse-header .fa")
                              .removeClass("fa-plus")
                              .addClass("fa-minus");
                          }
                        }
                        var $newElements = $data.css({
                          opacity: 1,
                        });
                      }
                      $(".page-numbers", eful_Wrapper_ID).removeClass("active");
                      $(".page-numbers", eful_Wrapper_ID).each(function () {
                        $(
                          ".eventful-post-pagination a[data-page=" + page + "]",
                          eful_Wrapper_ID
                        ).addClass("active");
                      });
                      $(".eventful-infinite-scroll-loader", eful_Wrapper_ID).remove();
                      if (Pagination_Type == "ajax_load_more") {
                        $(".eventful-load-more").show();
                      }
                      $(".eventful-load-more button").attr("eventfulcessing", 0);
                      $(".ta-row div[class*=ta-col-]", eful_Wrapper_ID)
                        .not(".eventful-added")
                        .addClass("animated eventfulFadeIn")
                        .one("webkitAnimationEnd animationEnd", function () {
                          $(this)
                            .removeClass("animated eventfulFadeIn")
                            .addClass("eventful-added");
                        });
                      if (totalPage == current_page) {
                        $(".eventful-load-more", eful_Wrapper_ID)
                          .addClass("finished")
                          .removeClass("eventful-hide");
                        $(".eventful-load-more", eful_Wrapper_ID)
                          .show()
                          .html(EndingMessage);
                      }
                      eful_lazyload();
                    },
                  });
                } else {
                  $(".eventful-load-more", eful_Wrapper_ID)
                    .addClass("finished")
                    .removeClass("eventful-hide");
                  $(".eventful-load-more", eful_Wrapper_ID)
                    .show()
                    .html(EndingMessage);
                }
              });
            }
            if (Pagination_Type == "infinite_scroll") {
              var bufferBefore = Math.abs(20);
              $(window).scroll(function () {
                if (
                  $(
                    ".ta-row, .ta-collapse, .eventful-timeline-grid, .table-responsive tbody",
                    eful_Wrapper_ID
                  ).length
                ) {
                  var TopAndContent =
                    $(
                      ".ta-row, .ta-collapse, .eventful-timeline-grid, .table-responsive tbody",
                      eful_Wrapper_ID
                    ).offset().top +
                    $(
                      ".ta-row, .ta-collapse, .eventful-timeline-grid, .table-responsive tbody",
                      eful_Wrapper_ID
                    ).outerHeight();
                  var areaLeft = TopAndContent - $(window).scrollTop();
                  if (areaLeft - bufferBefore < $(window).height()) {
                    if (
                      $(".eventful-load-more button", eful_Wrapper_ID).attr(
                        "eventfulcessing"
                      ) == 0
                    ) {
                      $(".eventful-load-more button", eful_Wrapper_ID).trigger(
                        "click"
                      );
                    }
                  }
                }
              });
            }
          });
        }

        /* This code added for divi-builder ticker mode compatibility. */
        if (eventfulCarousel.length > 0 && eventfulCarouselData.mode == "ticker") {
          $(".ta-eventful-carousel img").removeAttr("loading");
          $(window).on("load", function () {
            $(".ta-eventful-carousel").each(function () {
              var thisdfd = $(this);
              var thisCSS = thisdfd.attr("style");
              $(this).removeAttr("style");
              setTimeout(function () {
                thisdfd.attr("style", thisCSS);
              }, 0);
            });
          });
        }

        /* Preloader js */
        $(document).ready(function () {
          $(".eventful-preloader", eful_Wrapper_ID).css({
            backgroundImage: "none",
            visibility: "hidden",
          });
        });
        // This function added for eventful-Lazyload.
        function eful_lazyload() {
          var $is_find = $(".eful__item--thumbnail img").hasClass(
            "eventful-lazyload"
          );
          if ($is_find) {
            $("img.eventful-lazyload")
              .eful_lazyload({ effect: "fadeIn", effectTime: 2000 })
              .removeClass("eventful-lazyload")
              .addClass("eventful-lazyloaded");
          }
          // eful_item_same_height();
        }
        eful_lazyload();
      });
    }
  };
  eful_myScript();
});
