/*  jQuery Nice Select - v1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
!function (e) { e.fn.niceSelect = function (t) { function s(t) { t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class") || "").addClass(t.attr("disabled") ? "disabled" : "").attr("tabindex", t.attr("disabled") ? null : "0").html('<span class="current"></span><ul class="list"></ul>')); var s = t.next(), n = t.find("option"), i = t.find("option:selected"); s.find(".current").html(i.data("display") || i.text()), n.each(function (t) { var n = e(this), i = n.data("display"); s.find("ul").append(e("<li></li>").attr("data-value", n.val()).attr("data-display", i || null).addClass("option" + (n.is(":selected") ? " selected" : "") + (n.is(":disabled") ? " disabled" : "")).html(n.text())) }) } if ("string" == typeof t) return "update" == t ? this.each(function () { var t = e(this), n = e(this).next(".nice-select"), i = n.hasClass("open"); n.length && (n.remove(), s(t), i && t.next().trigger("click")) }) : "destroy" == t ? (this.each(function () { var t = e(this), s = e(this).next(".nice-select"); s.length && (s.remove(), t.css("display", "")) }), 0 == e(".nice-select").length && e(document).off(".nice_select")) : console.log('Method "' + t + '" does not exist.'), this; this.hide(), this.each(function () { var t = e(this); t.next().hasClass("nice-select") || s(t) }), e(document).off(".nice_select"), e(document).on("click.nice_select", ".nice-select", function (t) { var s = e(this); e(".nice-select").not(s).removeClass("open"), s.toggleClass("open"), s.hasClass("open") ? (s.find(".option"), s.find(".focus").removeClass("focus"), s.find(".selected").addClass("focus")) : s.focus() }), e(document).on("click.nice_select", function (t) { 0 === e(t.target).closest(".nice-select").length && e(".nice-select").removeClass("open").find(".option") }), e(document).on("click.nice_select", ".nice-select .option:not(.disabled)", function (t) { var s = e(this), n = s.closest(".nice-select"); n.find(".selected").removeClass("selected"), s.addClass("selected"); var i = s.data("display") || s.text(); n.find(".current").text(i), n.prev("select").val(s.data("value")).trigger("change") }), e(document).on("keydown.nice_select", ".nice-select", function (t) { var s = e(this), n = e(s.find(".focus") || s.find(".list .option.selected")); if (32 == t.keyCode || 13 == t.keyCode) return s.hasClass("open") ? n.trigger("click") : s.trigger("click"), !1; if (40 == t.keyCode) { if (s.hasClass("open")) { var i = n.nextAll(".option:not(.disabled)").first(); i.length > 0 && (s.find(".focus").removeClass("focus"), i.addClass("focus")) } else s.trigger("click"); return !1 } if (38 == t.keyCode) { if (s.hasClass("open")) { var l = n.prevAll(".option:not(.disabled)").first(); l.length > 0 && (s.find(".focus").removeClass("focus"), l.addClass("focus")) } else s.trigger("click"); return !1 } if (27 == t.keyCode) s.hasClass("open") && s.trigger("click"); else if (9 == t.keyCode && s.hasClass("open")) return !1 }); var n = document.createElement("a").style; return n.cssText = "pointer-events:auto", "auto" !== n.pointerEvents && e("html").addClass("no-csspointerevents"), this } }(jQuery);


$(document).ready(function () {
  //nice select 
  $('select').niceSelect();


  $('.back-to-top').hide();
  $(window).scroll(function () {
    if ($(this).scrollTop() >= 300) {
      $('.back-to-top').fadeIn();
    } else {
      $('.back-to-top').fadeOut();
    }
  });

  // Click event to scroll to top
  $('.back-to-top').click(function () {
    $('html, body').animate({ scrollTop: 0 });
    return false;
  });


  /********* On scroll header Sticky *********/
  $(window).scroll(function () {
    if ($(window).scrollTop() >= 100) {
      $('header').addClass('header-sticky');
    }
    else {
      $('header').removeClass('header-sticky');
    }
  });

  var headerHeight = $('header').outerHeight();
  $('header').nextAll('section,div').first().css('margin-top', headerHeight + 'px');


  // Mobile Menu 
  $(".mobile-menu-button").on("click", function () {
    $(".mobile-menu-wrapper, body").toggleClass("active-menu");
  });
  $(".menu-close-icon svg").on("click", function () {
    $(".mobile-menu-wrapper, body").toggleClass("active-menu");
  });


  // card hover effect 
  $('.main-card .inner-card').mouseenter(function () {
    $(this).parent().find('.plant-img').css({ 'margin-left': '20px' });
  });
  $('.main-card .inner-card').mouseleave(function () {
    $(this).parent().find('.plant-img').css({ 'margin-left': '0px' });
  });

  
  // Header Search Popup  
  $("#header-search").click(function () {
    $(".search-popup").toggleClass("active");
    $("body").toggleClass("no-scroll");
  });
  $(".close-search, .search-form-wrapper #btn-submit").click(function () {
    $(".search-popup").removeClass("active");
    $("body").removeClass("no-scroll");
  });

  //  Cart Popup
  $('.cart-header').on('click', function (e) {
    e.preventDefault();
    setTimeout(function () {
      $('body').addClass('no-scroll cartOpen');
      $('.overlay').addClass('cart-overlay');
    }, 50);
  });
  $('body').on('click', '.overlay.cart-overlay, .closecart', function (e) {
    e.preventDefault();
    $('.overlay').removeClass('cart-overlay');
    $('body').removeClass('no-scroll cartOpen');
  });
  // Subscribe popup Js
  $('.close-sub-btn').click(function () {
    $('.subscribe-popup').slideUp();
    $(".subscribe-overlay").removeClass("open");
  });

  // increment decrement 
  var quantity = 0;
  $('.quantity-increment').click(function () {
    var t = $(this).siblings('.quantity');
    var quantity = parseInt($(t).val());
    $(t).val(quantity + 1);
  });
  $('.quantity-decrement').click(function () {
    var t = $(this).siblings('.quantity');
    var quantity = parseInt($(t).val());
    if (quantity > 1) {
      $(t).val(quantity - 1);
    }
  });

  // video pop up 
  //video-play 
  $('.play-vid').on('click', function () {
    if ($(this).attr('data-click') == 1) {
      $(this).attr('data-click', 0)
      $('#img-vid')[0].pause();
      $(".play-vid").css("opacity", "1");
    } else {
      $(this).attr('data-click', 1)
      $('#img-vid')[0].play();
      $(".play-vid").css("opacity", "1");
      $(".play-vid").css("opacity", "0");
    }
  });
  $('.play-btn').click(function (m) {
    $('body,html').addClass('no-scroll popupopen');
    $('.overlay-popup').addClass('popup-show');
  });
  $('.close-popup').click(function (m) {
    $('body,html').removeClass('no-scroll popupopen');
    $('.overlay-popup').removeClass('popup-show');
  });
  // number counter
  function inVisible(element) {
    var WindowTop = $(window).scrollTop();
    var WindowBottom = WindowTop + $(window).height();
    var ElementTop = element.offset().top;
    var ElementBottom = ElementTop + element.height();
    if ((ElementBottom <= WindowBottom) && ElementTop >= WindowTop)
      animate(element);
  }
  function animate(element) {
    if (!element.hasClass('ms-animated')) {
      var maxval = element.data('max');
      var html = element.html();
      element.addClass("ms-animated");
      $({
        countNum: element.html()
      }).animate({
        countNum: maxval
      }, {
        duration: 5000,
        easing: 'linear',
        step: function () {
          element.html(Math.floor(this.countNum) + html);
        },
        complete: function () {
          element.html(this.countNum + html);
        }
      });
    }
  }
  //When the document is ready
  $(function () {
    $(window).scroll(function () {
      $("h2[data-max]").each(function () {
        inVisible($(this));
      });
    });
  });
  // number counter end

 
 
  //  TAB Js filter gallary
  $('ul.tabs li').click(function () {
    var tab_id = $(this).attr('data-tab');
    $('ul.tabs li').removeClass('active');
    $('.tab-content').removeClass('active');
    $(this).addClass('active');
    $("#" + tab_id).addClass('active');
    $('.shop-protab-slider').slick('refresh');
  })
 

  // product list page start 
  $('.acnav-label').click(function () {
    var label = $(this);
    var parent = label.parent('.has-children');
    var list = label.siblings('.acnav-list');
    if (parent.hasClass('is-open')) {
      list.slideUp('fast');
      parent.removeClass('is-open');
    }
    else {
      list.slideDown('fast');
      parent.addClass('is-open');
    }
  });

  // Mobile Filter Popup 
  $('.filter-icn').on('click', function (e) {
    e.preventDefault();
    setTimeout(function () {
      $('body').addClass('no-scroll filter-open');
      $('.overlay').addClass('active');
    }, 50);
  });

  $('body').on('click', '.overlay.active, .close-filter', function (e) {
    e.preventDefault();
    $('.overlay').removeClass('active');
    $('body').removeClass('no-scroll filter-open');
  });

  if ($(".my-acc-column").length > 0) {
    jQuery(function ($) {
      var topMenuHeight = $("#daccount-nav").outerHeight();
      $("#account-nav").menuScroll(topMenuHeight);
      $(".account-list li:first-child").addClass("active");
    });
    // COPY THE FOLLOWING FUNCTION INTO ANY SCRIPTS
    jQuery.fn.extend({
      menuScroll: function (offset) {
        // Declare all global variables
        var topMenu = this;
        var topOffset = offset ? offset : 0;
        var menuItems = $(topMenu).find("a");
        var lastId;
        // Save all menu items into scrollItems array
        var scrollItems = $(menuItems).map(function () {
          var item = $($(this).attr("href"));
          if (item.length) {
            return item;
          }
        });
        // When the menu item is clicked, get the #id from the href value, then scroll to the #id element
        $(topMenu).on("click", "a", function (e) {
          var href = $(this).attr("href");
          var offsetTop = href === "#" ? 0 : $(href).offset().top - topOffset;
          function checkWidth() {
            var windowSize = $(window).width();
            if (windowSize <= 767) {
              $('html, body').stop().animate({
                scrollTop: offsetTop - 200
              }, 300);
            }
            else {
              $('html, body').stop().animate({
                scrollTop: offsetTop - 100
              }, 300);
            }
          }
          // Execute on load
          checkWidth();
          // Bind event listener
          $(window).resize(checkWidth);
          e.preventDefault();
        });
        // When page is scrolled
        $(window).scroll(function () {
          function checkWidth() {
            var windowSize = $(window).width();
            if (windowSize <= 767) {
              var nm = $("html").scrollTop();
              var nw = $("body").scrollTop();
              var fromTop = (nm > nw ? nm : nw) + topOffset;
              // When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
              var current = $(scrollItems).map(function () {
                if ($(this).offset().top - 250 <= fromTop)
                  return this;
              });
              // Get the most recent passed section from current array
              current = current[current.length - 1];
              var id = current && current.length ? current[0].id : "";
              if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                $(menuItems)
                  .parent().removeClass("active")
                  .end().filter("[href='#" + id + "']").parent().addClass("active");
              }
            }
            else {
              var nm = $("html").scrollTop();
              var nw = $("body").scrollTop();
              var fromTop = (nm > nw ? nm : nw) + topOffset;
              // When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
              var current = $(scrollItems).map(function () {
                if ($(this).offset().top <= fromTop)
                  return this;
              });
              // Get the most recent passed section from current array
              current = current[current.length - 1];
              var id = current && current.length ? current[0].id : "";
              if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                $(menuItems)
                  .parent().removeClass("active")
                  .end().filter("[href='#" + id + "']").parent().addClass("active");
              }
            }
          }
          // Execute on load
          checkWidth();
          // Bind event listener
          $(window).resize(checkWidth);
        });
      }
    });
  }

  initializeThemeSliders();


});

function initializeThemeSliders() {
  
  // hero slider
  $('.hero-main-slider').slick({
    arrows: true,
    dots: true,
    autoplay: true,
    speed: 2000,
    autoplaySpeed: 1000,
    swipeToSlide: true,
    swipeToSlide: true,
  });


  if ($('.shop-protab-slider').length > 0) {
    $('.shop-protab-slider').slick({
      // rows: 2,
      arrows: true,
      dots: false,
      infinite: true,
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: '<button class="slide-arrow slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9595 6.00095C12.2361 5.72433 12.2361 5.27584 11.9595 4.99921L7.70953 0.749214C7.43291 0.472592 6.98441 0.472592 6.70779 0.749214C6.43117 1.02584 6.43117 1.47433 6.70779 1.75095L10.4569 5.50008L6.70779 9.24921C6.43117 9.52584 6.43117 9.97433 6.70779 10.2509C6.98441 10.5276 7.4329 10.5276 7.70953 10.2509L11.9595 6.00095ZM2.04286 10.2509L6.29286 6.00095C6.56948 5.72433 6.56948 5.27584 6.29286 4.99921L2.04286 0.749214C1.76624 0.472592 1.31775 0.472592 1.04113 0.749214C0.764503 1.02583 0.764503 1.47433 1.04113 1.75095L4.79026 5.50008L1.04112 9.24921C0.764503 9.52584 0.764503 9.97433 1.04112 10.2509C1.31775 10.5276 1.76624 10.5276 2.04286 10.2509Z" fill="white"/></svg></button>',
            nextArrow: '<button class="slide-arrow slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9595 6.00095C12.2361 5.72433 12.2361 5.27584 11.9595 4.99921L7.70953 0.749214C7.43291 0.472592 6.98441 0.472592 6.70779 0.749214C6.43117 1.02584 6.43117 1.47433 6.70779 1.75095L10.4569 5.50008L6.70779 9.24921C6.43117 9.52584 6.43117 9.97433 6.70779 10.2509C6.98441 10.5276 7.4329 10.5276 7.70953 10.2509L11.9595 6.00095ZM2.04286 10.2509L6.29286 6.00095C6.56948 5.72433 6.56948 5.27584 6.29286 4.99921L2.04286 0.749214C1.76624 0.472592 1.31775 0.472592 1.04113 0.749214C0.764503 1.02583 0.764503 1.47433 1.04113 1.75095L4.79026 5.50008L1.04112 9.24921C0.764503 9.52584 0.764503 9.97433 1.04112 10.2509C1.31775 10.5276 1.76624 10.5276 2.04286 10.2509Z" fill="white"/></svg></button>',
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: '<button class="slide-arrow slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9595 6.00095C12.2361 5.72433 12.2361 5.27584 11.9595 4.99921L7.70953 0.749214C7.43291 0.472592 6.98441 0.472592 6.70779 0.749214C6.43117 1.02584 6.43117 1.47433 6.70779 1.75095L10.4569 5.50008L6.70779 9.24921C6.43117 9.52584 6.43117 9.97433 6.70779 10.2509C6.98441 10.5276 7.4329 10.5276 7.70953 10.2509L11.9595 6.00095ZM2.04286 10.2509L6.29286 6.00095C6.56948 5.72433 6.56948 5.27584 6.29286 4.99921L2.04286 0.749214C1.76624 0.472592 1.31775 0.472592 1.04113 0.749214C0.764503 1.02583 0.764503 1.47433 1.04113 1.75095L4.79026 5.50008L1.04112 9.24921C0.764503 9.52584 0.764503 9.97433 1.04112 10.2509C1.31775 10.5276 1.76624 10.5276 2.04286 10.2509Z" fill="white"/></svg></button>',
            nextArrow: '<button class="slide-arrow slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9595 6.00095C12.2361 5.72433 12.2361 5.27584 11.9595 4.99921L7.70953 0.749214C7.43291 0.472592 6.98441 0.472592 6.70779 0.749214C6.43117 1.02584 6.43117 1.47433 6.70779 1.75095L10.4569 5.50008L6.70779 9.24921C6.43117 9.52584 6.43117 9.97433 6.70779 10.2509C6.98441 10.5276 7.4329 10.5276 7.70953 10.2509L11.9595 6.00095ZM2.04286 10.2509L6.29286 6.00095C6.56948 5.72433 6.56948 5.27584 6.29286 4.99921L2.04286 0.749214C1.76624 0.472592 1.31775 0.472592 1.04113 0.749214C0.764503 1.02583 0.764503 1.47433 1.04113 1.75095L4.79026 5.50008L1.04112 9.24921C0.764503 9.52584 0.764503 9.97433 1.04112 10.2509C1.31775 10.5276 1.76624 10.5276 2.04286 10.2509Z" fill="white"/></svg></button>',
          }
        }
      ]
    });
  }
   // Slick lightbox 
   if ($('.lightbox').length > 0) {
    $('.lightbox').slickLightbox({
      itemSelector: 'a.open-lightbox',
      caption: 'caption',
      prevArrow: '<button class="slide-arrow slick-prev"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
      nextArrow: '<button class="slide-arrow slick-next"><svg viewBox="0 0 10 5"><path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z"></path></svg></button>',
      navigateByKeyboard: true,
      layouts: {
        closeButton: '<button class="close"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none"><path d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z" fill="white"></path></svg></button>'
      }
    });
  }

   // article sec slider
   $('.article-slider').slick({
    infinite: true,
    slidesToShow: 4,
    speed: 800,
    autoplaySpeed: 1000,
    autoplay: false,
    slidesToScroll: 1,
    swipeToSlide: true,
    centerMode: false,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
        }
      }],
  });


  // best-seller-slider
  $('.best-seller-slider').slick({
    infinite: true,
    slidesToShow: 4,
    speed: 800,
    autoplaySpeed: 1500,
    slidesToScroll: 1,
    swipeToSlide: true,
    arrows: true,

    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
        }
      }],
  });

  // testimonials slider 
  $('.testi-slider').slick({
    arrows: true,
    dots: false,
    slidesToShow: 1,
    speed: 1000,
    autoplaySpeed: 1000,
    swipeToSlide: true,
    asNavFor: '.right-slide-slider',
  });

  // right-slide-slider
  $('.right-slide-slider').slick({
    arrows: false,
    dots: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 1000,
    autoplaySpeed: 1000,
    swipeToSlide: true,
    asNavFor: '.testi-slider',
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,

        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,

        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,

        }
      },
    ]
  });

  // fifth-sec-right-slider
  $('.fifth-sec-right-slider').slick({
    arrows: true,
    dots: false,
    slidesToShow: 2,
    speed: 1000,
    autoplaySpeed: 1000,
    swipeToSlide: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
        }
      },
    ]
  });

  // product slider 
  $('.product-main-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    infinite: true,
    speed: 1000,
    loop: true,
    asNavFor: '.product-thumb-slider',
    autoplay: false,
    responsive: [{
      breakpoint: 1200,
      settings: {
        arrows: false,
        dots: false,
      }
    }]
  });

  $('.product-thumb-slider').slick({
    slidesToShow: 2,
    arrows: true,
    asNavFor: '.product-main-slider',
    dots: false,
    speed: 1000,
    slidesToScroll: 1,
    prevArrow: '<button class="slide-arrow slick-prev"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9595 6.00095C12.2361 5.72433 12.2361 5.27584 11.9595 4.99921L7.70953 0.749214C7.43291 0.472592 6.98441 0.472592 6.70779 0.749214C6.43117 1.02584 6.43117 1.47433 6.70779 1.75095L10.4569 5.50008L6.70779 9.24921C6.43117 9.52584 6.43117 9.97433 6.70779 10.2509C6.98441 10.5276 7.4329 10.5276 7.70953 10.2509L11.9595 6.00095ZM2.04286 10.2509L6.29286 6.00095C6.56948 5.72433 6.56948 5.27584 6.29286 4.99921L2.04286 0.749214C1.76624 0.472592 1.31775 0.472592 1.04113 0.749214C0.764503 1.02583 0.764503 1.47433 1.04113 1.75095L4.79026 5.50008L1.04112 9.24921C0.764503 9.52584 0.764503 9.97433 1.04112 10.2509C1.31775 10.5276 1.76624 10.5276 2.04286 10.2509Z" fill="white"/></svg></button>',
    nextArrow: '<button class="slide-arrow slick-next"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9595 6.00095C12.2361 5.72433 12.2361 5.27584 11.9595 4.99921L7.70953 0.749214C7.43291 0.472592 6.98441 0.472592 6.70779 0.749214C6.43117 1.02584 6.43117 1.47433 6.70779 1.75095L10.4569 5.50008L6.70779 9.24921C6.43117 9.52584 6.43117 9.97433 6.70779 10.2509C6.98441 10.5276 7.4329 10.5276 7.70953 10.2509L11.9595 6.00095ZM2.04286 10.2509L6.29286 6.00095C6.56948 5.72433 6.56948 5.27584 6.29286 4.99921L2.04286 0.749214C1.76624 0.472592 1.31775 0.472592 1.04113 0.749214C0.764503 1.02583 0.764503 1.47433 1.04113 1.75095L4.79026 5.50008L1.04112 9.24921C0.764503 9.52584 0.764503 9.97433 1.04112 10.2509C1.31775 10.5276 1.76624 10.5276 2.04286 10.2509Z" fill="white"/></svg></button>',
    touchMove: true,
    focusOnSelect: true,
    loop: true,
    infinite: true,
    vertical: true,
    responsive: [{

      breakpoint: 1200,
      settings: {
        slidesToShow: 2,

      },
      breakpoint: 576,
      settings: {
        vertical: false,
      }
    }]
  });


}

/********* Cart Popup ********/
$('.wish-header').on('click', function (e) {
  e.preventDefault();
  setTimeout(function () {
    $('body').addClass('no-scroll wishOpen');
    $('.overlay').addClass('wish-overlay');
  }, 50);
});
$('body').on('click', '.overlay.wish-overlay, .closewish', function (e) {
  e.preventDefault();
  $('.overlay').removeClass('wish-overlay');
  $('body').removeClass('no-scroll wishOpen');
});


