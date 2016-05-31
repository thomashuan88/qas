<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- search -->

        <form name="daily_qa_form" id="daily_qa_form" onsubmit="return searchData();">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group contain-datepicker">
                            <label for="date"><?php print $this->lang->line('from'); ?></label>
                            <input type="text" name="date_start" id="date_start" onchange="operator_utilization_searchData();" class="form-control datepicker" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group contain-datepicker">
                            <label for="date"><?php print $this->lang->line('to'); ?></label>
                            <input type="text" name="date_end" id="date_end" onchange="operator_utilization_searchData();" class="form-control datepicker" autocomplete="off" />
                        </div>
                    </div>
                </div>
        </form>

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
                <tbody id="operator-utilization-table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="page_no col-xs-12 pull-right">
        </div>
        <p id="operator_utilization_no_result" style="">No results found.</p>
    </div>
</div>
<div style="display: none;">
    <table class="table table-hover" id="children-table" >
        <thead>
        <tr>
            <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
            <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('quantity'); ?></a></th>
        </tr>
        </thead>
        <tbody id="children-table-data"></tbody>
    </table>
</div>
<script type="text/javascript">

var operator_utilization_paging = {
    offset : 0,
    order_by : 'username',
    sort_order : 'desc',
    search_data : {'username' : '<?php print $member->username; ?>'},
    ajaxUrl: '<?php print base_url('adminpanel/operator_utilization/get_report'); ?>'
}

var operator_utilization_searchData = function() {
    var date_start = $('#date_start').val();
    var date_end = $('#date_end').val();

    paging.search_data = {
        date_start : date_start,
        date_end : date_end,
        username :'<?php print $member->username; ?>'
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

                $.each( data.message, function( key, value ) {
                    html +='<tr>';
                    html +='<td>' + value.username + '</td>';
                    html +='<td>' + value.quantity + '</td>';
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

var operator_utilization_drawTable = function (data) {
    var html = '';

    if (data.length != 0) {
        $('#data_table').css('display', 'block');
        $('#operator_utilization_no_result').css('display', 'none');
    } else {
        $('#data_table').css('display', 'none');
        $('#operator_utilization_no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {
        html +='<tr>';
        html +='<td>' + key + '</td>';
        if (value['quantity'] === undefined || value['quantity'] === '') {
            html +='<td>N/A</td>';
        } else {
            html +='<td>' + value['quantity'] + '</td>';
        }
        if (value['percentage'] === undefined || value['percentage'] === '' ) {
            html +='<td>N/A</td>';
        } else {
            html +='<td>' + value['percentage'] + '%</td>';
        }
        html +='<td>' + value['leader'] + '</td>';
        html +='<td><a href="javascript:void(0)"  onclick="getDownline(\'' + key + '\')" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Details"><i class="fa fa-eye"></i></a></td>';
        html +='</tr>';
    });

    $('#operator-utilization-table-data').html(html);
}

</script>
