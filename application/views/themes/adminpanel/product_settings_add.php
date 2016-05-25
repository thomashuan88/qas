<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?> 

<?php $this->load->view('generic/flash_error'); ?>


<?php print form_open('adminpanel/settings/save_product', array('id' => 'product_setting_add_form')) ."\r\n"; ?>
<div class="col-md-6" >
  <div class="panel panel-default">
      <div class="panel-heading">
          <h4><?php print $this->lang->line('add_product'); ?></h4>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label for="product type"><?php print $this->lang->line('product_type'); ?></label>
          <input type="text" class="form-control" id="product" name="product" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
        </div><br>
        <div class="form-group">
          <button type="submit" id="product_setting_add_submit" class="btn btn-success js-btn-loading" data-loading-text="<?php print $this->lang->line('saving'); ?>"><i class="fa fa-floppy-o pd-r-5"></i> <?php print $this->lang->line('save'); ?></button>
            <a href="<?php print base_url() . "adminpanel/settings/?tab=product"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
      </div>
      </div>
  </div>
</div>
<?php print form_close() ."\r\n"; ?>