<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- search -->

    <form name="daily_qa_form" id="daily_qa_form" onsubmit="return searchData();">
            <div class="row">
                <div class="col-sm-2 pull-right">
                    <button type="button" name="daily_qa_export" id="daily_qa_export" class="btn btn-default btn-md" style="margin-right: 18px;"><i class="fa fa-upload"></i> &nbsp; <?php print $this->lang->line('export'); ?></button>
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
        <div class="table-responsive" id='dailyqa_table' style="">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('daily_qa_id')"><i dataname="daily_qa_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('date')"><i dataname="date" class="table-th"></i> <?php print $this->lang->line('date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('yes')"><i dataname="yes" class="table-th"></i> <?php print $this->lang->line('yes'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('no')"><i dataname="no" class="table-th"></i><?php print $this->lang->line('no'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('csi')"><i dataname="csi" class="table-th"></i> CSI </a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('art')"><i dataname="art" class="table-th"></i> ART </a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('aht')"><i dataname="aht" class="table-th"></i> AHT</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('quantity')"><i dataname="quantity" class="table-th"></i> <?php print $this->lang->line('quantity'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_date')"><i dataname="import_date" class="table-th"></i> <?php print $this->lang->line('import_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_by')"><i dataname="import_by" class="table-th"></i> <?php print $this->lang->line('import_by'); ?></a></th>
                </tr>
                </thead>
                <tbody id="daily-qa-table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="page_no col-xs-12 pull-right">
        </div>
        <p id="daily_qa_no_result" style="">No results found.</p>
    </div>
</div>


<script type="text/javascript">

$("#daily_qa_export").click(function(){
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

    window.open('<?php print base_url('adminpanel/daily_qa/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});

var daily_qa_paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {'username' : '<?php print $member->username; ?>'},
    ajaxUrl: '<?php print base_url('adminpanel/daily_qa/get_report'); ?>'
}


var daily_qa_searchData = function() {
    var new_Date = $('#date').val();
    paging.search_data = {
        date : new_Date,
        username :'<?php print $member->username; ?>'
    };

    getNewData();

    return false;
}

var daily_qa_drawTable = function (data) {
    var html = '';
    if (data.length != 0) {
        $('#dailyqa_table').css('display', 'block');
        $('#daily_qa_no_result').css('display', 'none');
    } else {
        $('#dailyqa_table').css('display', 'none');
        $('#daily_qa_no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {

        var dateDate = new Date(value['date']) ;
        var dateYMD = dateDate.getFullYear() + '/' + (dateDate.getMonth() + 1) + '/' + dateDate.getDate();

        var importDate = new Date(value['import_date']) ;
        var importYMD =  importDate.getFullYear() + '/' + (importDate.getMonth() + 1) + '/' + importDate.getDate();
        if(importDate.getHours() >12 ) { var p = 'PM'} else {var p =  'AM'};
        var importHSi = (importDate.getHours() % 12 || 12) + ':' + importDate.getMinutes() +  ' ' + p ;

        html +='<tr data_id="' + value['daily_qa_id'] + '">';
        html +='<td>' + value['daily_qa_id'] + '</td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + dateYMD + '</td>';
        html +='<td>' + value['yes'] + '</td>';
        html +='<td>' + value['no'] + '</td>';
        html +='<td>' + value['csi'] + '</td>';
        html +='<td>' + value['art'] + '</td>';
        html +='<td>' + value['aht'] + '</td>';
        html +='<td>' + value['quantity'] + '</td>';
        html +='<td>' + importYMD + '<br />' + importHSi + '</td>';
        html +='<td>' + value['import_by'] + '</td>';
        html +='</tr>';
    });

    $('#daily-qa-table-data').html(html);
}

</script>
