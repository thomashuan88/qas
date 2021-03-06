<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/operation/information_update_edit/' . $report->shift_reports_id, 'id="information_update_edit_form"') . "\r\n"; ?>
<div class="col-md-12">
    <div class="col-md-6">
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
                    <label for="category_id"><?php print $this->lang->line('category'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <?php print $category_list; ?>
                </div>
                <div class="form-group">
                    <label for="sub_category_id"><?php print $this->lang->line('sub_category'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <div id="sub_category_id"><?php print $sub_category_list; ?></div>
                </div>
                <div class="form-group">
                    <label for="status"><?php print $this->lang->line('status'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <select class="form-control" id="status" name="status" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled required>
                        <option value="update" <?php print ($report->status == 'update') ? "selected" : ""; ?>><?php print $this->lang->line('update');?></option>
                        <option value="updated" <?php print ($report->status == 'updated') ? "selected" : ""; ?>><?php print $this->lang->line('done');?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body" style="padding-bottom: 15px;">
                <div class="form-group">
                    <label for="player_name"><?php print $this->lang->line('player_name'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <input type="text" class="form-control" id="player_name" name="player_name" value="<?php print $report->player_name?>" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="shift"><?php print $this->lang->line('shift'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <?php print $shift_list; ?>
                </div>
                <div class="form-group">
                    <label for="finish"><?php print $this->lang->line('finish_time'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <input type="text" class="form-control datetimepicker" id="finish" name="finish" value="<?php print date('Y/m/d H:i', strtotime($report->finish)); ?>" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="remarks"><?php print $this->lang->line('remark'); ?></label>
                    <label style="color:red; font-size:14px;">*</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="3" style="resize: vertical;" data-parsley-trigger="change keyup focusout" data-parsley-errors-messages-disabled required><?php print $report->remarks?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div>
        <button type="submit" id="information_update_edit_submit" name="information_update_edit_submit" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i>&nbsp;<?php print $this->lang->line('save'); ?></button>
        <a href="<?php print base_url() . "adminpanel/operation/information_update?type=session"; ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>
<script type="text/javascript">
    $(function(){
        var sub_id = $("select#sub_category_id option:selected").val();
        $('#category_id').on('change', function (e) {
            var id = $(this).val();
            $.ajax({
                url: "/adminpanel/operation/ajax_get_sub_category_list/" + id + "/" + sub_id,
                type: "post",
                success: function (data) {
                    $("div#sub_category_id").html(data);
                },
                error: function () {
                    bootbox.alert("something wrong");
                }
            });
        });
    });
</script>
