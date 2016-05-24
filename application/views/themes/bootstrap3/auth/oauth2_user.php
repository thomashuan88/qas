<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/content_head.php'); ?>

<div class="row">

    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

        <div>
            <?php $this->load->view('generic/flash_error'); ?>
        </div>

        <?php print form_open('auth/oauth2/finalize','id="oauth2_finalize_form" class="mg-b-15"') ."\r\n"; ?>

        <div class="form-group">
            <label for="oauth2_username">Choose a username:</label>
            <input type="text" name="oauth2_username" id="oauth2_username" class="form-control input-lg"
                   placeholder="Username"
                   data-parsley-pattern="^[a-zA-Z0-9_-]+$"
                   data-parsley-trigger="change keyup"
                   data-parsley-minlength="6"
                   data-parsley-maxlength="16"
                   required>
        </div>

        <div class="form-group">
            <button type="submit" name="oauth2_finalize_submit" id="oauth2_finalize_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Finalizing...">
                <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('oauth2_finish_account_creation'); ?>
            </button>
        </div>

        <?php print form_close() ."\r\n"; ?>

    </div>
</div>