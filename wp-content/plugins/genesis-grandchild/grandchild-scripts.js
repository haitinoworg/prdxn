(function( $ ) {

 $(document).ready(function(){
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
  $('#sf_first_name, #sf_last_name, #phone-number, #sf_email, .w2linput.textarea').parent().append('<p>&nbsp;</p>');

   // First Name
   $('#sf_first_name').on('focusout',function() {
    validate("name", "#sf_first_name", name_reg);
  });

   $('#sf_first_name').on('focusin',function() {
    $('#sf_first_name').siblings('p').text('');
  });

   // Last Name
   $('#sf_last_name').on('focusout',function() {
    validate("name", "#sf_last_name", name_reg);
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


  // Skills
  $('.w2linput.textarea').on('focusout',function() {
    validate("country", ".w2linput.textarea", textarea_reg);
  });

  $('#sf_country').on('focusin',function() {
    $('.w2linput.textarea').siblings('p').text('');
  });



  // Submit Button
  $(".w2linput.submit").click(function(event){
    validate("name", "#sf_first_name", name_reg);
    validate("name", "#sf_last_name", name_reg);
    validate("email", "#sf_email", email_reg);
    validate("country", "#sf_country", name_reg);
    validate("phone number", "#phone-number", phone_reg);
    validate("country", ".w2linput.textarea", textarea_reg);

  });

});

})(jQuery);

