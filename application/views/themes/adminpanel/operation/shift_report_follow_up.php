<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
    <div class="col-xs-12" style="text-align: right; margin-bottom: 20px;">
<?php if ($add) { ?>
        <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up_insert/" . $report->shift_reports_id; ?>">
            <button type="button" class="btn btn-primary">
                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
            </button>
        </a>       
<?php } ?>
        <a href="<?php print base_url('adminpanel/operation/shift_report') . "?type=session"; ?>">
            <button type="button" class="btn btn-primary">
                <span><i class="fa fa-reply pd-r-5"></i>&nbsp;<?php echo $this->lang->line('back'); ?></span>
            </button>
        </a>
    </div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table class="table ">
                <tr>
                    <td><label><?php print $this->lang->line('product'); ?></label></td>
                    <td><span class="info"><?php print $report->product ?></span></td>
                    <td style="white-space: nowrap;"><label><?php print $this->lang->line('follow_up_by'); ?></label></td>
                    <td><span class="info"><?php print $report->follow_up ?></span></td>
                </tr>
                <tr>
                    <td style="white-space: nowrap;"><label><?php print $this->lang->line('player_name'); ?></label></td>
                    <td><span class="info"><?php print $report->player_name ?></span></td>
                    <td><label><?php print $this->lang->line('shift'); ?></label></td>
                    <td><span class="info"><?php print $report->shift ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('category'); ?></label></td>
                    <td><span class="info"><?php print $report->category_content ?></span></td>
                    <td><label><?php print $this->lang->line('finish_time'); ?></label></td>
                    <td><span class="info"><?php print $report->finish ?></span></td>
                </tr>
                <tr>
                    <td style="white-space: nowrap;"><label><?php print $this->lang->line('sub_category'); ?></label></td>
                    <td><span class="info"><?php print $report->sub_category_content ?></span></td>
                    <td style="white-space: nowrap;"><label><?php print $this->lang->line('submit_by'); ?></label></td>
                    <td><span class="info"><?php print $report->created_by ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('status'); ?></label></td>
                    <td><span class="info"><?php print $report->status ?></span></td>
                    <td style="white-space: nowrap;"><label><?php print $this->lang->line('submit_time'); ?></label></td>
                    <td><span class="info"><?php print $report->created_time ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('remark'); ?></label></td>
                    <td colspan="3"><span class="info"><?php print $report->remarks ?></span></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="mg-b-10">
            <h4 class="text-uppercase f900">
                <?php print  $this->lang->line('total_follow_up_reports') . "&nbsp;:&nbsp;"; ?><span id="total-rows"></span>
            </h4>
        </div>
        <div class="table-responsive" id="shift_report_follow_up_table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><a href="javascript:void(0)" onclick="chgOrder('follow_up_id')"><i dataname="follow_up_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('follow_up')"><i dataname="follow_up" class="table-th"></i> <?php print $this->lang->line('follow_up_by'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('remarks')"><i dataname="remarks" class="table-th"></i> <?php print $this->lang->line('remark'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('status')"><i dataname="status" class="table-th"></i> <?php print $this->lang->line('status'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('created_by')"><i dataname="created_by" class="table-th"></i> <?php print $this->lang->line('submit_by'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('created_time')"><i dataname="created_time" class="table-th"></i> <?php print $this->lang->line('submit_time'); ?></a></th>
                        <th><a href="javascript:void(0)"><?php print $this->lang->line('action'); ?></a>
                    </tr>
                    </thead>
                    <tbody id="table-data"></tbody>
                </table>
            </div>
        <div id="pager" class="col-xs-12 pull-right"></div>
        <p id="no_result"><?php print $this->lang->line('no_result'); ?></p>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        getNewData();
        setHeaderIcon();
    });

    var paging = {
        offset: 0,
        order_by: 'follow_up_id',
        sort_order: 'desc',
        search_data: {},
        permission: {},
        ajaxUrl: "<?php print base_url('adminpanel/operation/get_shift_report_follow_up') . '/' . $report->shift_reports_id; ?>"
    };

    var deleteData = function (id) {
        bootbox.confirm(delete_message, function (confirmed) {
            if (confirmed) {
                $.ajax({
                    url: "/adminpanel/operation/shift_report_follow_up_delete/" + id,
                    type: "post",
                    success: function (data) {
                        getNewData();
                        bootbox.alert(data);
                    },
                    error: function (data) {
                        bootbox.alert(data);
                    }
                });
            }
        });
    };

    var drawTable = function (data) {
        var html = '';

        if (data.length != 0) {
            $('#shift_report_follow_up_table').css('display', 'block');
            $('#no_result').css('display', 'none');
        } else {
            $('#shift_report_follow_up_table').css('display', 'none');
            $('#no_result').css('display', 'block');
        }

        $.each(data, function (key, value) {
            html += '<tr>';
            html += '<td>' + value['follow_up_id'] + '</td>';
            html += '<td>' + value['follow_up'] + '</td>';
            html += '<td>' + value['remarks'] + '</td>';
            html += '<td>' + value['status'] + '</td>';
            html += '<td>' + value['created_by'] + '</td>';
            html += '<td>' + value['created_time'] + '</td>';
            html += '<td style="white-space: nowrap;">';
            if (paging.permission['edit']) {
                html += '<a href="<?php print base_url('adminpanel/operation/shift_report_follow_up_edit') . '/' . $report->shift_reports_id . '/';?>' + value['follow_up_id'] + '" class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit')?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square"></i></a>';
            }
            if (paging.permission['delete']) {
                html += '<a href="#" onclick="deleteData(' + value['follow_up_id'] + ');" class="btn btn-danger btn-circle" title="<?php print $this->lang->line('delete')?>" data-toggle="tooltip" data-placement="top" data-original-title="DELETE" data-method="DELETE"><i class="fa fa-trash"></i></a>';
            }
            html += '</td></tr>';
        });

        $('#table-data').html(html);
    }
</script>