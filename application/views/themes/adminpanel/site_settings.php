<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

    <?php $this->load->view('generic/flash_error'); ?>


    <?php
    print form_open('adminpanel/site_settings/clear_sessions', array('id' => 'sessions_form')) ."\r\n";
    if ($this->session->flashdata('sessions_message')) {
        print '<div id="error" class="error_box">'. $this->session->flashdata('sessions_message') ."</div>\r\n";
    }
    ?>

        <h2><?php print $this->lang->line('clear_sessions_title'); ?></h2>

        <p>
            Can be used to gracefully make all members log out by removing their session data.
        </p>

        <p>
            <button type="submit" name="sessions_submit" id="sessions_submit" class="btn btn-danger js-btn-loading" data-loading-text="Saving..."><i class="fa fa-flash pd-r-5"></i> <?php print $this->lang->line('clear_sessions'); ?></button>
        </p>

    <?php print form_close() ."\r\n"; ?>



    <?php print form_open('adminpanel/site_settings/update_settings', array('id' => 'settings_form')) ."\r\n"; ?>

    <hr>
    <h2><?php print $this->lang->line('general_settings_title'); ?></h2>



    <p>
        <button type="submit" name="site_settings_submit_top" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Saving..."><i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('save_all_settings'); ?></button>
    </p>
	
	<div class="form-group clearfix">
		<label for="site_title"><?php print $this->lang->line('site_title'); ?></label>
		<p><?php print $this->lang->line('site_title_p'); ?></p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="site_title" id="site_title" class="form-control" value="<?php print Settings_model::$db_config['site_title']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="disable_all" class="pd-r-10">
                <input type="checkbox" name="disable_all" id="disable_all" value="accept"<?php print (Settings_model::$db_config['disable_all'] == 1 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('disable_whole_app'); ?>
            </label>
        </div>
        <p><?php print $this->lang->line('disable_whole_app_p'); ?>
	</div>
	
	<div class="form-group clearfix">
		<label for="site_disabled_text"><?php print $this->lang->line('disabled_text'); ?></label><br>
        <textarea name="site_disabled_text" id="site_disabled_text" class="form-control col-lg-12"><?php print Settings_model::$db_config['site_disabled_text']; ?></textarea>
	</div>

    <div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="login_enabled" class="pd-r-10">
                <input type="checkbox" name="login_enabled" id="login_enabled" value="accept"<?php print (Settings_model::$db_config['login_enabled'] == 0 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('disable_login_access'); ?>
            </label>
        </div>
        <p><?php print $this->lang->line('disable_login_access_p'); ?></p>
    </div>

    <div class="form-group clearfix">
        <label for="max_login_attempts"><?php print $this->lang->line('max_login_attempts'); ?></label>
        <p><?php print $this->lang->line('max_login_attempts_p'); ?></p>
        <div class="row">
            <div class="col-lg-1 col-md-2 col-sm-4 clearfix">
                <input type="text" name="max_login_attempts" id="max_login_attempts" class="form-control mg-b-10" value="<?php print Settings_model::$db_config['max_login_attempts']; ?>">
            </div>
        </div>
    </div>

	<div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="register_enabled" class="pd-r-10">
                <input type="checkbox" name="register_enabled" id="register_enabled" value="accept"<?php print (Settings_model::$db_config['registration_enabled'] == 0 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('disable_registration'); ?>
            </label>
        </div>
        <p class="form_subtext"><?php print $this->lang->line('disable_registration_p'); ?></p>
	</div>
	
	<div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="remember_me_enabled" class="pd-r-10">
                <input type="checkbox" name="remember_me_enabled" id="remember_me_enabled" value="accept"<?php print (Settings_model::$db_config['remember_me_enabled'] == 1 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('enable_remember_me'); ?>
            </label>
        </div>
        <p><?php print $this->lang->line('enable_remember_me_p'); ?></p>
	</div>

    <div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="install_enabled" class="pd-r-10">
                <input type="checkbox" name="install_enabled" id="install_enabled" value="accept"<?php print (Settings_model::$db_config['install_enabled'] == 1 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('enable_install_page'); ?>
            </label>
        </div>
        <p><?php print $this->lang->line('enable_install_page_p'); ?></p>
    </div>

    <div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="oauth2_enabled" class="pd-r-10">
                <input type="checkbox" name="oauth2_enabled" id="oauth2_enabled" value="accept"<?php print (Settings_model::$db_config['oauth2_enabled'] == 1 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('enable_oauth'); ?>
            </label>
        </div>
        <p><?php print $this->lang->line('enable_oauth_p'); ?></p>
    </div>
	
	<div class="form-group clearfix">
		<label for="members_per_page"><?php print $this->lang->line('members_per_page'); ?></label>
        <p><?php print $this->lang->line('members_per_page_p'); ?></p>
        <div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
				<input type="text" name="members_per_page" id="members_per_page" class="form-control" value="<?php print Settings_model::$db_config['members_per_page']; ?>" maxlength="3">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="admin_email"><?php print $this->lang->line('admin_email'); ?></label>
        <p><?php print $this->lang->line('admin_email_p'); ?></p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="admin_email" id="admin_email" class="form-control" value="<?php print Settings_model::$db_config['admin_email_address']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="home_page"><?php print $this->lang->line('²post_login_page'); ?></label>
        <p><?php print $this->lang->line('post_login_page_p'); ?></p>
        <div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<?php print form_dropdown('home_page', $private_pages, Settings_model::$db_config['home_page'], 'class="form-control"'); ?>
			</div>
		</div>
	</div>

    <div class="form-group clearfix">
        <label for="active_theme"><?php print $this->lang->line('active_theme'); ?></label>
        <p><?php print $this->lang->line('active_theme_p'); ?></p>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 clearfix">
                <input type="text" name="active_theme" id="active_theme" class="form-control" value="<?php print Settings_model::$db_config['active_theme']; ?>">
            </div>
        </div>
    </div>

    <div class="form-group clearfix">
        <label for="adminpanel_theme"><?php print $this->lang->line('adminpanel_theme'); ?></label>
        <p><?php print $this->lang->line('adminpanel_theme_p'); ?></p>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 clearfix">
                <input type="text" name="adminpanel_theme" id="adminpanel_theme" class="form-control" value="<?php print Settings_model::$db_config['adminpanel_theme']; ?>">
            </div>
        </div>
    </div>
	
	<div class="form-group clearfix">
		<label for="cookie_expires"><?php print $this->lang->line('cookie_expiration'); ?></label>
        <p><?php print $this->lang->line('cookie_expiration'); ?></p>
        <div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="cookie_expires" id="cookie_expires" class="form-control" value="<?php print Settings_model::$db_config['cookie_expires']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="password_link_expires"><?php print $this->lang->line('password_link_expiration'); ?></label>
        <p><?php print $this->lang->line('password_link_expiration_p'); ?></p>
        <div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="password_link_expires" id="password_link_expires" class="form-control" value="<?php print Settings_model::$db_config['password_link_expires']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="activation_link_expires"><?php print $this->lang->line('activation_link_expiration'); ?></label>
        <p><?php print $this->lang->line('activation_link_expiration_p'); ?></p>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="activation_link_expires" id="activation_link_expires" class="form-control" value="<?php print Settings_model::$db_config['activation_link_expires']; ?>">
			</div>
		</div>
	</div>

    <p>
        <button type="submit" name="site_settings_submit_top" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Saving..."><i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('save_all_settings'); ?></button>
    </p>

    <hr>
	<h2><?php print $this->lang->line('mail_settings_title'); ?></h2>
	
	<div class="form-group clearfix">

        <div class="app-radio mg-b-5">
            <label for="phpmail">
                <input type="radio" id="phpmail" name="email_protocol" value="1" class="label_checkbox"<?php print (Settings_model::$db_config['email_protocol'] == 1 ? ' checked="checked"' : ""); ?>>
                <span class="mg-r-5"></span>
                PHP mail()
            </label>
        </div>
        <div class="app-radio mg-b-5">
            <label for="sendmail">
                <input type="radio" id="sendmail" name="email_protocol" value="2" class="label_checkbox"<?php print (Settings_model::$db_config['email_protocol'] == 2 ? ' checked="checked"' : ""); ?>>
                <span class="mg-r-5"></span>
                Sendmail
            </label>
        </div>
        <div class="app-radio mg-b-5">
            <label for="gmailsmtp">
                <input type="radio" id="gmailsmtp" name="email_protocol" value="3" class="label_checkbox"<?php print (Settings_model::$db_config['email_protocol'] == 3 ? ' checked="checked"' : ""); ?>>
                <span class="mg-r-5"></span>
                Gmail
            </label>
        </div>


	</div>
	
	<div class="form-group clearfix">
		<label for="sendmail_path"><?php print $this->lang->line('sendmail_path'); ?></label>
        <p><?php print $this->lang->line('sendmail_path_p'); ?></p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="sendmail_path" id="sendmail_path" class="form-control" value="<?php print Settings_model::$db_config['sendmail_path']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_host"><?php print $this->lang->line('smtp_host'); ?></label>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?php print Settings_model::$db_config['smtp_host']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_port"><?php print $this->lang->line('smtp_port'); ?></label>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php print Settings_model::$db_config['smtp_port']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_user"><?php print $this->lang->line('smtp_user'); ?></label>
        <p><?php print $this->lang->line('smtp_encrypt'); ?></p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?php print $this->encrypt->decode(Settings_model::$db_config['smtp_user']); ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_pass"><?php print $this->lang->line('smtp_password'); ?></label>
        <p><?php print $this->lang->line('smtp_encrypt'); ?></p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_pass" id="smtp_pass" class="form-control" value="<?php print $this->encrypt->decode(Settings_model::$db_config['smtp_pass']); ?>">
			</div>
		</div>
	</div>

    <p>
        <button type="submit" name="site_settings_submit_top" class="btn btn-primary btn-lg js-btn-loading"  data-loading-text="Saving..."><i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('save_all_settings'); ?></button>
    </p>


    <hr>
    <h2><?php print $this->lang->line('recaptcha_settings_title'); ?></h2>

    <div class="form-group clearfix">
        <div class="app-checkbox">
            <label for="recaptchav2_enabled" class="pd-r-10">
                <input type="checkbox" name="recaptchav2_enabled" id="recaptchav2_enabled" value="accept"<?php print (Settings_model::$db_config['recaptchav2_enabled'] == 1 ? ' checked="checked"' : ""); ?>>
                <span class="fa fa-check pd-r-5"></span> <?php print $this->lang->line('enable_recaptcha'); ?>
            </label>
        </div>
        <p><?php print $this->lang->line('enable_recaptcha_p'); ?></p>
    </div>

    <div class="form-group clearfix">
        <label for="recaptchav2_site_key"><?php print $this->lang->line('site_key'); ?></label>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 clearfix">
                <input type="text" name="recaptchav2_site_key" id="recaptchav2_site_key" class="form-control" value="<?php print Settings_model::$db_config['recaptchav2_site_key']; ?>">
            </div>
        </div>
    </div>

    <div class="form-group clearfix">
        <label for="recaptchav2_secret"><?php print $this->lang->line('site_secret'); ?></label>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 clearfix">
                <input type="text" name="recaptchav2_secret" id="recaptchav2_secret" class="form-control" value="<?php print Settings_model::$db_config['recaptchav2_secret']; ?>">
            </div>
        </div>
    </div>

    <div class="form-group clearfix">
        <label for="login_attempts"><?php print $this->lang->line('login_attempts_trigger'); ?></label>
        <p><?php print $this->lang->line('login_attempts_trigger_p'); ?></p>
        <div class="row">
            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-8 clearfix">
                <input type="text" name="login_attempts" id="login_attempts" class="form-control" value="<?php print Settings_model::$db_config['login_attempts']; ?>" maxlength="3">
            </div>
        </div>
    </div>

    <p>
        <button type="submit" name="site_settings_submit_top" class="btn btn-primary btn-lg js-btn-loading"  data-loading-text="Saving..."><i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('save_all_settings'); ?></button>
    </p>

    <?php
    print form_close() ."\r\n";

?>