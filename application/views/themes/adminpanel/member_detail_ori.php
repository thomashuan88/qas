<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

    <?php $this->load->view('generic/flash_error'); ?>

    <h2>
        <?php print $this->lang->line('viewing_member'); ?>: <strong class="text-primary"><?php print $member->username; ?> (ID: <?php print $member->user_id; ?>)</strong>
    </h2>

    <p>
        <span class="label label-primary"><?php print $this->lang->line('last_login'); ?>:</span>
        <strong><?php print $member->last_login; ?></strong>
    </p>

    <p>
        <span class="label label-primary"><?php print $this->lang->line('date_registered'); ?>:</span>
        <strong><?php print $member->date_registered; ?></strong>
    </p>

	<div class="row">
		<div class="col-sm-6">
			<?php print form_open('adminpanel/member_detail/save') ."\r\n"; ?>

			<div class="form-group">
				<label for="username"><?php print $this->lang->line('username'); ?></label>
				<input type="text" name="username" id="username" value="<?php print $member->username; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('username_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="email"><?php print $this->lang->line('email_address'); ?></label>
				<input type="text" name="email" id="email" value="<?php print $member->email; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('email_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="first_name"><?php print $this->lang->line('first_name'); ?></label>
				<input type="text" name="first_name" id="first_name" value="<?php print $member->first_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('first_name_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="last_name"><?php print $this->lang->line('last_name'); ?></label>
				<input type="text" name="last_name" id="last_name" value="<?php print $member->last_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('last_name_requirements'); ?>" class="form-control tooltip_target">
			</div>
		</div>

		<div class="col-sm-6">
            <div class="form-group">
                <label>Roles</label>
                <?php foreach($roles as $role) {?>
                    <div class="app-checkbox">
                        <label class="pd-r-10">
                            <input type="checkbox" name="roles[]" value="<?php print $role->role_id; ?>" class="list_members_checkbox"<?php foreach($member_roles as $mr) {if ($role->role_id == $mr->role_id) {print ' checked="checked"';}}; ?>>
                            <span class="fa fa-check"></span> <?php print $role->role_name; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>

			<div class="form-group">
				<label for="banned"><?php print $this->lang->line('banned'); ?>?</label>
				<select name="banned" id="banned" class="form-control">
					<option value="0"<?php print ($member->banned == false ? ' selected="selected"' : ''); ?>>No</option>
					<option value="1"<?php print ($member->banned == true ? ' selected="selected"' : ''); ?>>Yes</option>
				</select>
			</div>

			<div class="form-group">
				<label for="active"><?php print $this->lang->line('activated'); ?>?</label>
				<select name="active" id="active" class="form-control">
					<option value="1"<?php print ($member->active == true ? ' selected="selected"' : ''); ?>>Yes</option>
					<option value="0"<?php print ($member->active == false ? ' selected="selected"' : ''); ?>>No</option>
				</select>
			</div>

			<div class="form-group">
				<label for="new_password"><?php print $this->lang->line('new_password'); ?></label>
				<input type="password" name="new_password" id="new_password" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('password_requirements'); ?>" class="form-control tooltip_target">
			</div>


		</div>
	</div>
<div>
    <div class="form-group">
        <label for="send_copy" class="inline"><?php print $this->lang->line('send_copy'); ?></label>
        <div class="app-checkbox pull-left mg-b-5">
            <label class="pd-r-10">
                <input type="checkbox" name="send_copy" id="send_copy" value="accept" checked="checked" class="form_control label_checkbox">
                <span class="fa fa-check"></span>
            </label>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Updating..."><i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('save_member_data'); ?></button>
        <input type="hidden" name="user_id" value="<?php print $member->user_id; ?>">
    </div>

    <?php print form_close() ."\r\n"; ?>
</div>