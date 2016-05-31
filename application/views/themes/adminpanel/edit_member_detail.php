<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>
<link href="<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/css/intlTelInput.css" rel="stylesheet" >


    <?php $this->load->view('generic/flash_error'); ?>

        <?php $tab = (isset($_GET['tab'])) ? $_GET['tab'] : ""; ?>
<div class="container">
    <div class="row">
		<div class="col-xs-12">
		  <h3>Edit User</h3>
          <div class="col-xs-11">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <a href="<?php print base_url()?>/adminpanel/list_members?type=session" class="btn btn-default js-btn-loading" data-loading-text="Going Back.."><i class="fa fa-reply"></i> <?php print $this->lang->line('back'); ?></a>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="<?php print base_url() ."adminpanel/member_detail/".$member->user_id; ?>" >User Information</a></li>
                    </ul>


                <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="user_info">

                            <div class="tabbable tabs-left">
                				<ul class="nav nav-tabs">
                					<li class="<?php echo ($tab == '')? 'active' : ''; ?>"><a href="#details" data-toggle="tab"><?php print $this->lang->line('user_details'); ?></a></li>
                                    <li class="<?php echo ($tab == 'profile') ? 'active' : ''; ?>"><a href="#profile" data-toggle="tab"><?php print $this->lang->line('user_profile'); ?></a></li>
                					<li class="<?php echo ($tab == 'ids') ? 'active' : ''; ?>"><a href="#ids" data-toggle="tab"><?php print $this->lang->line('user_ids'); ?></a></li>
                					<!-- <li class="<?php echo ($tab == 'leave') ? 'active' : ''; ?>"><a href="#leave" data-toggle="tab"><?php print $this->lang->line('leave_details'); ?></a></li> -->
                                    <li class="<?php echo ($tab == 'remark') ? 'active' : ''; ?>"><a href="#remark" data-toggle="tab"><?php print $this->lang->line('remarks'); ?></a></li>
                                    <li class="<?php echo ($tab == 'password') ? 'active' : ''; ?>"><a href="#password" data-toggle="tab"><?php print $this->lang->line('password'); ?></a></li>
                				</ul>
            				<div class="tab-content active">
            					<div class="tab-pane <?php echo ($tab == '') ? 'active' : ''; ?>" id="details">
                                    <?php print form_open('adminpanel/edit_member_detail/save_details', array('id' => 'save_details_form', 'class' =>'form-confirm')) ."\r\n"; ?>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <input type="hidden" name="user_id" id="user_id" value="<?php print $member->user_id; ?>"  readonly>
                                            <div class="col-sm-6">
                                                <div class="col-sm-12 form-group">
                                                    <label for="username"><?php print $this->lang->line('username'); ?></label>
                                                    <input type="text" name="username" id="username" value="<?php print $member->username; ?>" class="form-control" <?php echo $permission['user_details']['disable_input'];?> readonly>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="real_name"><?php print $this->lang->line('full_name'); ?></label>
                                                    <input type="text" name="real_name" id="real_name" value="<?php print $member->real_name; ?>" class="form-control" <?php echo $permission['user_details']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="role"><?php print $this->lang->line('role'); ?></label>
                            						<select class="form-control" id="role" name="role" <?php echo $permission['user_details']['disable_input'];?>>
                            							<option style="display:none;" value="<?php print $member->role; ?>" selected><?php print $member->role; ?></option>
                            							<?php foreach($roles as $role) {?>
                            							<option value="<?php print $role->role_name; ?>"><?php print $role->role_name; ?></option>
                            							<?php } ?>
                            						</select>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="email"><?php print $this->lang->line('email_address'); ?></label>
                                                    <input type="email" name="email" id="email" value="<?php print $member->email; ?>" class="form-control" <?php echo $permission['user_details']['disable_input'];?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="col-sm-12 form-group">
                                                    <label for="leader"><?php print $this->lang->line('report_to'); ?></label>
                                                    <select class="form-control" id="leader"  name="leader" <?php echo $permission['user_details']['disable_input'];?>>
                                                        <option style="display:none;" value="<?php echo $member->leader; ?>" selected><?php echo $member->leader; ?></option>
                                                        <option value=""></option>
                                                        <?php foreach($leaders as $leader) {?>
                                                        <option value="<?php echo $leader->username; ?>"><?php echo $leader->username; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="status"><?php print $this->lang->line('status'); ?></label>
                                                    <select class="form-control" id="status"  name="status" <?php echo $permission['user_details']['disable_input'];?>>
                                                        <option style="display:none;" value="<?php print $member->status; ?>" selected><?php print $member->status; ?></option>
                                                        <option value="active"><?php print $this->lang->line('active'); ?></option>
                                                        <option value="inactive"><?php print $this->lang->line('inactive'); ?></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="windows_id">Windows ID</label>
                                                    <input type="text" name="windows_id" id="windows_id" value="<?php print $member->windows_id; ?>"  class="form-control" <?php echo $permission['user_details']['disable_input'];?>>
                                                </div>
                                                <div class = "col-sm-3 form-group pull-right">
                                                    <button type="submit" class="btn btn-success js-btn-loading" <?php echo $permission['user_details']['disable_input'];?>><i class="fa fa-floppy-o pd-r-5"></i><?php print $this->lang->line('save'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php print form_close() ."\r\n"; ?>
            					</div>
            					<div class="tab-pane <?php echo ($tab == 'profile') ? 'active' : ''; ?>" id="profile" >
                                    <div class="col-sm-10">
                                        <?php print form_open('adminpanel/edit_member_detail/save_profile', array('id' => 'save_profile_form' , 'class' =>'form-confirm')) ."\r\n"; ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="hidden" name="user_id" id="user_id" value="<?php print $member->user_id; ?>">
                                                <input type="hidden" name="username" id="username" value="<?php print $member->username; ?>">

                                                <div class="col-sm-12 form-group">
                                                    <label for="nickname"><?php print $this->lang->line('nickname'); ?></label>
                                                    <input type="text" name="nickname" id="nickname" value="<?php print $member->nickname; ?>"  class="form-control" <?php echo $permission['user_profile']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="dob"><?php print $this->lang->line('dob'); ?></label>
                                                    <input type="text" name="dob" id="dob" value="<?php print $member->dob; ?>"  class="form-control datepicker" <?php echo $permission['user_profile']['disable_input'];?>>
                                                    <!-- <input type="text" name="dob" id="dob" value="<?php print $member->dob; ?>"  class="form-control"> -->
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="phone_display"><?php print $this->lang->line('phone'); ?></label>
                                                    <br />
        											<input type="tel" name="phone_display" id="phone_display" class="form-control" value="<?php print $member->phone; ?>" <?php echo $permission['user_profile']['disable_input'];?>>
                                                    <input type="hidden" name="phone" id="phone" class="form-control" value="<?php print $member->phone; ?>">
                                                    <span id="phone-valid-msg" class="hide"><i class="fa fa-check"></i></span>
                                                    <span id="phone-error-msg" class="hide"><i class="fa fa-times"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="col-sm-12 form-group">
                                                    <label for="emergency_contact_display"><?php print $this->lang->line('emergency_contact'); ?></label>
                                                    <br />
        											<input type="tel" name="emergency_contact_display" id="emergency_contact_display" class="form-control" value="<?php print $member->emergency_contact; ?>" <?php echo $permission['user_profile']['disable_input'];?>>
                                                    <input type="hidden" name="emergency_contact" id="emergency_contact" class="form-control" value="<?php print $member->emergency_contact; ?>">
                                                    <span id="emergency-valid-msg" class="hide"><i class="fa fa-check"></i></span>
                                                    <span id="emergency-error-msg" class="hide"><i class="fa fa-times"></i></span>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="emergency_name"><?php print $this->lang->line('emergency_name'); ?></label>
                                                    <input type="text" name="emergency_name" id="emergency_name" value="<?php print $member->emergency_name; ?>"  class="form-control" <?php echo $permission['user_profile']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="relationship"><?php print $this->lang->line('relationship'); ?></label>
                                                    <select name="relationship" id="relationship" class="form-control" <?php echo $permission['user_profile']['disable_input'];?>>
                                                        <option style="display:none;" value="<?php print $member->relationship; ?>" selected><?php print $member->relationship; ?></option>
                                                        <option value="children"><?php print $this->lang->line('children'); ?></option>
        												<option value="friends"><?php print $this->lang->line('friends'); ?></option>
        												<option value="parents"><?php print $this->lang->line('parents'); ?></option>
        												<option value="relative"><?php print $this->lang->line('relative'); ?></option>
        												<option value="spouse"><?php print $this->lang->line('spouse'); ?></option>
        												<option value="siblings"><?php print $this->lang->line('siblings'); ?></option>
        												<option value="others"><?php print $this->lang->line('others'); ?></option>
        											</select>
                                                </div>
                                                <div class = "col-sm-3 form-group pull-right">
                                                    <button type="submit" class="btn btn-success js-btn-loading" <?php echo $permission['user_profile']['disable_input'];?>><i class="fa fa-floppy-o pd-r-5"></i><?php print $this->lang->line('save'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php print form_close() ."\r\n"; ?>
            					</div>
            					<div class="tab-pane <?php echo ($tab == 'ids') ? 'active' : ''; ?>" id="ids">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <?php print form_open('adminpanel/edit_member_detail/save_ids', array('id' => 'save_ids_form' , 'class' =>'form-confirm')) ."\r\n"; ?>
                                            <div class="col-sm-6">
                                                <input type="hidden" name="user_id" id="user_id" value="<?php print $member->user_id; ?>">
                                                <input type="hidden" name="username" id="username" value="<?php print $member->username; ?>">
                                                <div class="col-sm-12 form-group">
                                                    <label for="tb_lp_id">TB LP ID</label>
                                                    <input type="text" name="tb_lp_id" id="tb_lp_id" value="<?php print $member->tb_lp_id; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="tb_lp_name">TB LP Name</label>
                                                    <input type="text" name="tb_lp_name" id="tb_lp_name" value="<?php print $member->tb_lp_name; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="sy_lp_id">SY LP ID</label>
                                                    <input type="text" name="sy_lp_id" id="sy_lp_id" value="<?php print $member->sy_lp_id; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="sy_lp_name">SY LP Name</label>
                                                    <input type="text" name="sy_lp_name" id="sy_lp_name" value="<?php print $member->sy_lp_name; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="rtx">RTX</label>
                                                    <input type="text" name="rtx" id="rtx" value="<?php print $member->rtx; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="col-sm-12 form-group">
                                                    <label for="tb_bo">TB BO</label>
                                                    <input type="text" name="tb_bo" id="tb_bo" value="<?php print $member->tb_bo; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="gd_bo">GD BO</label>
                                                    <input type="text" name="gd_bo" id="gd_bo" value="<?php print $member->gd_bo; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="keno_bo">KENO BO</label>
                                                    <input type="text" name="keno_bo" id="keno_bo" value="<?php print $member->keno_bo; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="cyber_roam">Cyber Roam</label>
                                                    <input type="text" name="cyber_roam" id="cyber_roam" value="<?php print $member->cyber_roam; ?>"  class="form-control" <?php echo $permission['user_ids']['disable_input'];?>>
                                                </div>
                                                <div class = "col-sm-3 form-group pull-right">
                                                    <button type="submit" class="btn btn-success js-btn-loading" <?php echo $permission['user_ids']['disable_input'];?>><i class="fa fa-floppy-o pd-r-5"></i><?php print $this->lang->line('save'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php print form_close() ."\r\n"; ?>
                                    </div>
            					</div>
                                <div class="tab-pane <?php echo ($tab == 'remark') ? 'active' : ''; ?>" id="remark">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <?php print form_open('adminpanel/edit_member_detail/save_remarks', array('id' => 'save_remark_form', 'class' =>'form-confirm')) ."\r\n"; ?>
                                            <input type="hidden" name="username" id="username" value="<?php print $member->username; ?>">
                                            <input type="hidden" name="user_id" id="user_id" value="<?php print $member->user_id; ?>">

                                            <div class="col-sm-12 form-group">
                                                <label for="remark"><?php print $this->lang->line('remark'); ?></label>
                                                <textarea name="remark" id="remark" rows="10" class="form-control" <?php echo $permission['user_remark']['disable_input'];?>> <?php print $member->remark; ?></textarea>
                                            </div>
                                            <div class = "col-sm-1 form-group pull-right">
                                                <button type="submit" class="btn btn-success js-btn-loading" <?php echo $permission['user_remark']['disable_input'];?>><i class="fa fa-floppy-o pd-r-5"></i><?php print $this->lang->line('save'); ?></button>
                                            </div>
                                            <?php print form_close() ."\r\n"; ?>
                                        </div>
                                    </div>
            					</div>
                                <div class="tab-pane <?php echo ($tab == 'password') ? 'active' : ''; ?>" id="password">
                                    <div class="col-sm-10">
                                        <div class="row">
                                         <?php print form_open('adminpanel/edit_member_detail/save_password', array('id' => 'change_password_form')) ."\r\n"; ?>
                                            <div class="col-sm-12 form-group">
                                            <h3><?php print $this->lang->line('change_password'); ?></h3>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label for="old password"><?php print $this->lang->line('old_password'); ?></label>
                                                <input type="password" name="old_password" id="old_password" maxlength="20" minlength="8"class="form-control" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required <?php echo $permission['user_password']['disable_input'];?>>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label for="new password"><?php print $this->lang->line('new_password'); ?></label>
                                                <input type="password" name="new_password" id="new_password" maxlength="20" minlength="8" class="form-control" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required <?php echo $permission['user_password']['disable_input'];?>>
                                                <label style="color:#9C9696; font-size:12px;"><?php print $this->lang->line("new_password_label"); ?></label>
                                            </div>
                                             <div class="col-sm-12 form-group">
                                                <label for="confirm password"><?php print $this->lang->line('confirm_password'); ?></label>
                                                <input type="password" name="confirm_password" id="confirm_password" maxlength="20" minlength="8" class="form-control" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required <?php echo $permission['user_password']['disable_input'];?>>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label for="password hint"><?php print $this->lang->line('password_hint'); ?></label>
                                                <input type="text" name="password_hint" id="password_hint" maxlength="30" class="form-control" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required <?php echo $permission['user_password']['disable_input'];?>>
                                            </div>
                                            <div class = "col-sm-1 form-group" id="change_password_submit" style="margin-right:20px;">
                                                <button type="submit" class="btn btn-success js-btn-loading" <?php echo $permission['user_password']['disable_input'];?>><i class="fa fa-floppy-o"> </i> <?php print $this->lang->line('save'); ?></button>
                                            </div>
                                            <input type="hidden" name="user_id" id="user_id" value="<?php print $member->user_id; ?>">
                                            <input type="hidden" name="username" id="username" value="<?php print $member->username; ?>">
                                            <?php print form_close() ."\r\n"; ?>

                                            <?php print form_open('adminpanel/reset_password/send_password', array('id' =>'reset_password_form', 'class' => 'form-confirm')) ."\r\n"; ?>

                                            <div class = "col-sm-1 form-group" >
                                                <a>
                                                    <button type="submit" id="reset_password_submit" class="check_email_empty btn btn-danger js-btn-loading" data-loading-text="Checking..." >
                                                    <i class="fa fa-repeat"></i> <?php print $this->lang->line('reset_password'); ?>
                                                    </button>
                                                </a>
                                                    <input type="hidden" name="email" id="email" value="<?php print $member->email; ?>">
                                                    <input type="hidden" name="user_id" id="user_id" value="<?php print $member->user_id; ?>">
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
        </div>
		</div>
	</div>
</div>
<script src="<?php print base_url(); ?>assets/js/vendor/intl-tel-input/build/js/intlTelInput.js"></script>
<script src="<?php print base_url(); ?>assets/js/adminpanel/edit_member_details.js"></script>
