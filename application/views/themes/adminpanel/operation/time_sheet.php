<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="row">
    <div class="col-md-2">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> expand</span> search <i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
    <div class="col-md-10" style="text-align: right;">
        <a href="<?php print base_url() . "adminpanel/operation/time_sheet_insert/" ?>">
            <button type="button" class="btn btn-primary">
                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
            </button>
        </a>
    </div>
</div>

<form name="daily_qa_form" id="daily_qa_form" onsubmit="return searchData();">
    <div id="search_wrapper" class="collapse in">
        <div class="pd-15 bg-primary mg-t-15 mg-b-10">
            <h2 class="text-uppercase mg-t-0">
                <?php print $this->lang->line('search_time_sheet'); ?>
            </h2>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="created_by"><?php print $this->lang->line('submit_by'); ?></label>
                        <input type="text" name="created_by" id="created_by" class="form-control" value="<?php print $this->session->flashdata('created_by'); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="submit_time_start"><?php print $this->lang->line('submit_time_from'); ?></label>
                        <input type="text" name="submit_time_start" id="submit_time_start" class="form-control datetimepicker" value="<?php print $this->session->flashdata('submit_time_start'); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="submit_time_end"><?php print $this->lang->line('submit_time_to'); ?></label>
                        <input type="text" name="submit_time_end" id="submit_time_end" class="form-control datetimepicker" value="<?php print $this->session->flashdata('submit_time_end'); ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mg-b-20">
            <div class="col-xs-12 clearfix">
                <button type="submit" name="time_sheet_search_submit" id="time_sheet_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
                    <i class="fa fa-check pd-r-5"></i>&nbsp;<?php print $this->lang->line('search'); ?>
                </button>
            </div>
        </div>
    </div>
</form>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="mg-b-10">
            <h4 class="text-uppercase f900">
                <?php print  $this->lang->line('total_time_sheet') . "&nbsp;:&nbsp;"; ?><span id="total-rows"></span>
            </h4>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><a href="javascript:void(0)" onclick="chgOrder('time_sheet_id')"><i dataname="time_sheet_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('shift')"><i dataname="shift" class="table-th"></i> <?php print $this->lang->line('shift'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('remarks')"><i dataname="remarks" class="table-th"></i> <?php print $this->lang->line('remarks'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('created_time')"><i dataname="created_time" class="table-th"></i> <?php print $this->lang->line('submit_time'); ?></a></th>
                        <th><a href="javascript:void(0)"><?php print $this->lang->line('action'); ?></a></th>
                    </tr>
                </thead>
                <tbody id="table-data"></tbody>
            </table>
        </div>
        <div id="pager" class="col-xs-12 pull-right"></div>
        <p id="no_result" style=""><?php print $this->lang->line('no_result'); ?></p>
    </div>
</div>
<script type="text/javascript">
    var paging = {
        offset : 0,
        order_by : 'time_sheet_id',
        sort_order : 'desc',
        search_data : {},
        ajaxUrl: "<?php print base_url('adminpanel/operation/get_time_sheet'); ?>"
    };

    var searchData = function() {
        paging.search_data = {
            created_by : $('#created_by').val(),
            submit_time_start : $('#submit_time_start').val(),
            submit_time_end : $('#submit_time_end').val()
        };
        getNewData();
        return false;
    };

    var drawTable = function (data) {
        var html ='';

        if (data.length != 0) {
            $('#dailyqa_table').css('display', 'block');
            $('#no_result').css('display', 'none');
        } else {
            $('#dailyqa_table').css('display', 'none');
            $('#no_result').css('display', 'block');
        }

        $.each( data, function( key, value ) {
            html +='<tr>';
            html +='<td>' + value['time_sheet_id'] + '</td>';
            html +='<td>' + value['shift'] + '</td>';
            html +='<td>' + value['remarks'] + '</td>';
            html +='<td>' + value['created_time'] + '</td>';
            html +='<td style="white-space: nowrap;"><a href="<?php print base_url('adminpanel/operation/time_sheet_details'); ?>/'+value['time_sheet_id']+'" class="btn btn-success btn-circle" title="details" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></a>';
            html +='<a href="<?php print base_url('adminpanel/operation/time_sheet_delete'); ?>/'+value['time_sheet_id']+'" class="btn btn-danger btn-circle delete" title="delete" data-toggle="tooltip" data-placement="top" data-method="DELETE"><i class="fa fa-trash"></i></a></td>';
            html +='</tr>';
        });

        $('#table-data').html(html);
    }
</script>