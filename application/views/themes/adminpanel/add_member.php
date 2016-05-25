<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>
<link href="<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/css/intlTelInput.css" rel="stylesheet" >

<?php $this->load->view('generic/flash_error'); ?>
<?php $tab = (isset($_GET['tab'])) ? $_GET['tab'] : ""; ?>

<style>

 .lock-overlay {
    opacity:0.3;
    background:#ffffff;
    width:100%;
    height:100%;
}
</style>

<div class="col-md-10 col-md-offset-1">
    <?php print form_open('adminpanel/add_member/add', array('id' => 'add_user_form')) ."\r\n"; ?>

	<div class="panel panel-default">
	    <div class="panel-heading">
			<?php print $this->lang->line('add_user')?>
			<div class="pull-right">

				<button type="submit" name="add_user_submit" id="add_user_submit" class="btn btn-default js-btn-loading pd-r-5" data-loading-text="Adding..."><i class="fa fa-user-plus pd-r-5"></i> Save User</button>
                <button type="button" name="unlock" id="unlock" class="btn btn-default js-btn-loading" data-loading-text="Adding..." ><i class="fa fa-unlock pd-r-5"></i><span>Unlock</span></button>

            </div>

        <div class="clearfix"></div>
		</div>
	    <div class="panel-body">
		<div class="row">

			<div class="col-xs-12">
				<div class="tabbable tabs-left">
					<ul class="nav nav-tabs">
						<li class="<?php echo ($tab == '')? 'active' : ''; ?>"><a href="#credentials" data-toggle="tab"><?php print $this->lang->line('user_details'); ?></a></li>
						<li class="<?php echo ($tab == 'profile') ? 'active' : ''; ?>"><a href="#profile" data-toggle="tab"><?php print $this->lang->line('user_profile'); ?></a></li>
						<li class="<?php echo ($tab == 'ids') ? 'active' : ''; ?>"><a href="#ids" data-toggle="tab"><?php print $this->lang->line('user_ids'); ?></a></li>
					</ul>
					<div class="tab-content ">

						<div class="tab-pane <?php echo ($tab == '') ? 'active' : ''; ?> picColor" id="credentials">
							<div class="col-sm-10 ">
								<div class="row ">
									<div class="col-md-6">
										<div class="form-group">
											<label for="username"><?php print $this->lang->line('username'); ?></label>
                                            <label style="color:red; font-size:14px;">*</label>

											<input type="text" class="form-control " id="username" name="username" placeholder="<?php print $this->lang->line('username'); ?>"
                                            value="<?php print $this->session->flashdata('username'); ?>"
                                            data-parsley-trigger="change keyup"
                                            data-parsley-pattern="^[a-zA-Z0-9_.-]+$"
                                            data-parsley-minlength="6"
                                            data-parsley-maxlength="20"
                                            data-parsley-errors-messages-disabled
                                            required>
											<label style="color:#9C9696; font-size:12px;">min 6 characters. symbol allow(._-). no space</label>
										</div>
										<div class="form-group">
											<label for="password"><?php print $this->lang->line('password'); ?></label>
                                            <label style="color:red; font-size:14px;">*</label>
											<input type="text" name="password" id="password" class="form-control"
                                            value="<?php print $this->session->flashdata('password'); ?>"
                                            data-parsley-pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){6,20}$"
                                            data-parsley-trigger="change keyup"
                                            data-parsley-minlength="6"
                                            data-parsley-maxlength="20"
                                            data-parsley-errors-messages-disabled
                                            required>
											<label style="color:#9C9696; font-size:12px;">min 6 characters, contain uppercase, alphanumeric and symbol("@#$%^&+=.-_*). eg. qw#e3r </label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="email"><?php print $this->lang->line('email_address'); ?></label>
                                            <label style="color:red; font-size:14px;">*</label>
											<input type="text" class="form-control" id="email" name="email"
                                             placeholder="<?php print $this->lang->line('email_address'); ?>"
                                             value="<?php print $this->session->flashdata('email'); ?>"
                                             data-parsley-type="email"
                                             data-parsley-trigger="change keyup"
                                             data-parsley-maxlength="255"
                                             data-parsley-errors-messages-disabled
                                             required>
											<label style="color:#9C9696; font-size:12px;">eg. johnDoe@bexcel.com</label>
										</div>
										<div class="form-group">
											<label for="leader"><?php print $this->lang->line('report_to'); ?></label>
											<select class="form-control" id="leader"  name="leader">
												<option style="display:none;" value="<?php print $this->session->flashdata('leader'); ?>" selected><?php print $this->session->flashdata('leader'); ?></option>
												<?php foreach($leaders as $leader) {?>
												<option value="<?php echo $leader->username; ?>"><?php echo $leader->username; ?></option>
											<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label for="role"><?php print $this->lang->line('role'); ?></label>
                                            <label style="color:red; font-size:14px;">*</label>
											<select class="form-control" id="role" name="role" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
                                                <option value=" ">ffff</option>
                                                <option style="display:none;" value="<?php print $this->session->flashdata('role'); ?>" selected><?php print $this->session->flashdata('role'); ?></option>
												<?php foreach($roles as $role) {?>
												<option value="<?php print $role->role_name; ?>"><?php print $role->role_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane <?php echo ($tab == 'profile') ? 'active' : ''; ?> lock-overlay" id="profile" >
	 						<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-6">
										<div class="col-sm-12 form-group">
											<label for="real_name"><?php print $this->lang->line('full_name'); ?></label>
											<input type="text" name="real_name" id="real_name" class="form-control" value="<?php print $this->session->flashdata('real_name'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="nickname"><?php print $this->lang->line('nickname'); ?></label>
											<input type="text" name="nickname" id="nickname" class="form-control" value="<?php print $this->session->flashdata('nickname'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="dob"><?php print $this->lang->line('dob'); ?></label>
											<input type="text" name="dob" id="dob" class="form-control datepicker" value="<?php print $this->session->flashdata('dob'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="phone"><?php print $this->lang->line('phone'); ?></label>
											<input type="tel"  style="width :100%" name="phone" id="phone"class="form-control"
                                            value="<?php print $this->session->flashdata('phone'); ?>"
                                            data-parsley-trigger="change keyup"

                                            data-parsley-errors-messages-disabled
                                            >
                                            <span id="valid-msg" class="hide">✓ Valid</span>
                                            <span id="error-msg" class="hide">Invalid number</span>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="col-sm-12 form-group">
											<label for="emergency_contact"><?php print $this->lang->line('emergency_contact'); ?></label>
											<input type="text" name="emergency_contact" id="emergency_contact" class="form-control" value="<?php print $this->session->flashdata('emergency_contact'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="emergency_name"><?php print $this->lang->line('emergency_name'); ?></label>
											<input type="text" name="emergency_name" id="emergency_name" class="form-control" value="<?php print $this->session->flashdata('emergency_name'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="relationship"><?php print $this->lang->line('relationship'); ?></label>
											<select name="relationship" id="relationship" class="form-control">
                                                <option style="display:none;" value="<?php print $this->session->flashdata('relationship'); ?>" selected><?php print $this->session->flashdata('relationship'); ?></option>
                                                <option value="family">Children</option>
												<option value="family">Friends</option>
												<option value="family">Parents</option>
												<option value="family">Relative</option>
												<option value="family">Spouse</option>
												<option value="family">Siblings</option>
												<option value="family">Others</option>
											</select>
										</div>
										<!-- <div class = "col-sm-3 form-group pull-right">
											<button type="submit" class="btn btn-primary js-btn-loading" >Save</button>
										</div> -->
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane <?php echo ($tab == 'ids') ? 'active' : ''; ?> lock-overlay" id="ids">
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-6">
										<div class="col-sm-12 form-group">
											<label for="windows_id">Windows ID</label>
											<input type="text" name="windows_id" id="windows_id" class="form-control" value="<?php print $this->session->flashdata('windows_id'); ?>" >
										</div>
										<div class="col-sm-12 form-group">
											<label for="tb_lp_id">TB LP ID</label>
											<input type="text" name="tb_lp_id" id="tb_lp_id" class="form-control" value="<?php print $this->session->flashdata('tb_lp_id'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="tb_lp_name">TB LP Name</label>
											<input type="text" name="tb_lp_name" id="tb_lp_name" class="form-control" value="<?php print $this->session->flashdata('tb_lp_name'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="sy_lp_id">SY LP ID</label>
											<input type="text" name="sy_lp_id" id="sy_lp_id" class="form-control" value="<?php print $this->session->flashdata('sy_lp_id'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="sy_lp_name">SY LP Name</label>
											<input type="text" name="sy_lp_name" id="sy_lp_name" class="form-control" value="<?php print $this->session->flashdata('sy_lp_name'); ?>">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="col-sm-12 form-group">
											<label for="tb_bo">TB BO</label>
											<input type="text" name="tb_bo" id="tb_bo" class="form-control" value="<?php print $this->session->flashdata('tb_bo'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="gd_bo">GD BO</label>
											<input type="text" name="gd_bo" id="gd_bo" class="form-control" value="<?php print $this->session->flashdata('gd_bo'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="keno_bo">KENO BO</label>
											<input type="text" name="keno_bo" id="keno_bo" class="form-control" value="<?php print $this->session->flashdata('keno_bo'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="rtx">RTX</label>
											<input type="text" name="rtx" id="rtx" class="form-control" value="<?php print $this->session->flashdata('rtx'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="cyber_roam">Cyber Roam</label>
											<input type="text" name="cyber_roam" id="cyber_roam" class="form-control" value="<?php print $this->session->flashdata('cyber_roam'); ?>">
										</div>
										<!-- <div class = "col-sm-3 form-group pull-right">
											<button type="submit" class="btn btn-primary js-btn-loading" >Save</button>
										</div> -->
									</div>
								</div>
								<?php print form_close() ."\r\n"; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	    </div>
	</div>

</div>
<script src="<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/js/intlTelInput.js"></script>



<script type="text/javascript">

// $("#phone").intlTelInput({
//       // allowDropdown: false,
//       // autoHideDialCode: false,
//       // autoPlaceholder: false,
//       // dropdownContainer: "body",
//       // excludeCountries: ["us"],
//       geoIpLookup: function(callback) {
//         $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
//           var countryCode = (resp && resp.country) ? resp.country : "";
//           callback(countryCode);
//         });
//       },
//       initialCountry: "auto",
//       // nationalMode: false,
//       // numberType: "MOBILE",
//       // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
//       // preferredCountries: ['cn', 'jp'],
//       separateDialCode: true,
//       utilsScript: "<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/js/utils.js"
//     });

    var telInput = $("#phone"),
  errorMsg = $("#error-msg"),
  validMsg = $("#valid-msg");

// initialise plugin
telInput.intlTelInput({
    geoIpLookup: function(callback) {
      $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "";
        callback(countryCode);
      });
    },
    initialCountry: "auto",
    // nationalMode: false,
    // numberType: "MOBILE",
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    // preferredCountries: ['cn', 'jp'],
    separateDialCode: true,
    utilsScript: "<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/js/utils.js"
});

var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
};

// on blur: validate
telInput.blur(function() {
  reset();
  if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
        telInput.removeClass("parsley-error");

        telInput.addClass("parsley-success");

    } else {
      telInput.removeClass("parsley-success");
      telInput.addClass("parsley-error");

    }
  }
});

// on keyup / change flag: reset
telInput.on("keyup change", reset);

    $("#emergency_contact").intlTelInput({
          // allowDropdown: false,
          // autoHideDialCode: false,
          // autoPlaceholder: false,
          // dropdownContainer: "body",
          // excludeCountries: ["us"],
          geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
            });
          },
          initialCountry: "auto",
          // nationalMode: false,
          // numberType: "MOBILE",
          // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
          // preferredCountries: ['cn', 'jp'],
          separateDialCode: true,
          utilsScript: "<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/js/utils.js"
        });

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

    $("#username").change(function(){
    	var name = $("#username").val();
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

</script>
