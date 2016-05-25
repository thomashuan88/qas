
//========================= Phone Number telInput===============================================
  var phone_Input = $("#phone_display"),
  phone_errorMsg = $("#phone-error-msg"),
  phone_validMsg = $("#phone-valid-msg");

// initialise plugin
phone_Input.intlTelInput({
    // geoIpLookup: function(callback) {
    //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    //     var countryCode = (resp && resp.country) ? resp.country : "";
    //     callback(countryCode);
    //   });
    // },
    initialCountry: "my",
    // nationalMode: false,
    // numberType: "MOBILE",
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    // preferredCountries: ['cn', 'jp'],
    separateDialCode: true,
    utilsScript: "../assets/js/vendor/intl-tel-input/build/js/utils.js"
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
    // geoIpLookup: function(callback) {
    //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    //     var countryCode = (resp && resp.country) ? resp.country : "";
    //     callback(countryCode);
    //   });
    // },
    initialCountry: "my",
    // nationalMode: false,
    // numberType: "MOBILE",
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    // preferredCountries: ['cn', 'jp'],
    separateDialCode: true,
    utilsScript: "../assets/js/vendor/intl-tel-input/build/js/utils.js"
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

// ============================ Lock / Unlock Form =========================================
var form_lock = true;

$(document).ready(function() {

    $("#credentials :input").change(function(){
        var flag = 0;
        if (form_lock == true){

            $("#credentials :input[name!='leader']").each(function(){
                if($(this).val() == ""){
                    flag = 1;
                }
            })

            if(flag==0){
                unlock_form();
            } else {
                lock_form();
            }
        }
    })

    var gen_pass = randomPassword();
    $("#password").val(gen_pass);

    $("#uname").change(function(){
    	var name = $("#uname").val();
    	$("#email").val(name+"@bexcel.com");
    })

    $("#profile :input").prop("disabled", true);
    $("#ids :input").prop("disabled", true);

});

$("#unlock").click(function(){
    var status = $("#unlock span").text();

    if(status == "Unlock"){
        unlock_form();
        form_lock = false;
    } else {
        lock_form();
        form_lock = true;

    }
    console.log(form_lock);
})

function unlock_form(){

        $("#profile").removeClass("lock-overlay");
        $("#ids").removeClass("lock-overlay");
        $("#unlock i").removeClass("fa-unlock").addClass("fa-lock");
        $("#unlock span").text("Lock");

        $("#profile :input").prop("disabled", false);
        $("#ids :input").prop("disabled", false);


}

function lock_form(){

        $("#profile").addClass("lock-overlay");
        $("#ids").addClass("lock-overlay");
        $("#unlock i").removeClass("fa-lock").addClass("fa-unlock");
        $("#unlock span").text("Unlock");

        $("#profile :input").prop("disabled", true);
        $("#ids :input").prop("disabled", true);

}

function randomPassword() {
    var chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHIJKLMNPRTUVWXYZ";
	var num ="23456789";
	var symbol = "@#$%^&+=.-_*";
    var pass = "";
	var a = Math.floor(Math.random() * num.length);
	pass += num.charAt(a);
	var b = Math.floor(Math.random() * symbol.length);
	pass += symbol.charAt(b);
    for (var x = 0; x <4; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
	var pass = pass.split('').sort(function(){return 0.5-Math.random()}).join('');

    return pass;
}
