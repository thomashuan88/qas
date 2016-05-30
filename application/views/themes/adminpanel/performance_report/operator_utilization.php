<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-compress pd-r-6"></i> <?php print $this->lang->line('collapse'); ?></span> <i class="fa fa-search pd-l-5"></i>
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
                        <div class="form-group contain-datepicker">
                            <label for="date"><?php print $this->lang->line('date'); ?></label>
                            <input type="text" name="date" id="date" class="form-control datepicker" autocomplete="off" />
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
        <div class="row">
            <div class="col-xs-7">
                <h4 class="text-uppercase f900">
                    <?php print $this->lang->line('total_record'); ?> : <span id="total-rows"></span>
                </h4>
            </div>
        </div>
        <div class="table-responsive" id='dailyqa_table' style="">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('')"><i dataname="" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('')"><i dataname="" class="table-th"></i> <?php print $this->lang->line('quantity'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('')"><i dataname="" class="table-th"></i> <?php print $this->lang->line('percentage'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('')"><i dataname="" class="table-th"></i> <?php print $this->lang->line('leader'); ?></a></th>
                </tr>
                </thead>
                <tbody id="table-data">
                
                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="col-xs-12 pull-right">
        </div>
        <p id="no_result" style="">No results found.</p>
    </div>
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
    var new_Date = $('#date').val();
    var new_username = $('#username').val();

    paging.search_data = {
        date : new_Date,
        username : new_username,
    };

    getNewData();

    return false;
}

var drawTable = function (data) {
    console.log(data);
    // var html = '';
    // if (data.length != 0) {
    //     $('#dailyqa_table').css('display', 'block');
    //     $('#no_result').css('display', 'none');
    // } else {
    //     $('#dailyqa_table').css('display', 'none');
    //     $('#no_result').css('display', 'block');
    // }

    // $.each( data, function( key, value ) {
    //     var dateDate = new Date(value['date']) ;
    //     var dateYMD = dateDate.getFullYear() + '/' + (dateDate.getMonth() + 1) + '/' + dateDate.getDate();

    //     var importDate = new Date(value['import_date']) ;
    //     var importYMD =  importDate.getFullYear() + '/' + (importDate.getMonth() + 1) + '/' + importDate.getDate();
    //     if(importDate.getHours() >12 ) { var p = 'PM'} else {var p =  'AM'};
    //     var importHSi = (importDate.getHours() % 12 || 12) + ':' + importDate.getMinutes() +  ' ' + p ;

    //     html +='<tr data_id="' + value['daily_qa_id'] + '">';
    //     html +='<td>' + value['daily_qa_id'] + '</td>';
    //     html +='<td>' + value['username'] + '</td>';
    //     html +='<td>' + dateYMD + '</td>';
    //     html +='<td>' + value['yes'] + '</td>';
    //     html +='<td>' + value['no'] + '</td>';
    //     html +='<td>' + value['csi'] + '</td>';
    //     html +='<td>' + value['art'] + '</td>';
    //     html +='<td>' + value['aht'] + '</td>';
    //     html +='<td>' + value['quantity'] + '</td>';
    //     html +='<td>' + importYMD + '<br />' + importHSi + '</td>';
    //     html +='<td>' + value['import_by'] + '</td>';

    //     if ( permission.delete ) {
    //         html +='<td style="white-space: nowrap;"><a href="#" onclick="deleteData(' + value['daily_qa_id'] + ')" class="btn btn-danger btn-circle" title="<?php print $this->lang->line('delete')?>" data-toggle="tooltip" data-placement="top" data-original-title="" data-method="DELETE"><i class="fa fa-trash"></i></a></td>';
    //     }
        
    //     html +='</tr>';
    // });

    // $('#table-data').html(html);
}

</script>