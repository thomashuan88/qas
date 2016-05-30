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

				<button type="submit" name="add_user_submit" id="add_user_submit" class="btn btn-default js-btn-loading pd-r-5" data-loading-text="Adding..."><i class="fa fa-user-plus pd-r-5"></i> <?php print $this->lang->line('save_user'); ?></button>
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

											<input type="text" class="form-control " id="uname" name="uname" placeholder="<?php print $this->lang->line('username'); ?>"
                                            value="<?php print $this->session->flashdata('uname'); ?>"
                                            data-parsley-trigger="change keyup"
                                            data-parsley-pattern="^[a-zA-Z0-9_.-]+$"
                                            data-parsley-minlength="6"
                                            data-parsley-maxlength="20"
                                            data-parsley-errors-messages-disabled
                                            required>
											<label style="color:#9C9696; font-size:12px;">min 6 characters. symbol allow(._-). no space</label>
										</div>
                                        <div class="form-group">
											<label for="email"><?php print $this->lang->line('email_address'); ?></label>
                                            <label style="color:red; font-size:14px;">*</label>
											<input type="email" class="form-control" id="email" name="email"
                                             placeholder="<?php print $this->lang->line('email_address'); ?>"
                                             value="<?php print $this->session->flashdata('email'); ?>"
                                             data-parsley-type="email"
                                             data-parsley-trigger="change keyup"
                                             data-parsley-maxlength="255"
                                             data-parsley-errors-messages-disabled
                                             required>
											<label style="color:#9C9696; font-size:12px;">eg. johnDoe@bexcel.com</label>
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="leader"><?php print $this->lang->line('report_to'); ?></label>
											<select class="form-control" id="leader"  name="leader">
                                                    <option style="display:none;" value="<?php print $this->session->flashdata('leader'); ?>" selected><?php print $this->session->flashdata('leader'); ?></option>
												<?php foreach($leaders as $leader) {?>
												<option value="<?php echo $leader->username; ?>"><?php echo $leader->username; ?></option>
											<?php } ?>
											</select>
                                            <label style="color:#9C9696; font-size:12px;"></label>

										</div>
										<div class="form-group">
											<label for="role"><?php print $this->lang->line('role'); ?></label>
                                            <label style="color:red; font-size:14px;">*</label>
											<select class="form-control" id="role" name="role" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
                                                <option value="<?php print Settings_model::$db_config['system_role']; ?>"selected><?php print Settings_model::$db_config['system_role']; ?></option>
                                                <option style="display:none;" value="<?php print $this->session->flashdata('role'); ?>"><?php print $this->session->flashdata('role'); ?></option>
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
											<input type="text" name="phone_display" id="phone_display"class="form-control" value="<?php print $this->session->flashdata('phone'); ?>">
                                            <input type="hidden" name="phone" id="phone"class="form-control" value="<?php print $this->session->flashdata('phone'); ?>">
                                            <span id="phone-valid-msg" class="hide"><i class="fa fa-check"></i></span>
                                            <span id="phone-error-msg" class="hide"><i class="fa fa-times"></i></span>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="col-sm-12 form-group">
											<label for="emergency_contact"><?php print $this->lang->line('emergency_contact'); ?></label>
											<input type="text" name="emergency_contact_display" id="emergency_contact_display" class="form-control" value="<?php print $this->session->flashdata('emergency_contact'); ?>">
                                            <input type="hidden" name="emergency_contact" id="emergency_contact" class="form-control" value="<?php print $this->session->flashdata('emergency_contact'); ?>">
                                            <span id="emergency-valid-msg" class="hide"><i class="fa fa-check"></i></span>
                                            <span id="emergency-error-msg" class="hide"><i class="fa fa-times"></i></span>
                                        </div>
										<div class="col-sm-12 form-group">
											<label for="emergency_name"><?php print $this->lang->line('emergency_name'); ?></label>
											<input type="text" name="emergency_name" id="emergency_name" class="form-control" value="<?php print $this->session->flashdata('emergency_name'); ?>">
										</div>
										<div class="col-sm-12 form-group">
											<label for="relationship"><?php print $this->lang->line('relationship'); ?></label>
											<select name="relationship" id="relationship" class="form-control">
                                                <option style="display:none;" value="<?php print $this->session->flashdata('relationship'); ?>" selected><?php print $this->session->flashdata('relationship'); ?></option>
                                                <option value="children"><?php print $this->lang->line('children'); ?></option>
                                                <option value="friends"><?php print $this->lang->line('friends'); ?></option>
                                                <option value="parents"><?php print $this->lang->line('parents'); ?></option>
                                                <option value="relative"><?php print $this->lang->line('relative'); ?></option>
                                                <option value="spouse"><?php print $this->lang->line('spouse'); ?></option>
                                                <option value="siblings"><?php print $this->lang->line('siblings'); ?></option>
                                                <option value="others"><?php print $this->lang->line('others'); ?></option>
											</select>
										</div>
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
<script src="<?php print base_url(); ?>assets/js/adminpanel/add_member.js"></script>
<script>
var email ='<?php print Settings_model::$db_config["predefined_email"]; ?>';
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

    // var gen_pass = randomPassword();
    // $("#password").val(gen_pass);

    $("#uname").change(function(){
    	var name = $("#uname").val();
    	$("#email").val(name+email);
    })

    $("#profile :input").prop("disabled", true);
    $("#ids :input").prop("disabled", true);

});
</script>
