<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/question_type_edit/' . $type->category_group_id, 'class="form-confirm"') . "\r\n"; ?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="content"><?php print $this->lang->line('content'); ?></label>
                <input type="text" class="form-control" id="content" name="content" value="<?php print $type->content;?>"/>
            </div>
            <div class="form-group">
                <label for="status"><?php print $this->lang->line('status'); ?></label>
                <select name="status" id="status" class="form-control">
                    <option value="active" <?php print ($type->status == 'active') ? "selected" : ""; ?>><?php print $this->lang->line('active'); ?></option>
                    <option value="inactive" <?php print ($type->status == 'inactive') ? "selected" : ""; ?>><?php print $this->lang->line('inactive'); ?></option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
                <a href="<?php print base_url() . "adminpanel/operation/question_type/"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
            </div>
        </div>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
