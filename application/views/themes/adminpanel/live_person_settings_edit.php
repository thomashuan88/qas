<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?> 

<?php $this->load->view('generic/flash_error'); ?>


<?php print form_open('adminpanel/settings/edit_live_person/'.$product, 'class="form-confirm"') . "\r\n"; ?>
<div class="col-md-12" >
  <div class="panel panel-default">
      <div class="panel-heading">
          <h4><?php print $this->lang->line('edit_live_person'); ?></h4>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="form-group col-md-6">
            <label for="Product Type"><?php print $this->lang->line('product_type'); ?></label>
            <input type="text" class="form-control" id="product" name="product"  value="<?php print $product; ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="Account ID"><?php print $this->lang->line('account_id'); ?></label>
            <input type="text" class="form-control" id="account_id" name="account_id" value="<?php print $live_person[$product]["account_id"]; ?>">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label for="Consumer Key"><?php print $this->lang->line('consumer_key'); ?></label>
            <input type="text" class="form-control" id="consumer_key" name="consumer_key" value="<?php print $live_person[$product]["consumer_key"]; ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="Access Token"><?php print $this->lang->line('access_token'); ?></label>
            <input type="text" class="form-control" id="access_token" name="access_token" value="<?php print $live_person[$product]["access_token"]; ?>">
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="Consumer Secret"><?php print $this->lang->line('consumer_secret'); ?></label>
            <input type="text" class="form-control" id="consumer_secret" name="consumer_secret" value="<?php print $live_person[$product]["consumer_secret"]; ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="Access Token Secret"><?php print $this->lang->line('access_token_secret'); ?></label>
            <input type="text" class="form-control" id="access_token_secret" name="access_token_secret" value="<?php print $live_person[$product]["access_token_secret"]; ?>">
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success js-btn-loading" data-loading-text="<?php print $this->lang->line('saving'); ?>"><i class="fa fa-floppy-o pd-r-5"></i> <?php print $this->lang->line('save'); ?></button>
            <a href="<?php print base_url() . "adminpanel/settings/?tab=live_person"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
        </div>
      </div>
  </div>
</div>
<?php print form_close() ."\r\n"; ?>