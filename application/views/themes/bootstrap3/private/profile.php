<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>


<div>
    <?php $this->load->view('generic/flash_error'); ?>
</div>

<h2>Profile picture</h2>

<div class="row">
    <div class="col-sm-4">

        <p>
            <em>Maximum 50 kilobytes.</em>
        </p>

        <?php print form_open('tools/upload/upload_profile_picture', array('id' => 'upload_profile_picture')) ."\r\n"; ?>
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button mg-b-10">
            <i class="fa fa-plus pd-r-5"></i>
            <span>Select files</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files[]">
        </span>
        <?php print form_close() ."\r\n"; ?>

        <!-- The global progress bar -->
        <div id="progress" class="progress hidden">
            <div class="progress-bar progress-bar-success"></div>
        </div>
        <!-- The container for the uploaded files -->
        <div id="files" class="files text-primary f900">
            <?php if (!isset($profile_image)) { ?>
            No profile image uploaded yet.
            <?php } ?>
        </div>

        <?php if (isset($profile_image)) { ?>
            <div class="mg-t-10">
                <img id="js_profile_image" src="<?php print base_url(); ?>assets/img/members/<?php print $this->session->userdata('username'); ?>/profile.<?php print $ext; ?>" class="profile-img img-thumbnail">
            </div>
        <?php }else{ ?>
            <div class="mg-t-10">
                <img id="js_profile_image" src="<?php print base_url(); ?>assets/img/members_generic.png" class="profile-img img-thumbnail">
            </div>
        <?php } ?>

        <?php print form_open('tools/upload/delete_profile_picture', array('id' => 'delete_profile_picture')) ."\r\n"; ?>
        <button id="delete_profile_picture_submit" name="delete_profile_picture_submit" class="btn btn-danger mg-t-10 js-btn-loading mg-b-5" data-loading-text="Deleting...">
            <i class="fa fa-trash-o pd-r-5"></i> Delete
        </button>
        <?php print form_close() ."\r\n"; ?>

    </div>
</div>



<hr>

<h2><?php print $this->lang->line('personal_details'); ?></h2>


<div class="row">

	
	<?php print form_open('private/profile/update_account', array('id' => 'profile_form')) ."\r\n"; ?>

	<div class="col-sm-6">

		<div class="form-group">
			<label for="profile_first_name"><?php print $this->lang->line('first_name'); ?></label>
			<input type="text" name="first_name" id="profile_first_name" class="form-control input-lg" value="<?php print $first_name; ?>">
		</div>
		
		<div class="form-group">
			<label for="profile_last_name"><?php print $this->lang->line('last_name'); ?></label>
			<input type="text" name="last_name" id="profile_last_name"  class="form-control input-lg" value="<?php print $last_name; ?>">
		</div>
		
		<div class="form-group">
			<label for="profile_email"><?php print $this->lang->line('change_email'); ?></label>
			<input type="text" name="email" id="profile_email" class="form-control" value="<?php print $email; ?>">
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class="form-group">
			<label for="profile_password" style="color: red"><?php print $this->lang->line('password_required_for_changes'); ?></label>
			<input type="password" name="password" id="profile_password" class="form-control input-lg">
		</div>

		<div class="form-group">
			<button type="submit" name="profile_submit" id="profile_submit" class="btn btn-primary btn-lg text-uppercase f900 js-btn-loading" data-loading-text="Saving...">
                <i class="fa fa-user pd-r-5"></i> <?php print $this->lang->line('update_profile'); ?>
            </button>
			<input type="hidden" name="user_id" value="<?php print $user_id; ?>">
		</div>
	</div>
	<?php print form_close() ."\r\n"; ?>
	
	<?php print form_open('private/profile/delete_account', array('id' => 'delete_profile_form')) ."\r\n"; ?>
	<div class="col-sm-6">
		<div class="form-group">
			<strong><?php print $this->lang->line('permanently_delete_account'); ?></strong>
			<br>
            <button type="submit" id="permanently_remove" class="btn btn-danger btn-lg js-confirm-delete">
                <i class="fa fa-trash-o pd-r-5"></i> <?php print $this->lang->line('delete_account_now'); ?>
            </button>
		</div>
	</div>
	<?php print form_close() ."\r\n"; ?>
	
</div>

<hr>

<?php print form_open('private/profile/update_password', array('id' => 'profile_pwd_form')) ."\r\n"; ?>

<h2>
    <?php print  $this->lang->line('edit_password'); ?>
</h2>

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6">


            <?php if ($this->session->flashdata('pwd_error')) { ?>
            <div id="pwd_error">
                <div class="alert alert-danger">
                    <h4>Password error:</h4>
                    <p><?php print $this->session->flashdata('pwd_error'); ?></p>
                </div>
            </div>
            <?php } ?>


            <?php if ($this->session->flashdata('pwd_success')) { ?>
            <div id="success">
                <div class="alert alert-success">
                    <h4>Success!!</h4>
                    <p><?php print $this->session->flashdata('pwd_success'); ?></p>
                </div>
            </div>
            <?php } ?>

	
		<div class="form-group">
			<label for="current_password"><?php print $this->lang->line('current_password'); ?></label>
			<input type="password" name="current_password" id="current_password" class="form-control">
		</div>
		
		<div class="form-group">
			<label for="profile_new_password"><?php print $this->lang->line('new_password'); ?></label>
			<input type="password" name="new_password" id="profile_new_password" class="form-control tooltip_target" data-original-title="<?php print $this->lang->line('password_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<label for="new_password_again"><?php print $this->lang->line('new_password_again'); ?></label>
			<input type="password" name="new_password_again" id="new_password_again" class="form-control tooltip_target">
		</div>
		
		<div class="form-group">
            <div class="app-checkbox">
                <label class="pd-r-10">
                    <?php print form_checkbox(array('name' => 'send_copy', 'value' => 'accept', 'checked' => TRUE, 'class' => 'checkbox')); ?>
                    <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('send_copy_to_email'); ?>
                </label>
            </div>
		</div>
	</div>
</div>

<?php print form_hidden('email', $email); ?>

<button type="submit" name="profile_pwd_submit" id="profile_pwd_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Resetting...">
    <i class="fa fa-key pd-r-5"></i> <?php print $this->lang->line('update_password'); ?>
</button>

<?php print form_close() ."\r\n"; ?>
