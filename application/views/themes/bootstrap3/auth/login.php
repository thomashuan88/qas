<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/content_head.php'); ?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <?php
            $this->load->view('generic/flash_error');
        ?>
        <div>
        </div>

        <?php print form_open('auth/login/validate', 'id="login_form" class="mg-b-15"') ."\r\n"; ?>
        
        <div class="form-group">
            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="<?php print $this->lang->line('username'); ?>" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
        </div>

        <div class="form-group">
            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="<?php print $this->lang->line('password'); ?>" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
        </div>

        <div class="form-group">
            <select class="form-control input-lg" name="language" id="language" >
                <option value="english" selected>English</option>
                <option value="chinese">中文</option>
            </select>
        </div>
    
        <div class="form-group">
            <button type="submit" name="submit" id="login_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Validating...">
                <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('login'); ?>
            </button>
        </div>
        <?php print form_close() ."\r\n"; ?>

    </div>

</div>

<script type="text/javascript">

var lang = "<?php echo $language; ?>";

$(function(){
    if(lang != ""){
        $("option[value='"+lang+"']").attr("selected", true);
    }

    $("select[name='language']").change(function(){
        var language = $(this).val();
        window.location.href = "?language="+language;
    });
});



var parsley_factory = function($form, $button) {
var $parsley = $form.parsley();
    $button.on('click', function(e) {
        if ($parsley.isValid()) {
            $parsley.destroy();
            $form.submit();
        }else{
        $(this).button("reset");
        }
    });
};
// Parsley login form
var $loginForm = $("#login_form");
if ($loginForm.length) {
    parsley_factory( $loginForm, $("#login_submit") );
}

</script>