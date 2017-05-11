(function( $ ) {

  // Header Height
  var headerHeight = $('.site-header').outerHeight();

  $('.site-inner').css('padding-top',headerHeight + 'px');


// form validation
var validate = function(field,id,regx) {
  var input_value = $(id).val();
  if(input_value != "") {
    var reg = regx;
    if(!(reg.test(input_value))) {
      $(id).siblings('p').text("Please enter a valid " + field);
      event.preventDefault();
    } else {
      $(id).siblings('p').text('');
    }
  } else {
    $(id).siblings('p').text("Please enter your " + field);
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
  // Adding Error Message
  $('#sf_first_name, #sf_last_name, #phone-number, #sf_email, #sf_country, .w2linput.textarea').parent().append('<p>&nbsp;</p>');

   // First Name
   $('#sf_first_name').on('focusout',function() {
    validate("first name", "#sf_first_name", name_reg);
  });

   $('#sf_first_name').on('focusin',function() {
    $('#sf_first_name').siblings('p').text('');
  });

   // Last Name
   $('#sf_last_name').on('focusout',function() {
    validate("last name", "#sf_last_name", name_reg);
  });

   $('#sf_last_name').on('focusin',function() {
    $('#sf_last_name').siblings('p').text('');
  });

  // Phone Number
  $('#phone-number').on('focusout',function() {
    validate("phone number", "#phone-number", phone_reg);
  });

  $('#phone-number').on('focusin',function() {
    $('#phone-number').siblings('p').text('');
  });

  // Email
  $('#sf_email').on('focusout',function() {
    validate("email", "#sf_email", email_reg);
  });

  $('#sf_email').on('focusin',function() {
    $('#sf_email').siblings('p').text('');
  });

  // Country
  $('#sf_country').on('focusout',function() {
    validate("country", "#sf_country", name_reg);
  });

  $('#sf_country').on('focusin',function() {
    $('#sf_country').siblings('p').text('');
  });



  // Submit Button
  $(".w2linput.submit").click(function(event){
    validate("name", "#sf_first_name", name_reg);
    validate("name", "#sf_last_name", name_reg);
    validate("email", "#sf_email", email_reg);
    validate("country", "#sf_country", name_reg);
    validate("phone number", "#phone-number", phone_reg);

  });


// gallery page tab
$("#tabs li").on('click',function(){
 $("#tabs li").removeClass('active');
 $(this).addClass('active');
 var index = $(this).index();
 var child = index+1;
 $(".tabs .tab-detail").css('display','none');
 $(".tabs .tab-detail:nth-child("+child+")").css('display','block');
});

var section_height = $('.program-desc').offset().top + 250;
$(this).scroll(function(){
  var x = $(this).scrollTop();

  var window_height = $(window).scrollTop() + $(window).height();
  if(window_height > section_height){
    $(".program-desc").css('visibility','visible');
    $(".program-desc").addClass("active");
  }
});


})(jQuery);



