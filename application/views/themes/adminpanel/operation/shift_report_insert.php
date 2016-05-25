<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/shift_report_insert', 'class="form-confirm"') . "\r\n"; ?>
<div class="col-md-12">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="product"><?php print $this->lang->line('product'); ?></label>
                    <?php print $product_list; ?>
                </div>
                <div class="form-group">
                    <label for="category_id"><?php print $this->lang->line('category'); ?></label>
                    <?php print $category_list; ?>
                </div>
                <div class="form-group">
                    <label for="sub_category_id"><?php print $this->lang->line('sub_category'); ?></label>
                    <?php print $sub_category_list; ?>
                </div>
                <div class="form-group">
                    <label for="player_name"><?php print $this->lang->line('player_name'); ?></label>
                    <input type="text" class="form-control" id="player_name" name="player_name" value="<?php print $this->session->flashdata('player_name');?>">
                </div>
                <div class="form-group">
                    <label for="status"><?php print $this->lang->line('status'); ?></label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" <?php print ($this->session->flashdata('status') == 'active') ? "selected" : ""; ?>><?php print $this->lang->line('active'); ?></option>
                        <option value="inactive" <?php print ($this->session->flashdata('status') == 'inactive') ? "selected" : ""; ?>><?php print $this->lang->line('inactive'); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="follow_up"><?php print $this->lang->line('follow_up_by'); ?></label>
                    <input type="text" class="form-control" id="follow_up" name="follow_up" value="<?php print $this->session->flashdata('follow_up');?>">
                </div>
                <div class="form-group">
                    <label for="shift"><?php print $this->lang->line('shift'); ?></label>
                    <?php print $shift_list; ?>
                </div>
                <div class="form-group">
                    <label for="finish"><?php print $this->lang->line('finish_time'); ?></label>
                    <input type="text" class="form-control datetimepicker" id="finish" name="finish" value="<?php print $this->session->flashdata('finish');?>">
                </div>
                <div class="form-group">
                    <label for="remarks"><?php print $this->lang->line('remark'); ?></label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="4" style="resize: vertical;"><?php print $this->session->flashdata('remarks');?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div>
        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
        <a href="<?php print base_url() . "adminpanel/operation/shift_report/"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
