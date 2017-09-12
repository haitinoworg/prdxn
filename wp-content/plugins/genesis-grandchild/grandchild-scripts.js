(function( $ ) {

    // Header Height
    var headerHeight = $('.site-header').height();
    $('.site-inner').css('margin-top', headerHeight + 'px');

    // Header Responsive Scroll
    $('.responsive-menu-icon').click(function() { 
      $('body').toggleClass('body-overflow');
    });

    // Gallery Lightbox
    var $gallerySec = $('.gallery-section');
    $gallerySec.hide();
    if($gallerySec.find('*').hasClass('grid-item')) {
      $gallerySec.show(); 
      $gallerySec.addClass('gallery-modal');
      $('body').addClass('body-overflow');
    }

    $('.close-lightbox').click( function() {
      $gallerySec.hide();
      $('body').removeClass('body-overflow');
    });

    $('.cws-pagination').children('span').remove();

    // Site Logo
    $('.site-title').children('a').attr("title",'Haiti Now');

    // Ajax Load More For movies page
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
      var newPage1 = page1 + 1;
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
          thatelement.data("page", newPage1);
          $('#loadmore-data').append( response );

          if( newPage1 == total) {
            $loadmore.hide();
          }
        }
      });
    });

    // Ajax Load More Functionality for books
    var $loadmore_books = $(".loadmore-books");
    var page2 = $loadmore_books.data('page'),
    totalpages = $loadmore_books.data('totalcount');
    if( page2 == totalpages) {
      $loadmore_books.hide();
    }

    $( document ).on( 'click', '.loadmore-books', function() {
      var thatelement2 = $(this);
      var page1= thatelement2.data('page');
      var totalBooks = thatelement2.data('totalcount');
      var newPage2 = page2 + 1;
      var ajaxurl2 = thatelement2.data('url');
      var typePost2 = thatelement2.data('post');

      $.ajax({
        url: ajaxurl2,
        type: 'post',
        data: {
          page: page2,
          books: typePost2,
          action: 'ajax_load_more_books'
        },
        error: function( response ) {
        },
        success: function( response ) {
          thatelement2.data("page", newPage2);

          $('#load-books').append( response );

          if( newPage2 == totalBooks) {
            $loadmore_books.hide();
          }
        }
      });
    });

      /**
     *  This function is used for form validations.
     *  @param  {String} field  input field type like name, email, etc.
     *  @param  {String} id   Input field id
     *  @param  {String} regx   Regular expression
     *  @param  {Number} range   Maximum allowed range into specific inputs
     *  @param  {Object} btn_event  button event to trigger or prevent click event.
     */
    var validate = function(field, id, regx, range, btn_event) {
      var input_value = $(id).val();
      var reg = regx;

      if(input_value != "" && input_value != null) {
        if(!(reg.test(input_value)) && (input_value.length <= range)) {
          $(id).siblings('p').removeClass('blank-text');
          $(id).siblings('p').text('Please enter a valid ' + field + '.');
          btn_event.preventDefault(btn_event);      
        } else if( input_value.length > range  ) {
          $(id).siblings('p').removeClass('blank-text');
          $(id).siblings('p').text('Maximum limit is ' + range + ' characters.');
          btn_event.preventDefault(btn_event); 
        } else {
          $(id).siblings('p').addClass('blank-text');
        }

      } else {
        $(id).siblings('p').text('Please enter your ' + field + '.');
        btn_event.preventDefault(btn_event);
      }

    };


    /**
     * Regex
     * Regex type: name regex, textarea regex, phone regex, email regex.
     */
    var name_reg = /^[a-zA-Z0-9$ &+, :;=^@#|'"\\\[\]. ^()%!{}-]{1,100}$/;
    var textarea_reg = /^[a-zA-Z0-9$ &+, :;=#|'"\\\[\]. ^()%!{}-]{1,500}$/;
    var phone_reg = /^[{0-9}$&+, :;=@#|'"\\\[\]. ^()%!{}-]{6,20}$/;
    var email_reg = /^[\w._~`!@#$%^&\-=\+\\|\[\]'";:.,]+@[a-zA-Z\w-_]+\.[a-zA-Z.]{2,3}$/;
    var search_reg = /^[a-zA-Z0-9]{1,500}$/;

    /**
     *  This function passes argument into validate() 
     *  function for focus-out and focus-in of input fields.
     *  @param  {String} elemen_id   input field id
     *  @param  {String} param1   Input field type
     *  @param  {String} param2   Regular expression
     *  @param  {Number} param_range  Maximum allowed range into specific inputs
     */
    
    function elements_validate(elemen_id, param1, param2, param_range) {
      $(elemen_id).on('focusout', function() {
        $(elemen_id).siblings('p').removeClass('blank-text');
        validate(param1, elemen_id, param2, param_range, event);
      });

      $(elemen_id).on('focusin', function() {
        $(elemen_id).siblings('p').addClass('blank-text');
      });

    }

   /**
    * Fields Validations
    * Input Fields Name: First name, Last Name, Email, Country, Volunteer Skills,
    * Volunteer Comments, Contact Description
    */
    $('.site-inner .sf_field').append('<p>&nbsp;</p>');
    $('.widget .sf_field').append('<p>&nbsp;</p>');
    $('.site-inner .sf_field_description').children('p').text('Maximum limit is 500 characters.');
    $('.site-inner .sf_field_00NA000000723E0').children('p').text('Maximum limit is 500 characters.');
    elements_validate("#sf_first_name", 'first name', name_reg, 100);
    elements_validate("#sf_last_name", 'last name', name_reg, 100);
    elements_validate("#phone-number", 'phone number', phone_reg, 20);
    elements_validate("#sf_email", 'email', email_reg, 50);
    elements_validate("#sf_country", 'country', name_reg, 100);
    elements_validate("textarea[placeholder='Volunteer Professional Skills *']", 'volunteer skills', textarea_reg, 500);
    elements_validate("textarea[placeholder='Volunteer Comments *']", 'volunteer comments', textarea_reg, 500);
    elements_validate("textarea[placeholder='Description *']", 'description', textarea_reg, 500);
    elements_validate(".search-form input[type='search']",'', search_reg, 100);

    /**
     * Subscribe form fields 
     * Fields Name: First Name, Email
     */
    elements_validate(".textwidget #sf_first_name", 'first name', name_reg, 100); 
    elements_validate(".textwidget #sf_email", 'email', email_reg, 50);

    /**
     * Subscribe form Submition
     * Fields name: First name, Email 
     */
    $(".textwidget .w2linput.submit").click(function(event) { 
      validate( 'first name',".textwidget #sf_first_name", name_reg, 100, event);
      validate( 'email', ".textwidget #sf_email", email_reg, 50, event);
    });


    /**
     * Contact us form Submition
     * Fields name: First name, Last name, Email, description
     */
    $(".inside .w2linput.submit").click(function(event) { 
      validate( 'first name', ".inside #sf_first_name", name_reg, 100, event);
      validate( 'last name', ".inside #sf_last_name", name_reg, 100, event);
      validate( 'email', ".inside #sf_email", email_reg, 50, event);
      validate('description', ".inside .textarea", textarea_reg, 500, event);
    });

    /**
     * Parnters form Submition
     *  Fields Name: First Name, Last Name, Email, Description
     */
    $(".page-template-page-sponsor .w2linput.submit").click(function(event) { 
      validate( 'first name', ".page-template-page-sponsor #sf_first_name", name_reg, 100, event);
      validate( 'last name', ".page-template-page-sponsor #sf_last_name", name_reg, 100, event);
      validate( 'email', ".page-template-page-sponsor #sf_email", email_reg, 50, event);
      validate('description', ".page-template-page-sponsor .textarea", textarea_reg, 500, event);
    });

    // Search form Submition  Field Name: Search
    $(".search-form input[type='submit']").click(function(event) {
      validate('search', ".search-form input[type='search']", search_reg, 500, event);
    });


    /** 
     * Questions form Submition 
     * Fields Name: First Name, Last Name, Email, Description
     */
    $(".question-form .w2linput.submit").click(function(event) { 
     validate( 'first name', ".page-template-page_donate #sf_first_name", name_reg, 100, event);
     validate( 'last name', ".page-template-page_donate #sf_last_name", name_reg, 100, event);
     validate( 'email', ".page-template-page_donate #sf_email", email_reg, 50, event);
     validate('description', ".page-template-page_donate .textarea", textarea_reg, 500, event);
    });

    /**
     * Volunteer form Submition
     * Fields Name: First name, Last name, Email, Country, Volunteer Skills,
     * Volunteer Comments, Volunteers Language - Dropdown list
     */
    $(".volunteer-form .w2linput.submit").click(function(event) { 
      validate( 'first name', ".volunteer-form #sf_first_name", name_reg, 100, event);
      validate( 'last name', ".volunteer-form #sf_last_name", name_reg, 100, event);
      validate( 'email', ".volunteer-form #sf_email", email_reg, 50, event);
      validate( 'country', ".volunteer-form #sf_country", name_reg, 100, event);
      validate('volunteer skills', "textarea[placeholder='Volunteer Professional Skills *']", textarea_reg, 500, event);
      validate('volunteer comments', "textarea[placeholder='Volunteer Comments *']", textarea_reg, 500, event);  

      var $dropdownTog = $('.dropdown-toggle');
      if($dropdownTog.attr('title') == "Volunteer Languages") {
        $dropdownTog.parent().siblings('p').text('Please select volunteer languages.');
        event.preventDefault(event);
      } else {
        $dropdownTog.parent().siblings('p').text(' '); 
      }

    });

    // gallery page1tab
    $(".page-template-page-gallery .entry-content").addClass("tab-detail");
    $("#tabs ul li").on('click', function() {
     var itemNum = $(this).index();
     var child = itemNum + 1;
     $(this).siblings('li').removeClass('active');
     $(this).addClass('active');
     $(".tabs .tab-detail").hide();
     if($(".tabs .tab-detail:nth-child("+ child +")").children('div').hasClass('listviewxxx')) {
      $('.listviewxxx .js-masonry').masonry( 'destroy' );
      $(".tabs .tab-detail:nth-child("+ child +")").show();
      $('.listviewxxx .js-masonry').masonry({ "itemSelector": "figure", "isOriginLeft": true, "isFitWidth": true });
   } else {
     $(".tabs .tab-detail:nth-child("+ child +")").show();
   }
    });

    $("#research-tabs ul li").on('click', function() {
      var itemNum = $(this).index();
      var child = itemNum;
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
      $(".tabs .tab-detail").hide();
      $(".tabs .tab-detail:nth-child("+ child +")").show();
    });


    // Scroll (in pixels) after which the "To Top" link is shown
    var offset = 300,
    offset_opacity = 1200,
    scroll_top_duration = 700,
    $back_to_top = $('.to-top');

    // Visible or not "To Top" link
    $(window).scroll(function(){
      ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('top-is-visible') : $back_to_top.removeClass('top-is-visible top-fade-out');
      if ( $(this).scrollTop() > offset_opacity ) { 
        $back_to_top.addClass('top-fade-out');
      }

    });


    // Smoothy scroll to top
    $back_to_top.on('click', function(event){
      event.preventDefault(event);
      $('body,html').animate({
        scrollTop: 0 ,
      }, scroll_top_duration
      );
    });


    // Program detail Page animation
    var $program_desc = $('.program-desc');
    if($program_desc.length > 0) {
      var section_height = $program_desc.offset().top;
      if($(window).width() > 480) {
       section_height = section_height + 250;
      } else {
        section_height = section_height + 100;
      }

      $(window).scroll(function() {
        var window_height = $(window).scrollTop() + $(window).height();
        if(window_height > section_height){
          $program_desc.addClass("program-visible");
          $program_desc.addClass("active");
        }
      });

    }

  // Multi-select Dropdown
  var $multiSelect = $('.sf_type_multi-select').children('select');
  $multiSelect.addClass('selectpicker');
  $multiSelect.attr('title','Volunteer Languages');

    // Dropdown Button
    $( "body" ).delegate( ".dropdown-toggle", "click", function() {
      var $dropdownOpen = $('.dropdown-menu.open');
      $('.check-mark').addClass('fa fa-check fa-1x');
      $dropdownOpen.css('min-height', '100%');
      $dropdownOpen.css('overflow', 'visible');
      $dropdownOpen.slideToggle();
      $('ul.dropdown-menu li:first-child').hide();
    });

  // Tabs Functionality for Accordion Plugin
  $('.tabs-nav').click(function() {
    var myEm = $(this).attr('aria-labelledby');
    var tabcontent = $('div.tabs-content').attr('aria-labelledby');
    $(this).addClass('ui-tabs-active');
    $(this).siblings('.tabs-nav').removeClass('ui-tabs-active');
    $('div.tabs-content[aria-labelledby = '+ $(this).attr('aria-labelledby') +']').show();
    $('div.tabs-content').not('.tabs-content[aria-labelledby = '+ $(this).attr('aria-labelledby') +']').hide();
  });


})( jQuery );

