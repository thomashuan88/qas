<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

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
            <table class="table table-hover daily-qa">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('daily_qa_id')"><i dataname="daily_qa_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('yes')"><i dataname="yes" class="table-th"></i> <?php print $this->lang->line('yes'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('no')"><i dataname="no" class="table-th"></i><?php print $this->lang->line('no'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('csi')"><i dataname="csi" class="table-th"></i> CSI </a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('art')"><i dataname="art" class="table-th"></i> ART </a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('aht')"><i dataname="aht" class="table-th"></i> AHT</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('quantity')"><i dataname="quantity" class="table-th"></i> <?php print $this->lang->line('quantity'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_date')"><i dataname="import_date" class="table-th"></i> <?php print $this->lang->line('import_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_by')"><i dataname="import_by" class="table-th"></i> <?php print $this->lang->line('import_by'); ?></a></th>
                    <!-- <th><a href="javascript:void(0)" onclick="chgOrder('update_date')"><i dataname="update_date" class="table-th"></i> <?php print $this->lang->line('update_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('update_by')"><i dataname="update_by" class="table-th"></i> <?php print $this->lang->line('update_by'); ?></a></th> -->
                    <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('action'); ?></a></th>
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


$(function(){

    getNewData();
    setHeaderIcon();
});

$("#export_btn").click(function(){

    var searchDataUrl = "";
    for (var key in paging.search_data) {
        if (searchDataUrl != "") {
            searchDataUrl += "/";
        }
        searchDataUrl += key + "/" + encodeURIComponent(paging.search_data[key]);
    }

    window.open('<?php print base_url('adminpanel/daily_qa/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});

var paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {},
    ajaxUrl: "<?php print base_url('adminpanel/daily_qa/get_report'); ?>"
}

// var searchData = function() {
//     var new_importDate = $('#import_date').val();
//     var new_username = $('#username').val();
//
//     paging.search_data = {
//         import_date : new_importDate,
//         username : new_username,
//     };
//
//     getNewData();
//
//     return false;
// }

var deleteData = function(data_id) {
    bootbox.confirm('Are you sure to delete this record?', function(confirmed){
        if (confirmed) {
            $.ajax({
                url: "<?php print base_url('adminpanel/daily_qa/delete_report'); ?>",
                data: JSON.stringify(data_id),
                type: "post",
                success: function(data) {
                    getNewData();
                    bootbox.alert('Record Successfully Deleted');
                },
                error: function(data) {
                    bootbox.alert('Invalid Action.');
                }
            });
        }
    });
}

var editData = function(data_id) {
    var datarow =  $( '[data_id=' + data_id +']' ).children();
    var id = datarow[0].innerText;
    var username = datarow[1].innerText;
    var yes = datarow[2].innerText;
    var no = datarow[3].innerText;
    var csi = datarow[4].innerText;
    var art = datarow[5].innerText;
    var aht = datarow[6].innerText;
    var quantity = datarow[7].innerText;
    var import_date = datarow[8].innerText;
    import_date = import_date.slice(0,10) + " " + import_date.slice(11,16);
    var import_by = datarow[9].innerText;

    bootbox.dialog({
            title: "<?php print $this->lang->line('edit_record'); ?>",
            message:
    '<div class="row">' +
        '<div class="col-md-12">' +
            '<form class="form-horizontal" id="edit_form">' +
                '<input id="record_id" name="record_id" type="hidden" value="' + id + '" class="form-control input-md">' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="username"><?php print $this->lang->line('username'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="username" name="username" type="text" disabled value="' + username + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="yes"><?php print $this->lang->line('yes'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="yes" name="yes" type="text" value="' + yes + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="no"><?php print $this->lang->line('no'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="no" name="no" type="text" value="' + no + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="csi">CSI : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="csi" name="csi" type="text" value="' + csi + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="art">ART : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="art" name="art" type="text" value="' + art+ '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="aht">AHT : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="aht" name="aht" type="text" value="' + aht + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="quantity"><?php print $this->lang->line('quantity'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="quantity" name="quantity" type="text" value="' + quantity + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="import_date"><?php print $this->lang->line('import_date'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="import_date" name="import_date" disabled type="text" value="' + import_date + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="import_by"><?php print $this->lang->line('import_by'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="import_by" name="import_by" disabled type="text" value="' + import_by + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '</div>' +
            '</form>' +
        '</div>' +
    '</div>',
            buttons: {
                success: {
                    label: "Save",
                    className: "btn-success",
                    callback: function () {
                        $.ajax({
                            url: "<?php print base_url('adminpanel/daily_qa/edit_report'); ?>",
                            data: $('#edit_form').serialize(),
                            type: "post",
                            success: function(data) {
                                paging.order_by = 'update_date';
                                paging.sort_order = 'desc';
                                paging.offset = 0;
                                getNewData();
                                setHeaderIcon();
                                bootbox.alert('Record Successfully Updated.');
                            },
                            error: function(data) {
                                bootbox.alert('Invalid Action.');
                            }
                        });
                    }
                }
            }
        }
    );
}

var drawTable = function (data) {
    var html ='';

    if (data.length != 0) {
        $('#dailyqa_table').css('display', 'block');
        $('#no_result').css('display', 'none');
    } else {
        $('#dailyqa_table').css('display', 'none');
        $('#no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {
        html +='<tr data_id="' + value['daily_qa_id'] + '">';
        html +='<td>' + value['daily_qa_id'] + '</td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['yes'] + '</td>';
        html +='<td>' + value['no'] + '</td>';
        html +='<td>' + value['csi'] + '</td>';
        html +='<td>' + value['art'] + '</td>';
        html +='<td>' + value['aht'] + '</td>';
        html +='<td>' + value['quantity'] + '</td>';
        html +='<td>' + value['import_date'].substring(0,10) + '<br />' + value['import_date'].substring(11,16) + '</td>';
        html +='<td>' + value['import_by'] + '</td>';
        if (value['update_date']!=null) {
            html +='<td>' + value['update_date'].substring(0,10) + '<br />' + value['update_date'].substring(11,16) + '</td>';
        } else {
            html +='<td></td>';
        }
        if (value['update_date']!=null) {
            html +='<td>' + value['update_by'] + '</td>';
        } else {
            html +='<td></td>';
        }
        html +='<td style="white-space: nowrap;"><a href="#" onclick="deleteData(' + value['daily_qa_id'] + ')" class="btn btn-danger btn-circle" ><i class="fa fa-trash"></i></a></td>';
        html +='</tr>';
    });

    $('#table-data').html(html);
}

</script>
