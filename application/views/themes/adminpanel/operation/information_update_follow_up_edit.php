<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/information_update_follow_up_edit/' . $key . '/' . $follow_up->follow_up_id, 'id="information_update_follow_up_edit_form"') . "\r\n"; ?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="follow_up"><?php print $this->lang->line('follow_up_by'); ?></label>
                <input type="text" class="form-control" id="follow_up" name="follow_up" value="<?php print $follow_up->follow_up;?>" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required autocomplete="off"/>
            </div>
            <div class="form-group">
                <label for="status"><?php print $this->lang->line('status'); ?></label>
                <select name="status" id="status" class="form-control" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled required>
                    <option value="follow-up" <?php print ($follow_up->status == 'follow-up') ? "selected" : ""; ?>><?php print $this->lang->line('follow-up'); ?></option>
                    <option value="done" <?php print ($follow_up->status == 'done') ? "selected" : ""; ?>><?php print $this->lang->line('done'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="remarks"><?php print $this->lang->line('remark'); ?></label>
                <textarea class="form-control" id="remarks" name="remarks" rows="4" style="resize: vertical;" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required><?php print $follow_up->remarks;?></textarea>
            </div>
            <div>
                <button type="submit" id="information_update_follow_up_edit_submit" name="information_update_follow_up_edit_submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
                <a href="<?php print base_url() . "adminpanel/operation/information_update_follow_up/" . $key; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
            </div>
        </div>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
