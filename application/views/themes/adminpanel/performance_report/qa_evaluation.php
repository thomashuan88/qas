<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>


<button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
    <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> expand</span> search <i class="fa fa-search pd-l-5"></i>
</button>

    <div id="search_wrapper" class="collapse">
        <form name="list_members_form" id="list_members_form" onsubmit="return searchData();">

        <div class="pd-15 bg-primary mg-t-15 mg-b-10">
            <h2 class="text-uppercase mg-t-0">
                <?php print $this->lang->line('search_user'); ?>
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
                        <label for="import_date"><?php print $this->lang->line('import_date'); ?></label>
                        <input type="text" name="import_date" id="import_date" class="form-control datepicker" autocomplete="off" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="email"><?php print $this->lang->line('status'); ?></label>
                        <select name="status" id="status" class="form-control">
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="WIP">WIP</option>
                            <option value="In-Progress">In-Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
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

    <div class="row margin-top-30">

        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-7">
                    <h4 class="text-uppercase f900" style="float:left;">
                        Total Users : <?php //print  $this->lang->line('total_members') .": "; ?> <span id="total-rows"></span>
                    </h4>
                    <div style="float:left;margin-left:15px;margin-top:2px">
                        <button data-loading-text="delete..." class="btn btn-default" id="table_delete_all" name="member_search_submit" type="submit">
                        <i class="fa fa-power-off"></i> Delete all</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" id='qa_listing_table' style="">
            <table class="table table-hover qa_listing">
                <thead>
                <tr>
                    <th width="20"><input type="checkbox" class="table_checkbox_all" /></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('id')"><i dataname="id" class="table-th"></i> <?php print $this->lang->line('chat_log_id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('imported_time')"><i dataname="imported_time" class="table-th"></i> <?php print $this->lang->line('imported_time'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('status')"><i dataname="status" class="table-th"></i> <?php print $this->lang->line('status'); ?></a></th>                    
                    <th><a href="javascript:void(0)" onclick="chgOrder('evaluate_mark')"><i dataname="evaluate_mark" class="table-th"></i> <?php print $this->lang->line('evaluate_mark'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('evaluate_by')"><i dataname="evaluate_by" class="table-th"></i><?php print $this->lang->line('evaluate_by'); ?></a></th>

                    <th><a href="javascript:void(0)" onclick="#"><i  class="table-th"></i> <?php print $this->lang->line('action'); ?></a></th>

                </tr>
                </thead>
                <tbody id="table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <?php print form_close() ."\r\n"; ?>
        <div id="pager" class="col-xs-12 pull-right">
        </div>
        <p id="no_result" style="">No results found.</p>
        </div>
    </div>

<script>
$(document).ready(function($){
    $('#js-search').click();
    getNewData(qas_app.after_render_table);
    
});

qas_app.after_render_table = function() {
    $('.table_checkbox_all').click(function(){
        // if ($(this).is(':checked')){
        //     $('.table_checkbox_each').click();
        // } else {
        //     $('.table_checkbox_each').removeAttr('checked');
        // }
        $('.table_checkbox_each').click();
    });
}

var paging = {
    offset : 0,
    order_by : 'id',
    sort_order : 'desc',
    search_data : {'mark_delete':'N'},
    ajaxUrl: "<?php print base_url('adminpanel/qa_evaluation/get_report'); ?>"
}

var searchData = function() {
    var new_username = $('#username').val();
    var new_imported_time = $('#imported_time').val();
    var new_status = $('#status').val();

    paging.search_data = {
        username : new_username,
        imported_time : new_imported_time,
        status : new_status,
    };

    getNewData(qas_app.after_render_table);

    return false;
}

var drawTable = function (data) {

    var html ='';

    if (data.length != 0) {
        $('#qa_listing_table').css('display', 'block');
        $('#no_result').css('display', 'none');
    } else {
        $('#qa_listing_table').css('display', 'none');
        $('#no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {
        html +='<tr>';
        html +='<td><input type="checkbox" class="table_checkbox_each" row_id="'+value['id']+'" /></td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['id'] + '</td>';
        html +='<td style="text-align:center">' + value['imported_time'] + '</td>';
        html +='<td>' + value['status'] + '</td>';
        html +='<td>' + value['evaluate_mark'] + '%</td>';
        html +='<td>' + value['evaluate_by'] + '</td>';

        html +='<td><a href="<?php print base_url(); ?>adminpanel/qa_evaluation/qa_detail/'+value['id']+'" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Details"><i class="fa fa-eye"></i></a>'
        html +='<a href="javascript:void(0)" class="btn btn-primary btn-circle edit" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit Status"><i class="fa fa-pencil-square"></i></a>'
        html +='<a href="javascript:void(0)" row_id="'+value['id']+'" onclick="inactiveUser(&quot;' +value['username'] + '&quot;,&quot;'+ value['status']+'&quot; )" class="btn btn-danger btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-power-off"></i></a></td>';
        html +='</tr>';
    });

    $('#table-data').html(html);
}

var inactiveUser = function(username, current_status) {
    // bootbox.confirm('Are you sure to inactive '+username+' ?', function(confirmed){
    //     if (confirmed) {
    //         data = {'username' : username, 'current_status' : current_status};
    //         $.ajax({
    //             url: "<?php print base_url('adminpanel/list_members/inactive_user'); ?>",
    //             data: data,
    //             type: "post",
    //             success: function(data) {
    //                 getNewData();
    //                 bootbox.alert(username+' has been deactivated');
    //             },
    //             error: function(data) {
    //                 bootbox.alert('Invalid Action.');
    //             }
    //         });
    //     }
    // });
}


</script>
