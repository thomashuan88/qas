<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="row">
    <div class="col-xs-2">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> expand</span> search <i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
    <?php if ($add) { ?>
        <div class="col-xs-10" style="text-align: right;">
            <a href="<?php print base_url() . "adminpanel/operation/question_type_insert/" ?>">
                <button type="button" class="btn btn-primary">
                    <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                </button>
            </a>
        </div>
    <?php } ?>
</div>

<form name="question_type_form" id="question_type_form" onsubmit="return searchData();">
    <div id="search_wrapper" class="collapse in">
        <div class="pd-15 bg-primary mg-t-15 mg-b-10">
            <h2 class="text-uppercase mg-t-0">
                <?php print $this->lang->line('search_question_type'); ?>
            </h2>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="id"><?php print $this->lang->line('id'); ?></label>
                        <input type="text" name="id" id="id" class="form-control" value="<?php print $this->session->flashdata('id'); ?>" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="content"><?php print $this->lang->line('content'); ?></label>
                        <input type="text" name="content" id="content" class="form-control" value="<?php print $this->session->flashdata('content'); ?>" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-sm-3">
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
        <div class="row mg-b-20">
            <div class="col-xs-12 clearfix">
                <button type="submit" name="question_type_search_submit" id="question_type_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
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
                <?php print  $this->lang->line('total_question_type') . "&nbsp;:&nbsp;"; ?><span id="total-rows"></span>
            </h4>
        </div>
        <div class="table-responsive" id="question_type_table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><a href="javascript:void(0)" onclick="chgOrder('category_group_id')"><i dataname="category_group_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('content')"><i dataname="content" class="table-th"></i> <?php print $this->lang->line('content'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('status')"><i dataname="status" class="table-th"></i> <?php print $this->lang->line('status'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('created_by')"><i dataname="created_by" class="table-th"></i> <?php print $this->lang->line('submit_by'); ?></a></th>
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
        order_by: 'category_group_id',
        sort_order: 'desc',
        search_data: {},
        permission: {},
        ajaxUrl: "<?php print base_url('adminpanel/operation/get_question_type'); ?>"

    };

    var searchData = function () {
        paging.search_data = {
            id: $('#id').val(),
            content: $('#content').val(),
            status: $('#status').val()
        };
        getNewData();
        return false;
    };

    var deleteData = function (id) {
        bootbox.confirm(delete_message, function (confirmed) {
            if (confirmed) {
                $.ajax({
                    url: "/adminpanel/operation/time_sheet_delete/" + id,
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
            $('#question_type_table').css('display', 'block');
            $('#no_result').css('display', 'none');
        } else {
            $('#question_type_table').css('display', 'none');
            $('#no_result').css({display: 'block', color: '#FF0000'});
        }

        $.each(data, function (key, value) {
            html += '<tr>';
            html += '<td>' + value['category_group_id'] + '</td>';
            html += '<td>' + value['content'] + '</td>';
            html += '<td>' + value['status'] + '</td>';
            html += '<td>' + value['created_by'] + '</td>';
            html += '<td>' + value['created_time'] + '</td>';
            html += '<td style="white-space: nowrap;">';
            if (paging.permission['edit']) {
                html += '<a href="<?php print base_url('adminpanel/operation/question_type_edit'); ?>/' + value['category_group_id'] + '" class="btn btn-primary btn-circle edit" title="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square"></i></a>';
            }
            if (paging.permission['delete']) {
                html += '<a href="<?php print base_url('adminpanel/operation/question_type_delete'); ?>/' + value['category_group_id'] + '" class="btn btn-danger btn-circle delete" title="delete" data-toggle="tooltip" data-placement="top" data-method="DELETE"><i class="fa fa-trash"></i></a>';
            }
            html += '</td></tr>';
        });

        $('#table-data').html(html);
    }
</script>