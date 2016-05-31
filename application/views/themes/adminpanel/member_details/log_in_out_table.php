<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<form name="daily_qa_form" id="daily_qa_form" onsubmit="return searchData();">
        <div class="row">
            <div class="col-sm-2 pull-right">
                <button type="button" name="log_in_out_export" id="log_in_out_export" class="btn btn-default btn-md" style="margin-right: 18px;"><i class="fa fa-upload"></i> &nbsp; <?php print $this->lang->line('export'); ?></button>
            </div>
            <div class="col-sm-3 ">
                <div class="form-group contain-datepicker">
                    <input type="text" name="date" id="date" class="form-control datepicker"  onchange="daily_qa_searchData();" autocomplete="off" />
                </div>
            </div>
        </div>
</form>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-7">
                <h4 class="text-uppercase f900">
                    <?php print $this->lang->line('total_record'); ?> : <span class="total-rows" id="total-rows"></span>
                </h4>
            </div>
        </div>
        <div class="table-responsive" id='content_data_table' style="">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('log_time_id')"><i dataname="log_time_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('date')"><i dataname="date" class="table-th"></i> <?php print $this->lang->line('date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th style="white-space: normal;"><a href="javascript:void(0)" onclick="chgOrder('login_time')"><i dataname="login_time" class="table-th"></i><?php print $this->lang->line('login_time'); ?></a></th>
                    <th style="white-space: normal;"><a href="javascript:void(0)" onclick="chgOrder('chat_time')"><i dataname="chat_time" class="table-th"></i><?php print $this->lang->line('chat_time'); ?></a></th>
                    <th style="white-space: normal;"><a href="javascript:void(0)" onclick="chgOrder('time_online')"><i dataname="time_online" class="table-th"></i><?php print $this->lang->line('time_online'); ?></a></th>
                    <th style="white-space: normal;"><a href="javascript:void(0)" onclick="chgOrder('time_online_no_chat')"><i dataname="time_online_no_chat" class="table-th"></i><?php print $this->lang->line('time_online_no_chat'); ?></a></th>
                    <th style="white-space: normal;"><a href="javascript:void(0)" onclick="chgOrder('time_not_available')"><i dataname="time_not_available" class="table-th"></i><?php print $this->lang->line('time_not_available'); ?></a></th>
                    <th style="white-space: normal;"><a href="javascript:void(0)" onclick="chgOrder('time_not_available_chat')"><i dataname="time_not_available_chat" class="table-th"></i><?php print $this->lang->line('time_not_available_chat'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('month')"><i dataname="month" class="table-th"></i> <?php print $this->lang->line('month'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('leader'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_date')"><i dataname="import_date" class="table-th"></i> <?php print $this->lang->line('import_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_by')"><i dataname="import_by" class="table-th"></i> <?php print $this->lang->line('import_by'); ?></a></th>
                </tr>
                </thead>
                <tbody id="log-in-out-table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="page_no col-xs-12 pull-right">
        </div>
        <p id="log_in_out_no_result" style="">No results found.</p>
    </div>
</div>

<script type="text/javascript">

var log_in_out_paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {'username' : '<?php print $member->username; ?>'},
    ajaxUrl: '<?php print base_url('adminpanel/log_in_out/get_report'); ?>'
}

$("#log_in_out_export").click(function(){
    var searchDataUrl = "";
    for (var key in paging.search_data) {
        if (searchDataUrl != "") {
            searchDataUrl += "/";
        }
        searchDataUrl += key + "/";
        if (encodeURIComponent(paging.search_data[key]) == '') {
            searchDataUrl +=  null;
        } else {
            searchDataUrl +=  encodeURIComponent(paging.search_data[key]);
        }
    }

    window.open('<?php print base_url('adminpanel/log_in_out/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});


var log_in_out_searchData = function() {
    var date = $('#date').val();

    paging.search_data = {
        date : date,
        username :'<?php print $member->username; ?>'
    };

    getNewData();

    return false;
}

var log_in_out_drawTable = function (data) {

    var html = '';
    if (data.length != 0) {
        $('#content_data_table').css('display', 'block');
        $('#log_in_out_no_result').css('display', 'none');
    } else {
        $('#content_data_table').css('display', 'none');
        $('#log_in_out_no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {

        var date = new Date(value['date']) ;
        var dateYMD =  date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();

        var importDate = new Date(value['import_date']) ;
        var importYMD =  importDate.getFullYear() + '/' + (importDate.getMonth() + 1) + '/' + importDate.getDate();

        if(importDate.getHours() >12 ) { var p = 'PM'} else {var p =  'AM'};
        var importHSi = (importDate.getHours() % 12 || 12) + ':' + importDate.getMinutes() +  ' ' + p ;

        html +='<tr data_id="' + value['log_time_id'] + '">';
        html +='<td>' + value['log_time_id'] + '</td>';
        html +='<td style="white-space: nowrap;">' + dateYMD + '</td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['login_time'] + '</td>';
        html +='<td>' + value['chat_time'] + '</td>';
        html +='<td>' + value['time_online'] + '</td>';
        html +='<td>' + value['time_online_no_chat'] + '</td>';
        html +='<td>' + value['time_not_available'] + '</td>';
        html +='<td>' + value['time_not_available_chat'] + '</td>';
        html +='<td>' + value['month'] + '</td>';
        html +='<td>' + value['leader'] + '</td>';
        html +='<td>' + value['import_by'] + '</td>';
        html +='<td>' + importYMD + '<br />' + importHSi + '</td>';
        html +='</tr>';
    });

    $('#log-in-out-table-data').html(html);
}

</script>
