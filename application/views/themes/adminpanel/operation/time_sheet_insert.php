<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/time_sheet_insert/', array('id' => 'time_sheet_insert_form')) . "\r\n"; ?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label style="color:red; font-size:14px;">*&nbsp;<span style="font-style: italic; font-size: 12px;"><?php print $this->lang->line('required_fields'); ?></span></label>
            </div>
            <div class="form-group">
                <label for="product"><?php print $this->lang->line('product'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <?php print $product_list; ?>
            </div>
            <div class="form-group">
                <label for="shift"><?php print $this->lang->line('shift'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <?php print $shift_list; ?>
            </div>
            <div class="form-group contain-datepicker">
                <label for="time_start"><?php print $this->lang->line('time_start'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <input type="text" class="form-control datetimepicker" id="time_start" name="time_start" value="<?php print $this->session->flashdata('time_start');?>" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required autocomplete="off"/>
            </div>
            <div class="form-group contain-datepicker">
                <label for="time_end"><?php print $this->lang->line('time_end'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <input type="text" class="form-control datetimepicker" id="time_end" name="time_end" value="<?php print $this->session->flashdata('time_end');?>" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required autocomplete="off"/>
            </div>
            <div class="form-group">
                <label for="title"><?php print $this->lang->line('remarks_title'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php print $this->session->flashdata('title');?>" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required autocomplete="off"/>
            </div>
            <div class="form-group">
                <label for="remarks"><?php print $this->lang->line('remark'); ?></label>
                <label style="color:red; font-size:14px;">*</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="4" style="resize: vertical;" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required><?php print $this->session->flashdata('remarks');?></textarea>
            </div>
            <div>
                <button type="submit" name="time_sheet_insert_submit" id="time_sheet_insert_submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
                <a href="<?php print base_url() . "adminpanel/operation/time_sheet/"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
            </div>
        </div>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
