
$(function(){
    $.datepicker.setDefaults({
        beforeShow: function ( input, inst ) {
            setTimeout(function(){
                inst.dpDiv.css({
                    zIndex: 10000
                });
            })
        }
    });
    $('#dob').datepicker({
        format: 'yyyy-mm-dd',
    });
});

//========================= Phone Number telInput===============================================
  var phone_Input = $("#phone_display"),
  phone_errorMsg = $("#phone-error-msg"),
  phone_validMsg = $("#phone-valid-msg");

// initialise plugin
phone_Input.intlTelInput({
    initialCountry: "my",
    separateDialCode: true,
    utilsScript: "/assets/js/vendor/intl-tel-input/build/js/utils.js"
});
var reset = function() {
  phone_Input.removeClass("error");
  phone_errorMsg.addClass("hide");
  phone_validMsg.addClass("hide");
};

// on blur: validate
phone_Input.blur(function() {
  reset();
  if ($.trim(phone_Input.val())) {
    if (phone_Input.intlTelInput("isValidNumber")) {
        phone_Input.removeClass("parsley-error");
        phone_Input.addClass("parsley-success");
        phone_validMsg.removeClass("hide");


    } else {
      phone_Input.removeClass("parsley-success");
      phone_Input.addClass("parsley-error");
      phone_errorMsg.removeClass("hide");


    }
  }
});

// on keyup / change flag: reset
phone_Input.on("keyup change", reset);

// =================Emergency contact telInput=======================================
  var emergency_Input = $("#emergency_contact_display"),
  emergency_errorMsg = $("#emergency-error-msg"),
  emergency_validMsg = $("#emergency-valid-msg");

// initialise plugin
emergency_Input.intlTelInput({

    initialCountry: "my",
    separateDialCode: true,
    utilsScript: "/assets/js/vendor/intl-tel-input/build/js/utils.js"
});

var reset = function() {
  emergency_Input.removeClass("error");
  emergency_errorMsg.addClass("hide");
  emergency_validMsg.addClass("hide");
};

// on blur: validate
emergency_Input.blur(function() {
  reset();
  if ($.trim(emergency_Input.val())) {
    if (emergency_Input.intlTelInput("isValidNumber")) {
        emergency_Input.removeClass("parsley-error");

        emergency_Input.addClass("parsley-success");
        emergency_validMsg.removeClass("hide");

    } else {
      emergency_Input.removeClass("parsley-success");
      emergency_Input.addClass("parsley-error");
      emergency_errorMsg.removeClass("hide");

    }
  }
});

// on keyup / change flag: reset
emergency_Input.on("keyup change", reset);

// ==============================Before Submit =========================================

$("form").submit(function() {
  $("#phone").val($("#phone_display").intlTelInput("getNumber"));
  $("#emergency_contact").val($("#emergency_contact_display").intlTelInput("getNumber"));

});
