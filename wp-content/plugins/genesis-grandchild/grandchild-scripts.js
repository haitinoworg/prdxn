(function( $ ) {

    // Header Height
    var headerHeight = $('.site-header').outerHeight();
    console.log(headerHeight);
    $('.site-inner').css('padding-top',headerHeight + 'px');


  })( jQuery );

