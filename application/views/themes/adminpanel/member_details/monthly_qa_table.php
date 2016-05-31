<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<!-- search -->
        <form name="monthly_qa_form" id="monthly_qa_form" onsubmit="return searchData();">
                <div class="row ">
                    <div class="col-sm-2 pull-right">
                        <button type="button" name="monthly_qa_export" id="monthly_qa_export" class="btn btn-default btn-md" style="margin-right: 18px;"><i class="fa fa-upload"></i> &nbsp; <?php print $this->lang->line('export'); ?></button>

                    </div>
                    <div class="col-sm-3 ">
                        <div class="form-group contain-datepicker">
                            <input type="text" name="import_date" id="import_date" class="form-control datepicker" onchange="monthly_qa_searchData();" autocomplete="off" />
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
                    <th><a href="javascript:void(0)" onclick="chgOrder('monthly_qa_id')"><i dataname="monthly_qa_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('month')"><i dataname="month" class="table-th"></i> <?php print $this->lang->line('month'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('typing_test')"><i dataname="typing_test" class="table-th"></i> <?php print $this->lang->line('typing_test'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('monthly_assessment')"><i dataname="monthly_assessment" class="table-th"></i><?php print $this->lang->line('monthly_assessment'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('leader'); ?> </a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_date')"><i dataname="import_date" class="table-th"></i> <?php print $this->lang->line('import_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_by')"><i dataname="import_by" class="table-th"></i> <?php print $this->lang->line('import_by'); ?></a></th>
                </tr>
                </thead>
                <tbody id="monthly-qa-table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="page_no col-xs-12 pull-right">
        </div>
        <p id="monthly_qa_no_result" style="">No results found.</p>
    </div>
</div>

<script type="text/javascript">

var monthly_qa_paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {'username' : '<?php print $member->username; ?>'},
    ajaxUrl: '<?php print base_url('adminpanel/monthly_qa/get_report'); ?>'
}

$("#monthly_qa_export").click(function(){
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
    window.open('<?php print base_url('adminpanel/monthly_qa/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});


var monthly_qa_searchData = function() {
    var new_importDate = $('#import_date').val();

    paging.search_data = {
        import_date : new_importDate,
        username :'<?php print $member->username; ?>'

    };
    getNewData();

    return false;
}


var monthly_qa_drawTable = function (data) {
    var html = '';
    if (data.length != 0) {
        $('#content_data_table').css('display', 'block');
        $('#monthly_qa_no_result').css('display', 'none');
    } else {
        $('#content_data_table').css('display', 'none');
        $('#monthly_qa_no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {

        var importDate = new Date(value['import_date']) ;
        var importYMD =  importDate.getFullYear() + '/' + (importDate.getMonth() + 1) + '/' + importDate.getDate();
        if(importDate.getHours() >12 ) { var p = 'PM'} else {var p =  'AM'};
        var importHSi = (importDate.getHours() % 12 || 12) + ':' + importDate.getMinutes() +  ' ' + p ;

        html +='<tr data_id="' + value['monthly_qa_id'] + '">';
        html +='<td>' + value['monthly_qa_id'] + '</td>';
        html +='<td>' + value['month'] + '</td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['typing_test'] + '</td>';
        html +='<td>' + value['monthly_assessment'] + '</td>';
        html +='<td>' + value['leader'] + '</td>';
        html +='<td>' + importYMD + '<br />' + importHSi + '</td>';
        html +='<td>' + value['import_by'] + '</td>';
        html +='</tr>';
    });

    $('#monthly-qa-table-data').html(html);
}

</script>
