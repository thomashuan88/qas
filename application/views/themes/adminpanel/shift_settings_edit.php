<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?> 

<?php $this->load->view('generic/flash_error'); ?>


<?php print form_open('adminpanel/settings/edit_shift/'.$shift->sid, 'class="form-confirm"') . "\r\n"; ?>
<div class="col-md-6" >
  <div class="panel panel-default">
    <div class="panel-heading">
        <h4><?php print $this->lang->line('edit_shift'); ?></h4>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="working shift"><?php print $this->lang->line('working_shift'); ?></label>
        <input type="text" class="form-control" id="shift" name="shift" value="<?php print $shift->key?>" readonly>
      </div>

      <div class="form-group">
        <label for="working hour"><?php print $this->lang->line('working_hour'); ?></label>
          <input type="text" class="form-control timepicker" id="hour" name="hour" oninput="this.value = this.value.replace(/[^0-9:]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="<?php print $shift->value?>" maxlength="5">
      </div>
      
      <div class="form-group">
        <button type="submit" class="btn btn-success js-btn-loading" data-loading-text="<?php print $this->lang->line('saving'); ?>"><i class="fa fa-floppy-o pd-r-5"></i> <?php print $this->lang->line('save'); ?></button>
         <a href="<?php print base_url() . "adminpanel/settings/"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
      </div>
    </div>

  </div>
</div>
<?php print form_close() ."\r\n"; ?>


