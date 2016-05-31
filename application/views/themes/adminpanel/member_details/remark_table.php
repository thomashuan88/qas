<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-7">
                <h4 class="text-uppercase f900">
                    <?php print $this->lang->line('total_record'); ?> : <span class="total-rows" id="total-rows"></span>
                </h4>
            </div>
        </div>

        <div class="table-responsive" id='remarks_table' style="">
            <table class="table table-hover remarks">
                <thead>
                <tr>
                    <th style="width : 5%;"><a href="javascript:void(0)" onclick="chgOrder('daily_qa_id')"><i dataname="daily_qa_id" class="table-th"></i> <?php print $this->lang->line('no'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('remarks'); ?></a></th>
                    <th style="width : 15%;"><a href="javascript:void(0)" onclick="chgOrder('yes')"><i dataname="yes" class="table-th"></i> <?php print $this->lang->line('submit_by'); ?></a></th>
                    <th style="width : 15%;"><a href="javascript:void(0)" onclick="chgOrder('no')"><i dataname="no" class="table-th"></i><?php print $this->lang->line('submit_time'); ?></a></th>
                </tr>
                </thead>
                <tbody id="remarks-table-data">

                </tbody>
            </table>
        </div>
        <input type="hidden" name="mass_action" id="mass_action" value="">

        <div id="pager" class="page_no col-xs-12 pull-right">
        </div>
        <p id="remarks_no_result" style="">No results found.</p>
    </div>
</div>


<script type="text/javascript">


var remarks_paging = {
    offset : 0,
    order_by : 'create_time',
    sort_order : 'desc',
    search_data : {'username' : '<?php print $member->username; ?>'},
    ajaxUrl: "<?php print base_url('adminpanel/member_detail/get_remarks/'.$member->username); ?>"
}


var remarks_drawTable = function (data) {
    var html ='';

    if (data.length != 0) {
        $('#remarks_table').css('display', 'block');
        $('#remarks_no_result').css('display', 'none');
    } else {
        $('#remarks_table').css('display', 'none');
        $('#remarks_no_result').css('display', 'block');
    }
    var count = 1;
    $.each( data, function( key, value ) {

        var date = new Date(value['create_time']) ;
        var dateYMD = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
        var dateHSi = (date.getHours() % 12) + ':' + date.getMinutes() + ' ' + ( ( date.getHours() >= 12 ) ? 'PM' : 'AM' );

        html +='<tr data_id="' + value['id'] + '">';
        html +='<td>' + count + '</td>';
        html +='<td>' + value['remark'] + '</td>';
        html +='<td>' + value['create_by'] + '</td>';
        html +='<td>' + dateYMD + '<br />' + dateHSi + '</td>';
        html +='</tr>';
        count++

    });

    $('#remarks-table-data').html(html);
}

</script>
