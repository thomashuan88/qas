<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/information_update_details_edit/' . $key . '/' . $follow_up->follow_up_id, 'id="information_update_details_edit_form"') . "\r\n"; ?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label style="color:red; font-size:14px;">*&nbsp;<span style="font-style: italic; font-size: 12px;"><?php print $this->lang->line('required_fields'); ?></span></label>
            </div>
            <div class="form-group">
                <label for="status"><?php print $this->lang->line('status'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <select name="status" id="status" class="form-control" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled required>
                    <option value="inform" <?php print ($follow_up->status == 'inform') ? "selected" : ""; ?>><?php print $this->lang->line('update'); ?></option>
                    <option value="informed" <?php print ($follow_up->status == 'informed') ? "selected" : ""; ?>><?php print $this->lang->line('done'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="remarks"><?php print $this->lang->line('remark'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="4" style="resize: vertical;" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required><?php print $follow_up->remarks;?></textarea>
            </div>
            <div>
                <button type="submit" id="information_update_details_edit_submit" name="information_update_details_edit_submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
                <a href="<?php print base_url('adminpanel/operation/information_update_details') . "/" . $key . '?type=session'; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
            </div>
        </div>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
