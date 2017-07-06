  (function($) {



    $(document).ready(function() {


      /* Fundraising Paypal Form */
      // $('#featured-page-4').hide();
      $('.footer-widgets .featuredpage').append('<span class="fundraise-close">close</span>');

      $('.fundraise-open a[title="Fundraising"], .footer-widgets a[title="Fundraise"]').click(function(){
        $('.footer-widgets .featuredpage').show();
        $('body').css('overflow-y','hidden');
      });

      $('.fundraise-close').click(function(){
        $('.footer-widgets .featuredpage').hide();
        $('body').css('overflow-y','auto');
      });


      /*
      * Gallery Lightbox
      */

      $('.gallery-section').hide();
      if($('.gallery-section').find('*').hasClass('grid-item')) {
        $('.gallery-section').show(); 
        $('.gallery-section').addClass('gallery-modal');
        $('body').css('overflow-y','hidden');
      } 

      $('.close-lightbox').click(function(){
        $('.gallery-section').hide();
        $('body').css('overflow-y','auto');
      });

      $('.cws-pagination').children('span').remove();

      /* Dropdown Button */
      $( "body" ).delegate( ".dropdown-toggle", "click", function() {
        $('.check-mark').addClass('fa fa-check fa-1x');
        $('.dropdown-menu.open').css('min-height', '100%');
        $('.dropdown-menu.open').css('overflow', 'visible');
        $('.dropdown-menu.open').slideToggle();
        $('ul.dropdown-menu li:first-child').css('display','none');

        // if($('.dropdown-toggle').attr('title') == "Volunteer Languages") {
        //   $('.dropdown-toggle').css('font-size', '13px');
        // } else {
        //   $('.dropdown-toggle').css('font-size', '15px');
        // }

      });

      /*Pagination on mobile*/
      $('.pagination-next').children('a').text('»');
      $('.pagination-previous').children('a').text('«');

  // Header Height
  var headerHeight = $('.site-header').outerHeight();
  $('.site-inner').css('margin-top', headerHeight + 'px');

  /*
  * Header Responsive Scroll
  */
  $('.responsive-menu-icon').click(function() { 
    $('body').toggleClass('body-overflow');
  });


  /*
  * Donate Tabs 
  */
  var $donatevalue = $("#donationvalue"),
  $inputamt = $("#00N7F000001pAWj");
  
  $donatevalue.wrap('<div class="donation-box"></div>');
  $donatevalue.val(60);

  var donationVal = $inputamt.val(),
  donateVal;

  $(".stripe-paypal-form").hide();

  $(".donate-btn").click(function() {
    var container = $(this).parent(".salesforce-form");
    $(this).parent().hide();
    $(this).siblings(".donation-box").remove();
    $(".direct-stripe input").hide();
    container.parent(".donate-form").siblings(".stripe-paypal-form").show();
  });

  $donatevalue.attr("value", donationVal);
  $inputamt.keyup(function() {
    donateVal = $(this).val();
    $("#donationvalue").val(donateVal);
  });


  /*
  * Site Logo
  */

  $('.site-title').children('a').attr("title",'Haiti Now');

  /*
  * Search Button on Blog
  */
  var $search = $('.search-form');
  $search.children('input[type=submit]').addClass('fa fa-search fa-lg');
  $search.children('input[type=submit]').remove();
  $search.append('<button type="submit"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>');

  /*
  * Ajax Load More
  */
  var $loadmore = $(".loadmore");
  var moviespage = $loadmore.data('page'),
  total = $loadmore.data('total');

  if( moviespage == total) {
    $loadmore.hide();
  }

  $( document ).on( 'click', '.loadmore', function() {
    var thatelement = $(this);
    var page1= thatelement.data('page');
    var total = thatelement.data('total');
    var newPage = page1+1;
    var ajaxurl = thatelement.data('url');
    var category = thatelement.data('category');
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        page: page1,
        category: category,
        action: 'ajax_load_more'
      },
      error: function( response ) {
        console.log(response);
      },
      success: function( response ) {
        thatelement.data("page", newPage);
        $('#loadmore-data').append( response );

        if( newPage == total) {
          $loadmore.hide();
        }

        $('.less-content').hide();

        postcont = $('.detailed-content');

        postcont.each(function(){ 
          var posttxt = $(this).text();
          $(this).html('<span>' + posttxt.slice(0,132) +  '</span>' + '<span class="excerpt-content">' + posttxt.slice(132,posttxt.length) + '</span>');
        });

        $('.excerpt-content').slideUp('fast', function(){
          $(this).css('display','none');
        });

        $('.more-content').click(function() {
          $(this).hide();
          $(this).siblings('span').show();
          $(this).siblings('.detailed-content').children('.excerpt-content').slideDown(function(){
            $(this).css('display','inline');
          });
        });

        $('.less-content').click(function() {
          $(this).hide();
          $(this).siblings('span').show();
          $(this).siblings('.detailed-content').children('.excerpt-content').slideUp('fast', function(){
            $(this).css('display','none');
          });
        });

      }

    });

  });



  $('.less-content').hide();

  postcont = $('.detailed-content');

  postcont.each(function(){ 
    var posttxt = $(this).text();
    $(this).html('<span>' + posttxt.slice(0,132) +  '</span>' + '<span class="excerpt-content">' + posttxt.slice(132,posttxt.length) + '</span>');
  });

  $('.excerpt-content').slideUp('fast', function(){
    $(this).css('display','none');
  });

  $('.more-content').click(function() {
    $(this).hide();
    $(this).siblings('span').show();
    $(this).siblings('.detailed-content').children('.excerpt-content').slideDown(function(){
      $(this).css('display','inline');
    });
  });

  $('.less-content').click(function() {
    $(this).hide();
    $(this).siblings('span').show();
    $(this).siblings('.detailed-content').children('.excerpt-content').slideUp('fast', function(){
      $(this).css('display','none');
    });
  });


  /*
  * Ajax Load More Functionality for books
  */
  var $loadmore_books = $(".loadmore-books");
  var page1 = $loadmore_books.data('page'),
  totalpages = $loadmore_books.data('totalcount');
  if( page1 == totalpages) {
    $loadmore_books.hide();
  }

  $( document ).on( 'click', '.loadmore-books', function() {
    var thatelement = $(this);
    var page1= thatelement.data('page');
    var total = thatelement.data('totalcount');
    var newPage = page1+1;
    var ajaxurl = thatelement.data('url');
    var type = thatelement.data('post');

    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        page: page1,
        books: type,
        action: 'ajax_load_more_books'
      },
      error: function( response ) {
      },
      success: function( response ) {
        thatelement.data("page", newPage);

        $('#load-books').append( response );

        if( newPage == total) {
          $loadmore_books.hide();
        }
      }

    });

  });


// form validation
var validate = function(field, id, regx, range, btn_event) {
  var input_value = $(id).val();
  var reg = regx;

  if(input_value != "") {
    if(!(reg.test(input_value))) {
      $(id).siblings('p').removeClass('blank-text');
      $(id).siblings('p').text('Please enter a valid ' + field + '.');
      btn_event.preventDefault(btn_event);      
    } else if( input_value.length > range  ) {
      $(id).siblings('p').removeClass('blank-text');
      $(id).siblings('p').text('User can not physically enter more than ' + range + ' characters.');
      btn_event.preventDefault(btn_event); 
    } else {
      $(id).siblings('p').addClass('blank-text');
    }

  } else {
    $(id).siblings('p').text('Please enter your ' + field + '.');
    btn_event.preventDefault(btn_event);
  }

}


// Regex

var name_reg = /^[a-zA-Z0-9$ &+, :;=^@#|'"\\\[\]. ^()%!{}-]{1,100000}$/;
var textarea_reg = /^[a-zA-Z$ &+, :;=#|'"\\\[\]. ^()%!{}-]{1,1000000}$/;
var phone_reg = /^[{0-9}$&+, :;=@#|'"\\\[\]. ^()%!{}-]{6,2000}$/;
var email_reg = /^[\w._~`!@#$%^&\-=\+\\|\[\]'";:.,]+@[\w]+\.[a-z.]{2,3}$/;

  /*
  * Volunteer Form
  */

  function elements_validate(elemen_id, param1, param2, param_range) {
    $(elemen_id).on('focusout', function() {
      $(elemen_id).siblings('p').removeClass('blank-text');
      validate(param1, elemen_id, param2, param_range, event);
    });

    $(elemen_id).on('focusin', function() {
      $(elemen_id).siblings('p').addClass('blank-text');
    });

    /* Submit Validations */
    $(".inside .submit").click(function(event) { 
     validate(param1, elemen_id, param2, param_range, event);
   });

    $(".search-form button").click(function(event) {
      validate('search', ".search-form input", '', '', 500, event);
    });

    $(".volunteer-form .w2linput.submit").click(function(event) { 
      validate(param1, elemen_id, param2, param_range, event);

      /* Dropdown list validation */
        if($('.dropdown-toggle').attr('title') == "Volunteer Languages") {
          $('.dropdown-toggle').parent().siblings('p').text('Please select volunteer languages.');

        } else {
        $('.dropdown-toggle').parent().siblings('p').text(' '); }

    });

    $(".question-form .w2linput.submit").click(function(event) { 
      validate(param1, elemen_id, param2, param_range, event);
    });


  }


  // Adding Error Message
  $('.site-inner .sf_field').append('<p>&nbsp;</p>');

   // First Name
   elements_validate("#sf_first_name", 'first name', name_reg, 100);

   // Last Name
   elements_validate("#sf_last_name", 'last name', name_reg, 100);

  // Phone Number
  elements_validate("#phone-number", 'phone number', phone_reg, 20);

  // Email
  elements_validate("#sf_email", 'email', email_reg, 50);

  // Country
  elements_validate("#sf_country", 'country', name_reg, 100);

  //Volunteer Skills
  elements_validate("textarea[placeholder='Volunteer Professional Skills']", 'volunteer skills', textarea_reg, 500);

  //Volunteer Comments
  elements_validate("textarea[placeholder='Volunteer Comments']", 'volunteer comments', textarea_reg, 500);

  //Volunteer Comments
  elements_validate("textarea[placeholder='Description']", 'description', textarea_reg, 500);


  $("textarea[placeholder='Volunteer Comments']").siblings('p').hide();

  $("textarea[placeholder='Description']").siblings('p').hide();

  // Search Form

  elements_validate(".search-form input[type='search']",'', name_reg, 100);


  /* subscribe form fields */
  //First Name
  elements_validate(".textwidget #sf_first_name", 'first name', name_reg, 100);

  // Email
  elements_validate(".textwidget #sf_email", 'email', email_reg, 50);


  /* Subscribe Validations */

  $(".textwidget .w2linput.submit").click(function(event) { 
    // First Name
    validate( 'first name',".textwidget #sf_first_name", name_reg, 100, event);
    // Email
    validate( 'email', ".textwidget #sf_email", email_reg, 50, event);
  });


/*
* Tabs Functionality for Accordion Plugin
*/

$('.tabs-nav').click(function(){
 var myEm = $(this).attr('aria-labelledby');
 var tabcontent = $('div.tabs-content').attr('aria-labelledby');
 $(this).addClass('ui-tabs-active');
 $(this).siblings('.tabs-nav').removeClass('ui-tabs-active');
 $('div.tabs-content[aria-labelledby = '+ $(this).attr('aria-labelledby') +']').css('display','block');
 $('div.tabs-content').not('.tabs-content[aria-labelledby = '+ $(this).attr('aria-labelledby') +']').css('display','none');
});

  // Scroll (in pixels) after which the "To Top" link is shown
  var offset = 300,
    //Scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //Duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //Get the "To Top" link
    $back_to_top = $('.to-top');

  //Visible or not "To Top" link
  $(window).scroll(function(){
    ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('top-is-visible') : $back_to_top.removeClass('top-is-visible top-fade-out');
    if( $(this).scrollTop() > offset_opacity ) { 
      $back_to_top.addClass('top-fade-out');
    }
  });

  //Smoothy scroll to top
  $back_to_top.on('click', function(event){
    event.preventDefault(event);
    $('body,html').animate({
      scrollTop: 0 ,
    }, scroll_top_duration
    );
  });

  /* Multi-select Dropdown */
  $('.sf_type_multi-select').children('select').addClass('selectpicker');
  $('.sf_type_multi-select').children('select').attr('title','Volunteer Languages');



  $('ul.dropdown-menu a').parent().click(function(){
    console.log('clickekdie');
    $(this).addClass('fa-check');
  });

});
  /* Document ready ends here */

// gallery page1tab
var $tabs_li = $("#tabs li");
$(".page-template-page-gallery .entry-content").addClass("tab-detail");
$tabs_li.on('click', function() {
 var index = $(this).index();
 var child = index+1;
 $tabs_li.removeClass('active');
 $(this).addClass('active');
 $(".tabs .tab-detail").hide();
 $(".tabs .tab-detail:nth-child("+child+")").show();
});

var $research_tabs = $("#research-tabs li");
$research_tabs.on('click', function() {
 var index = $(this).index();
 var child = index;
 $research_tabs.removeClass('active');
 $(this).addClass('active');
 $(".tabs .tab-detail").hide();
 $(".tabs .tab-detail:nth-child("+ child +")").show();
});


/*Program detail Page animation*/
var $program_desc = $('.program-desc');
var section_height = $program_desc.offset().top;
if($(window).width() > 480) {
 section_height = section_height + 250;
} else {
  section_height = section_height + 100;

  /*Pagination on mobile*/

  $('.pagination-next').children('a').text('»');
  $('.pagination-previous').children('a').text('«');

}

$(this).scroll(function() {
  var window_height = $(window).scrollTop() + $(window).height();
  if(window_height > section_height){
    $program_desc.addClass("program-visible");
    $program_desc.addClass("active");
  }
});

})(jQuery);

