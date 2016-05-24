<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/content_head.php'); ?>


<div class="row">

    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

        <div>
            <?php if (!Settings_model::$db_config['registration_enabled']) { ?>

                <div id="error" class="alert alert-danger">
                    <?php print $this->lang->line('registration_disabled'); ?>
                </div>

            <?php
                }else{
                    $this->load->view('generic/flash_error');
                }
            ?>
        </div>

        <div>
            <?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/auth_oauth.php'); ?>
        </div>

        <div id="regular_wrapper">
            <?php print form_open('auth/register/add_member','id="register_form" class="mg-b-15"') ."\r\n"; ?>

            <p class="f700">
                <?php print $this->lang->line('required_fields'); ?>
            </p>

            <div class="form-group">
                <input type="text" name="first_name" id="first_name" class="form-control input-lg"
                       placeholder="<?php print $this->lang->line('first_name'); ?>"
                       value="<?php print $this->session->flashdata('first_name'); ?>"
                       data-parsley-trigger="change keyup"
                       data-parsley-minlength="2"
                       data-parsley-maxlength="40"
                       required>
                <p class="small pd-5">
                    <strong>Requirements:</strong><br>2-40 characters.
                </p>
            </div>

            <div class="form-group">
                <input type="text" name="last_name" id="last_name" class="form-control input-lg"
                       placeholder="<?php print $this->lang->line('last_name'); ?>"
                       value="<?php print $this->session->flashdata('last_name'); ?>"
                       data-parsley-trigger="change keyup"
                       data-parsley-minlength="2"
                       data-parsley-maxlength="60"
                       required>
                <p class="small pd-5">
                    <strong>Requirements:</strong><br>2-60 characters.
                </p>
            </div>

            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control input-lg"
                       placeholder="<?php print $this->lang->line('email_address'); ?>"
                       value="<?php print $this->session->flashdata('email'); ?>"
                       data-parsley-type="email"
                       data-parsley-trigger="change keyup"
                       data-parsley-maxlength="255"
                       required>
                <p class="small pd-5">
                    <strong>Requirements:</strong><br>please provide a valid email address.
                </p>
            </div>

            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control input-lg"
                       placeholder="<?php print $this->lang->line('username'); ?>"
                       value="<?php print $this->session->flashdata('username'); ?>"
                       data-parsley-pattern="^[a-zA-Z0-9_-]+$"
                       data-parsley-trigger="change keyup"
                       data-parsley-minlength="6"
                       data-parsley-maxlength="16"
                       required>
                <p class="small pd-5">
                    <strong>Requirements:</strong><br>6-16 characters;<br>the characters a-z, A-Z, 0-9, "_" and "-" are allowed.
                </p>
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control input-lg"
                       placeholder="<?php print $this->lang->line('password'); ?>"
                       value="<?php print $this->session->flashdata('password'); ?>"
                       data-parsley-pattern="(?=.*[.@#\$\[\]\|\(\)\?\*\+\{\}\!\=\:\-])(?=.*[0-9])"
                       data-parsley-trigger="change keyup"
                       data-parsley-minlength="9"
                       data-parsley-maxlength="64"
                       required>

                <p class="small pd-5">
                    <strong>Requirements:</strong><br>9-64 characters;<br>use at least one non alphabet character;<br>user at least one number.
                </p>
            </div>

            <div class="form-group">
                <input type="password" name="password_confirm" id="password_confirm" class="form-control input-lg"
                       placeholder="<?php print $this->lang->line('confirm_password'); ?>"
                       value="<?php print $this->session->flashdata('password_confirm'); ?>"
                       data-parsley-equalto="#password"
                       required>
                <p class="small pd-5">
                    <strong>Requirements:</strong><br>Must be the same as chosen password.
                </p>
            </div>

            <div class="form-group">
                <?php
                if (Settings_model::$db_config['recaptchav2_enabled'] == true) {
                    //print $this->recaptcha->get_html();
                    echo $this->recaptchav2->render();
                }
                ?>
            </div>

            <div class="form-group">
                <button type="submit" name="register_submit" id="register_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Registering...">
                    <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('create_account'); ?>
                </button>
            </div>

            <?php print form_close() ."\r\n"; ?>
        </div>

        <?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/auth_links'); ?>

    </div>

</div>


