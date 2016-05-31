<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> <?php print $this->lang->line('expand'); ?></span> <?php print $this->lang->line('search'); ?> <i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
</div>
<!-- search -->
<div id="search_container">
    <div id="search_wrapper" class="collapse <?php print Settings_model::$db_config['search_section']; ?>">
        <form name="daily_qa_form" id="daily_qa_form" onsubmit="return searchData();">
            <div class="pd-15 bg-primary mg-t-15 mg-b-10">
                <h2 class="text-uppercase mg-t-0">
                    <?php print $this->lang->line('search_record'); ?>
                </h2>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="username"><?php print $this->lang->line('username'); ?></label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="leader"><?php print $this->lang->line('leader'); ?></label>
                            <input type="text" name="leader" id="leader" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group contain-datepicker">
                            <label for="date"><?php print $this->lang->line('from'); ?></label>
                            <input type="text" name="date_start" id="date_start" class="form-control datepicker" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group contain-datepicker">
                            <label for="date"><?php print $this->lang->line('to'); ?></label>
                            <input type="text" name="date_end" id="date_end" class="form-control datepicker" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mg-b-20">
                <div class="col-xs-12 clearfix">
                    <button type="submit" name="member_search_submit" id="member_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
                        <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('search'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="table-responsive" id='data_table' style="">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('quantity')"><i dataname="quantity" class="table-th"></i> <?php print $this->lang->line('quantity'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('percentage')"><i dataname="percentage" class="table-th"></i> <?php print $this->lang->line('percentage'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('leader'); ?></a></th>
                    <th><a href="javascript:void(0)"><?php print $this->lang->line('action'); ?></a></th>
                </tr>
                </thead>
                <tbody id="table-data">
                
                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="col-xs-12 pull-right">
        </div>
        <p id="no_result" style=""><?php print $this->lang->line('no_result'); ?></p>
    </div>
</div>
<div style="display: none;">
    <table class="table table-hover" id="children-table" >
        <thead>
        <tr>
            <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
            <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('quantity'); ?></a></th>
            <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('percentage'); ?></a></th>
        </tr>
        </thead>
        <tbody id="children-table-data"></tbody>
    </table>
</div>
<script type="text/javascript">

var permission = <?php echo json_encode($permission, true); ?>;
var paging = {
    offset : 0,
    order_by : 'username',
    sort_order : 'desc',
    search_data : {},
    ajaxUrl: '<?php print base_url('adminpanel/operator_utilization/get_report'); ?>'
}
$(function(){
    getNewData();
    setHeaderIcon();
});
var searchData = function() {
    var date_start = $('#date_start').val();
    var date_end = $('#date_end').val();
    var username = $('#username').val();
    var leader = $('#leader').val();

    paging.search_data = {
        date_start : date_start,
        date_end : date_end,
        username : username,
        leader : leader,
    };

    getNewData();

    return false;
}

var getDownline = function(leader) {
    var date_start = $('#date_start').val();
    var date_end = $('#date_end').val();

    var data = {
        date_start : date_start,
        date_end : date_end,
        leader : leader,
    };
    $.ajax({
        url: "<?php print base_url('adminpanel/operator_utilization/get_direct_downline_report'); ?>",
        data: { data:JSON.stringify( data  ) },
        type: "post",
        dataType: 'json',
        success: function(data) {
            if ( !data.status ) {
                bootbox.alert(data.message);
            } else {
                var html = '';
                var totalQuantity = 0;

                $.each( data.message, function( key, value ) {
                   totalQuantity += parseInt(value.quantity);
                });

                var average = parseInt(totalQuantity) / parseInt(data.message.length);

                $.each( data.message, function( key, value ) {
                    var percentage = value.quantity / average * 100;
                    html +='<tr>';
                    html +='<td>' + value.username + '</td>';
                    html +='<td>' + value.quantity + '</td>';
                    html +='<td>' + percentage.toFixed(2) + '%</td>';
                    html +='</tr>';
                });

                $('#children-table-data').html(html);

                bootbox.dialog({
                    title: "<?php echo $this->lang->line('operator_utilization_details'); ?>",
                    message: $('#children-table').clone()
                });
            }

        }
    });
}

var drawTable = function (data) {
    var html = '';
    
    if (data.length != 0) {
        $('#data_table').css('display', 'block');
        $('#no_result').css('display', 'none');
    } else {
        $('#data_table').css('display', 'none');
        $('#no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {
        html +='<tr>';
        html +='<td>' + key + '</td>';
        if (value['quantity'] === undefined || value['quantity'] === '' || value['quantity'] === 0 ) {
            html +='<td>N/A</td>';
        } else {
            html +='<td>' + value['quantity'] + '</td>';
        }
        if (value['percentage'] === undefined || value['percentage'] === '' || value['quantity'] === 0) {
            html +='<td>N/A</td>';
        } else {
            html +='<td>' + value['percentage'] + '%</td>';
        }
        html +='<td>' + value['leader'] + '</td>';
        html +='<td><a href="javascript:void(0)"  onclick="getDownline(\'' + key + '\')" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Details"><i class="fa fa-eye"></i></a></td>';

        html +='</tr>';
    });

    $('#table-data').html(html);
}

</script>