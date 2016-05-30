<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="row">
    <div class="col-xs-2">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> expand</span>&nbsp;<?php print $this->lang->line('search'); ?>&nbsp;<i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
    <?php if ($add) { ?>
        <div class="col-xs-10" style="text-align: right;">
            <a href="<?php print base_url() . "adminpanel/operation/information_update_insert/" ?>">
                <button type="button" class="btn btn-primary">
                    <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                </button>
            </a>
        </div>
    <?php } ?>
</div>

<form name="information_update_form" id="information_update_form" onsubmit="return searchData();">
    <div id="search_wrapper" class="collapse <?php print Settings_model::$db_config['search_section']; ?>">
        <div class="pd-15 bg-primary mg-t-15 mg-b-10">
            <h2 class="text-uppercase mg-t-0">
                <?php print $this->lang->line('search_information_update'); ?>
            </h2>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="id"><?php print $this->lang->line('id'); ?></label>
                        <input type="text" name="id" id="id" class="form-control" value="<?php print $this->session->flashdata('id'); ?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="product"><?php print $this->lang->line('product'); ?></label>
                        <?php print $product_list; ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="category_id"><?php print $this->lang->line('category'); ?></label>
                        <?php print $category_list; ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="shift"><?php print $this->lang->line('shift'); ?></label>
                        <?php print $shift_list; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="remarks"><?php print $this->lang->line('remark'); ?></label>
                        <input type="text" name="remarks" id="remarks" class="form-control" value="<?php print $this->session->flashdata('remarks'); ?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="status"><?php print $this->lang->line('status'); ?></label>
                        <select name="status" id="status" class="form-control">
                            <option value="all"><?php print $this->lang->line('all'); ?></option>
                            <option value="follow-up" selected><?php print $this->lang->line('follow-up'); ?></option>
                            <option value="done"><?php print $this->lang->line('done'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group contain-datepicker">
                        <label for="submit_time_start"><?php print $this->lang->line('submit_time_from'); ?></label>
                        <input type="text" name="submit_time_start" id="submit_time_start" class="form-control datetimepicker" value="<?php print $this->session->flashdata('submit_time_start'); ?>" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group contain-datepicker">
                        <label for="submit_time_end"><?php print $this->lang->line('submit_time_to'); ?></label>
                        <input type="text" name="submit_time_end" id="submit_time_end" class="form-control datetimepicker" value="<?php print $this->session->flashdata('submit_time_end'); ?>" autocomplete="off"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mg-b-20">
            <div class="col-xs-12 clearfix">
                <button type="submit" name="information_updates_search_submit" id="information_updates_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
                    <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('search'); ?>
                </button>
            </div>
        </div>
    </div>
</form>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="mg-b-10">
            <h4 class="text-uppercase f900">
                <?php print  $this->lang->line('total_information_updates') . "&nbsp;:&nbsp;"; ?><span id="total-rows"></span>
            </h4>
        </div>
        <div class="table-responsive" id="information_update_table">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('shift_reports_id')"><i dataname="shift_reports_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('product')"><i dataname="product" class="table-th"></i> <?php print $this->lang->line('product'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('category_content')"><i dataname="category_content" class="table-th"></i> <?php print $this->lang->line('category'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('remarks')"><i dataname="remarks" class="table-th"></i> <?php print $this->lang->line('remark'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('status')"><i dataname="status" class="table-th"></i> <?php print $this->lang->line('status'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('finish')"><i dataname="finish" class="table-th"></i> <?php print $this->lang->line('finish_time'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('created_time')"><i dataname="created_time" class="table-th"></i> <?php print $this->lang->line('submit_time'); ?></a></th>
                    <th><a href="javascript:void(0)"><?php print $this->lang->line('action'); ?></a></th>
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
        order_by: 'shift_reports_id',
        sort_order: 'desc',
        search_data: {},
        permission: {},
        ajaxUrl: "<?php print base_url('adminpanel/operation/get_information_update') . (!empty($_GET['type']) ? '/' . $_GET['type'] : ''); ?>"
    };

    var searchData = function () {
        paging.search_data = {
            id: $('#id').val(),
            product: $('#product').val(),
            category_id: $('#category_id').val(),
            shift: $('#shift').val(),
            remarks: $('#remarks').val(),
            status: $('#status').val(),
            submit_time_start: $('#submit_time_start').val(),
            submit_time_end: $('#submit_time_end').val()
        };
        getNewData();
        return false;
    };

    var deleteData = function (id) {
        bootbox.confirm(delete_message, function (confirmed) {
            if (confirmed) {
                $.ajax({
                    url: "/adminpanel/operation/shift_report_delete/" + id,
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
            $('#information_update_table').css('display', 'block');
            $('#no_result').css('display', 'none');
        } else {
            $('#information_update_table').css('display', 'none');
            $('#no_result').css({display: 'block', color: '#FF0000'});
        }

        $.each(data, function (key, value) {
            html += '<tr>';
            html += '<td>' + value['shift_reports_id'] + '</td>';
            html += '<td>' + value['product'] + '</td>';
            html += '<td>' + value['category_content'] + '</td>';
            html += '<td>' + value['remarks'] + '</td>';
            html += '<td>' + value['status'] + '</td>';
            html += '<td>' + value['finish'] + '</td>';
            html += '<td>' + value['created_time'] + '</td>';
            html += '<td style="white-space: nowrap;">';
            html += '<a href="<?php print base_url('adminpanel/operation/information_update_follow_up')?>/' + value['shift_reports_id'] + '" class="btn btn-success btn-circle" title="<?php print $this->lang->line('details')?>" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></a>';
            if (paging.permission['edit']) {
                html += '<a href="<?php print base_url('adminpanel/operation/information_update_edit')?>/' + value['shift_reports_id'] + '" class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit')?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square"></i></a>';
            }
            if (paging.permission['delete']) {
                html += '<a href="#" onclick="deleteData(' + value['shift_reports_id'] + ');" class="btn btn-danger btn-circle" title="<?php print $this->lang->line('delete')?>" data-toggle="tooltip" data-placement="top" data-original-title="DELETE" data-method="DELETE"><i class="fa fa-trash"></i></a>';
            }
            html += '</td></tr>';
        });

        $('#table-data').html(html);
    }
</script>