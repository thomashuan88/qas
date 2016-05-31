<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- search -->

        <form name="ops_monthly_qa_f" id="ops_monthly_qa_f" onsubmit="return searchData();">
            <div class="row ">
                <div class="col-sm-2 pull-right">
                    <button type="button" name="ops_monthly_export" id="ops_monthly_export" class="btn btn-default btn-md" style="margin-right: 18px;"><i class="fa fa-upload"></i> &nbsp; <?php print $this->lang->line('export'); ?></button>
                </div>
                <div class="col-sm-3 ">
                    <div class="form-group contain-datepicker">
                        <input type="text" name="import_date" id="import_date" class="form-control datepicker" onchange="ops_monthly_searchData();" autocomplete="off" />
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
                    <th><a href="javascript:void(0)" onclick="chgOrder('ops_monthly_id')"><i dataname="ops_monthly_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('month')"><i dataname="month" class="table-th"></i> <?php print $this->lang->line('month'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('al')"><i dataname="al" class="table-th"></i>AL</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('ml')"><i dataname="ml" class="table-th"></i>ML</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('el')"><i dataname="el" class="table-th"></i>EL</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('ul')"><i dataname="ul" class="table-th"></i>UL</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('vw')"><i dataname="vw" class="table-th"></i>VW</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('fw')"><i dataname="fw" class="table-th"></i>FW</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('leader'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_date')"><i dataname="import_date" class="table-th"></i> <?php print $this->lang->line('import_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_by')"><i dataname="import_by" class="table-th"></i> <?php print $this->lang->line('import_by'); ?></a></th>
                </tr>
                </thead>
                <tbody id="ops-monthly-table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="page_no col-xs-12 pull-right">
        </div>
        <p id="ops_monthly_no_result" style="">No results found.</p>
    </div>
</div>


<script type="text/javascript">

var ops_monthly_paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {'username' : '<?php print $member->username; ?>'},
    ajaxUrl: '<?php print base_url('adminpanel/ops_monthly/get_report'); ?>'
}


$("#ops_monthly_export").click(function(){
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

    window.open('<?php print base_url('adminpanel/ops_monthly/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});


var ops_monthly_searchData = function() {
    var new_importDate = $('#import_date').val();

    paging.search_data = {
        import_date : new_importDate,
        username :'<?php print $member->username; ?>'
    };

    getNewData();

    return false;
}


var ops_monthly_drawTable = function (data) {
    var html = '';
    if (data.length != 0) {
        $('#content_data_table').css('display', 'block');
        $('#ops_monthly_no_result').css('display', 'none');
    } else {
        $('#content_data_table').css('display', 'none');
        $('#ops_monthly_no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {

        var importDate = new Date(value['import_date']) ;
        var importYMD =  importDate.getFullYear() + '/' + (importDate.getMonth() + 1) + '/' + importDate.getDate();
        // var importHSi = importDate.getHours()  + ':' + importDate.getMinutes() + ':' +  importDate.getSeconds()

        if(importDate.getHours() > 12 ) { var p = 'PM';} else {var p =  'AM';}

        var importHSi = (importDate.getHours() % 12 || 12) + ':' + importDate.getMinutes() + ' ' + p ;
        html +='<tr data_id="' + value['ops_monthly_id'] + '">';
        html +='<td>' + value['ops_monthly_id'] + '</td>';
        html +='<td>' + value['month'] + '</td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['al'] + '</td>';
        html +='<td>' + value['ml'] + '</td>';
        html +='<td>' + value['el'] + '</td>';
        html +='<td>' + value['ul'] + '</td>';
        html +='<td>' + value['vw'] + '</td>';
        html +='<td>' + value['fw'] + '</td>';
        html +='<td>' + value['leader'] + '</td>';
        html +='<td>' + value['import_by'] + '</td>';
        html +='<td>' + importYMD + '<br />' + importHSi + '</td>';
        html +='</tr>';
    });

    $('#ops-monthly-table-data').html(html);
}

</script>
