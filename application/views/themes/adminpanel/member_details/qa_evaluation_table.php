<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="qa_evaluation_block">

            <form name="qa_evaluation_form" id="qa_evaluation_form">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group contain-datepicker">
                            <label for="import_date"><?php print $this->lang->line('import_date'); ?></label>
                            <input type="text" name="import_date" id="imported_time" onchange="qa_evaluation_searchData();" class="form-control datepicker" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email"><?php print $this->lang->line('status'); ?></label>
                            <select name="status" id="status" class="form-control" onchange="qa_evaluation_searchData();">
                                <option value="all">All</option>
                                <option value="pending">Pending</option>
                                <option value="WIP">WIP</option>
                                <option value="In-Progress">In-Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
        </form>

        <div class="row margin-top-30">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-7">
                        <h4 class="text-uppercase f900" style="float:left;">
                            Total Users : <?php //print  $this->lang->line('total_members') .": "; ?> <span class="total-rows" id="total-rows"></span>
                        </h4>

                    </div>
                </div>
                <div class="table-responsive" id='qa_listing_table' style="">
                <table class="table table-hover qa_listing">
                    <thead>
                    <tr>
                        <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('id')"><i dataname="id" class="table-th"></i> <?php print $this->lang->line('chat_log_id'); ?></a></th>
                        <th width="120"><a href="javascript:void(0)" onclick="chgOrder('imported_time')"><i dataname="imported_time" class="table-th"></i> <?php print $this->lang->line('imported_time'); ?></a></th>
                        <th width="120"><a href="javascript:void(0)" onclick="chgOrder('status')"><i dataname="status" class="table-th"></i> <?php print $this->lang->line('status'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('evaluate_mark')"><i dataname="evaluate_mark" class="table-th"></i> <?php print $this->lang->line('evaluate_mark'); ?></a></th>
                        <th><a href="javascript:void(0)" onclick="chgOrder('evaluate_by')"><i dataname="evaluate_by" class="table-th"></i><?php print $this->lang->line('evaluate_by'); ?></a></th>

                        <th><a href="javascript:void(0)" onclick="#"><i  class="table-th"></i> <?php print $this->lang->line('action'); ?></a></th>

                    </tr>
                    </thead>
                    <tbody id="qa-evaluation-table-data">

                    </tbody>
                </table>
            </div>
            <input type="hidden" name="mass_action" id="mass_action" value="">

            <?php print form_close() ."\r\n"; ?>
            <div id="pager" class="page_no col-xs-12 pull-right">
            </div>
            <p id="qa_evaluation_no_result" style="">No results found.</p>
            </div>
        </div>
</div>


<script>

$(document).ready(function($){
    var thisblock = $('#qa_evaluation_block');
    qas_app.paging = {
        offset : 0,
        order_by : 'id',
        sort_order : 'desc',
        search_data : {'mark_delete':'N', 'username' : '<?php print $member->username; ?>'},
        ajaxUrl: qas_app.baseurl + 'adminpanel/qa_evaluation/get_report'
    };

    // $('#js-search', thisblock).click();


    qas_app.getNewData();


});

var qa_evaluation_searchData = function() {
    var new_imported_time = $('#imported_time').val();
    var new_status = $('#status').val();
    qas_app.paging.search_data = {
        username :'<?php print $member->username; ?>',
        imported_time : new_imported_time,
        status : new_status,
    };

    qas_app.getNewData();

    return false;
}

qas_app.drawTable = function (data) {

    var html ='';

    if (data.length != 0) {
        $('#qa_listing_table').css('display', 'block');
        $('#qa_evaluation_no_result').css('display', 'none');
    } else {
        $('#qa_listing_table').css('display', 'none');
        $('#qa_evaluation_no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {
        html +='<tr>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['id'] + '</td>';
        html +='<td>' + value['imported_time'] + '</td>';
        html +='<td><span class="status">' + value['status'] + '</span><select name="status" class="select-status" class="form-control" style="display:none" row_id="'+value['id']+'">' +
                '<option value="pending">pending</option>'+
                '<option value="WIP">WIP</option>'+
                '<option value="In-Progress">In-Progress</option>'+
                '+<option value="Completed">Completed</option>'+
                '</select></td>';
        html +='<td>' + value['evaluate_mark'] + '%</td>';
        html +='<td>' + value['evaluate_by'] + '</td>';

        html +='<td style="white-space: nowrap;"><a href="<?php print base_url(); ?>adminpanel/qa_evaluation/qa_detail/'+value['id']+'" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Details"><i class="fa fa-eye"></i></a></td>'
        html +='</tr>';
    });

    $('#qa-evaluation-table-data').html(html);
}

</script>
