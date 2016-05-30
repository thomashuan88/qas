<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
       	<?php print form_open('adminpanel/reset_password/send_password', array('id' => 'reset_password_form')) ."\r\n"; ?>

        <div class="form-group">
            <input type="text" name="email" id="email" class="form-control input-lg" placeholder="<?php print $this->lang->line('your_email'); ?>"data-parsley-type="email">
        </div>
        <div class="form-group">
            <button type="submit" id="reset_password_submit" class="check_email_empty btn btn-primary btn-lg js-btn-loading" data-loading-text="Checking...">
                <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('reset_password'); ?>
            </button>
        </div>

        <?php print form_close() ."\r\n"; ?>
    </div>

</div>