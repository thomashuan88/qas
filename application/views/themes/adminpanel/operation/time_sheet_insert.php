<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/time_sheet_insert/', 'class="form-confirm"') . "\r\n"; ?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="shift"><?php print $this->lang->line('shift'); ?></label>
                <?php print $shift_list; ?>
            </div>
            <div class="form-group">
                <label for="remarks"><?php print $this->lang->line('remarks'); ?></label>
                <textarea class="form-control" id="remarks" name="remarks" rows="4" style="resize: vertical;"><?php print $this->session->flashdata('remarks');?></textarea>
            </div>
            <div>
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
                <a href="<?php print base_url() . "adminpanel/operation/time_sheet/"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
            </div>
        </div>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
