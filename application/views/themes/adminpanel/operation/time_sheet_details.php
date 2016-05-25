<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table class="table ">
                <tr>
                    <td><label><?php print $this->lang->line('id'); ?></label></td>
                    <td><span class="info"><?php print $time_sheet->time_sheet_id ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('shift'); ?></label></td>
                    <td><span class="info"><?php print $time_sheet->shift ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('remark'); ?></label></td>
                    <td><span class="info"><?php print $time_sheet->remarks ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('submit_by'); ?></label></td>
                    <td><span class="info"><?php print $time_sheet->created_by ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('submit_time'); ?></label></td>
                    <td><span class="info"><?php print $time_sheet->created_time ?></span></td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <a href="<?php print base_url('adminpanel/operation/time_sheet/'); ?>"><button type="button" class="btn btn-danger"><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php print $this->lang->line('cancel'); ?></button></a>
    </div>
</div>
