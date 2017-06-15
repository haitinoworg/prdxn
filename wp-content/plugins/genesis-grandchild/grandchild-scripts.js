(function($) {

  /*
  * Document Ready Starts Here
  */
  $(document).ready(function() {

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


  $(".dntplgn_monthly_other_sum").hide();
  $( '.dntplgn_donate_monthly input[ name="a3" ]' ).click( function() {
    if ( $( this ).parent( '.dntplgn_donate_monthly' ).children( '#fourth_button' ).attr( 'checked' ) ) {
      $( this ).parent( '.dntplgn_donate_monthly' ).children( '.dntplgn_monthly_other_sum' ).addClass( 'checked' );
      $( this ).parent( '.dntplgn_donate_monthly' ).children( '.dntplgn_submit_button' ).click( function() {
        $( this ).parent( '.dntplgn_donate_monthly' ).children( 'input[ name="a3" ]' ).val( $( this ).parent( '.dntplgn_donate_monthly' ).children( '.dntplgn_monthly_other_sum' ).val() );
      })
    } else {
      $( this ).parent( '.dntplgn_donate_monthly' ).children( '.dntplgn_monthly_other_sum' ).removeClass( 'checked' );
      $( this ).parent( '.dntplgn_donate_monthly' ).children( '.dntplgn_monthly_other_sum' ).val( '' );
    }
  });

  $( '.dntplgn_form_wrapper' ).tabs();


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
        $('.more-content').click(function() {
          $(this).hide();
          $(this).siblings('span').show();
          $(this).siblings('.detailed-content').children('.excerpt-content').slideDown('fast', function(){
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
var validate = function(field, id, regx) {
  var input_value = $(id).val();
  var reg = regx;
  if(input_value != "") {
    if(!(reg.test(input_value))) {
      $(id).siblings('p').text('Please enter a valid ' + field);
      event.preventDefault();
    } else {
      $(id).siblings('p').text('');
    }
  } else {
    $(id).siblings('p').text('Please enter your ' + field);
    event.preventDefault();
  }

}

// Regex

var name_reg = /[a-zA-Z$&+,:;=@#|'"\\\[\]. ^()%!{}-]{1,100}/;
var textarea_reg = /[a-zA-Z$&+,:;=@#|'"\\\[\]. ^()%!{}-]{1,500}/;
var phone_reg = /[{0-9}$&+,:;=@#|'"\\\[\]. ^()%!{}-]{6,20}/;
var email_reg = /[\w._~`!@#$%^&\-=\+\\|\[\]'";:.,]+@[\w]+\.[a-z.]{1,3}$/;

  /*
  * Volunteer Form
  */

  function elements_validate(elemen_id, param1, param2) {
    $(elemen_id).on('focusout', function() {
      validate(param1, elemen_id, param2);
    });

    $(elemen_id).on('focusin', function() {
      $(elemen_id).siblings('p').text('');
    });

    $(".w2linput.submit").click(function(event) { 
     validate(param1, elemen_id, param2);
   });
  }

  // Adding Error Message
  $('#sf_first_name, #sf_last_name, #phone-number, #sf_email, #sf_country, .w2linput.textarea').parent().append('<p>&nbsp;</p>');

   // First Name
   elements_validate("#sf_first_name", 'first name', name_reg);

   // Last Name
   elements_validate("#sf_last_name", 'last name', name_reg);

  // Phone Number
  elements_validate("#phone-number", 'phone number', phone_reg);

  // Email
  elements_validate("#sf_email", 'email', email_reg);

  // Country
  elements_validate("#sf_country", 'country', name_reg);

  // Search Form

  elements_validate(".search-form input[type='search']",'', name_reg);


  $(".search-form button").click(function(event) {
    validate('search', ".search-form input", '');
  });


// $('.sf_type_multi-select').append('<span>Select</span>');

// $('.sf_type_multi-select').click(function(){
//   $(this).children('span').toggleClass('disablespan');
// });


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



var $program_desc = $('.program-desc');
var section_height = $program_desc.offset().top;
if($(window).width() > 480) {
 section_height = section_height + 250;
} else {
  section_height = section_height + 100;
}

$(this).scroll(function() {
  var window_height = $(window).scrollTop() + $(window).height();
  if(window_height > section_height){
    $program_desc.addClass("program-visible");
    $program_desc.addClass("active");
  }
});

})(jQuery);

