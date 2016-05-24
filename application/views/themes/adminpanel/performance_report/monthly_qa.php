<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>
<link href="<?php print base_url(); ?>assets/js/vendor/plupload-2.1.9/js/jquery.ui.plupload/css/jquery.ui.plupload.css" rel="stylesheet">
<script type="text/javascript" src="<?php print base_url(); ?>assets/js/vendor/jquery-ui-1.10.2.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/plupload-2.1.9/js/plupload.full.min.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/plupload-2.1.9/js/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>

<div class="row">
    <div class="col-md-2">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-compress pd-r-5"></i> <?php print $this->lang->line('collapse'); ?></span> <i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
    <div class="col-md-10" style="text-align: right;">
         <button type="button" name="import_btn" id="import_btn" class="btn btn-default btn-md" ><i class="fa fa-download"></i> &nbsp; <?php print $this->lang->line('import'); ?></button>&nbsp; &nbsp; &nbsp;
        <button type="button" name="export_btn" id="export_btn" class="btn btn-default btn-md"><i class="fa fa-upload"></i> &nbsp; <?php print $this->lang->line('export'); ?></button>&nbsp; &nbsp; &nbsp;
        <a href="<?php print base_url() . '/tmp/report_template/monthly_qa.xls' ;?>" target="_self"><button type="button" name="template_btn" id="template_btn" class="btn btn-default btn-md"><i class="fa fa-file-text"></i> &nbsp; <?php print $this->lang->line('template'); ?></button></a>
    </div>
</div>

<div id="search_wrapper" class="collapse in">
    <form name="monthly_qa_form" id="monthly_qa_form" onsubmit="return searchData();">
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
                        <label for="import_date"><?php print $this->lang->line('import_date'); ?></label>
                        <input type="text" name="import_date" id="import_date" autocomplete="off" class="form-control datepicker" style="display:inline;"  />
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

<div id="uploader" style="display:none;"></div>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-7">
                <h4 class="text-uppercase f900">
                    <?php print $this->lang->line('total_record'); ?> : <span id="total-rows"></span>
                </h4>
            </div>
        </div>
        
        <div class="table-responsive" id='monthlyqa_table' style="">
            <table class="table table-hover monthly-qa">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('monthly_qa_id')"><i dataname="monthly_qa_id" class="table-th"></i> <?php print $this->lang->line('id'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('month')"><i dataname="month" class="table-th"></i> <?php print $this->lang->line('month'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('typing_test')"><i dataname="typing_test" class="table-th"></i><?php print $this->lang->line('typing_test'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('monthly_assessment')"><i dataname="monthly_assessment" class="table-th"></i> <?php print $this->lang->line('monthly_assessment'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('leader'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_date')"><i dataname="import_date" class="table-th"></i> <?php print $this->lang->line('import_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('import_by')"><i dataname="import_by" class="table-th"></i> <?php print $this->lang->line('import_by'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('update_date')"><i dataname="update_date" class="table-th"></i> <?php print $this->lang->line('update_date'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('update_by')"><i dataname="update_by" class="table-th"></i> <?php print $this->lang->line('update_by'); ?></a></th>
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

<style type="text/css">
    /*uploader*/
    .plupload_header_content{
        padding-left : 15px;
        height: auto;
    }
    .plupload_wrapper {
        padding: 15px 0 25px 0;
    }
    .plupload_logo {
        display: hidden;
        width: 0;
        height: 0;
        background: none;
    }
    .plupload_header_title {
        padding: 10px 0 10px 0;
    }
    .plupload_header_text {
        display: hidden;
        visibility: hidden;
    }
    .plupload_view_switch {
        bottom: 4px;
    }
    .plupload_message {
        display: none;
    }
</style>

<script type="text/javascript">
jQuery(document).ready(function($){
    var uploader = $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : "<?php print base_url('adminpanel/monthly_qa/import_report'); ?>",
        multi_selection: true,
        max_file_size : '500kb',
        chunk_size: '1mb',
        filters : [
            {title : "Excel Files", extensions : "xls"}
        ],
        rename: true,
        sortable: true,
        dragdrop: true,
        views: {
            thumbs: true,
            active: 'thumbs'
        },
        init : {
            Error: function(uploader, error) {
                bootbox.alert('Invalid Data! File name: "' + error.file.name + '" might contain invalid data or file size more than 2 mb.' );
            },
            UploadComplete: function(up, file, info) { // upload callback
                getNewData();
                up.splice();
            },
        },
    });
});

$(function(){
    $('#import_btn').click(function(){
        var uploader = document.getElementById("uploader");
        if(uploader.style.display == "block") {
                uploader.style.display = "none";
        }
        else {
            uploader.style.display = "block";
        }
    });

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

    window.open('<?php print base_url('adminpanel/monthly_qa/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});

var paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {},
    ajaxUrl: "<?php print base_url('adminpanel/monthly_qa/get_report'); ?>"
}

var searchData = function() {
    var new_importDate = $('#import_date').val();
    var new_username = $('#username').val();

    paging.search_data = {
        import_date : new_importDate,
        username : new_username,
    };

    getNewData();

    return false;
}

var deleteData = function(data_id) {
    bootbox.confirm('Are you sure to delete this record?', function(confirmed){
        if (confirmed) {
            $.ajax({
                url: "<?php print base_url('adminpanel/monthly_qa/delete_report'); ?>",
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
    var month = datarow[1].innerText;
    var username = datarow[2].innerText;
    var typing_test = datarow[3].innerText;
    var monthly_assessment = datarow[4].innerText;
    var leader = datarow[5].innerText;
    var import_date = datarow[6].innerText.slice(0,10) + " " + datarow[6].innerText.slice(11,16);
    var import_by = datarow[7].innerText;
    
    bootbox.dialog({
            title: "<?php print $this->lang->line('edit_record'); ?>",
            message: 
    '<div class="row">' +
        '<div class="col-md-12">' +
            '<form class="form-horizontal" id="edit_form">' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="month"><?php print $this->lang->line('month'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="month" name="month" type="text" value="' + month + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<input id="record_id" name="record_id" type="hidden" value="' + id + '" class="form-control input-md">' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="username"><?php print $this->lang->line('username'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="username" name="username" type="text" disabled value="' + username + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="typing_test"><?php print $this->lang->line('typing_test'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="typing_test" name="typing_test" type="text" value="' + typing_test + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="monthly_assessment"><?php print $this->lang->line('monthly_assessment'); ?> : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="monthly_assessment" name="monthly_assessment" type="text" value="' + monthly_assessment + '" class="form-control input-md">' +
                    '</div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label class="col-md-4 control-label" for="leader"><?php print $this->lang->line('leader'); ?>  : </label>' +
                    '<div class="col-md-4">' +
                        '<input id="leader" name="leader" type="text" value="' + leader+ '" class="form-control input-md">' +
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
                            url: "<?php print base_url('adminpanel/monthly_qa/edit_report'); ?>",
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
        $('#monthlyqa_table').css('display', 'block');
        $('#no_result').css('display', 'none');
    } else {
        $('#monthlyqa_table').css('display', 'none');
        $('#no_result').css('display', 'block');
    }

    $.each( data, function( key, value ) {
        html +='<tr data_id="' + value['monthly_qa_id'] + '">';
        html +='<td>' + value['monthly_qa_id'] + '</td>';
        html +='<td>' + value['month'] + '</td>';
        html +='<td>' + value['username'] + '</td>';
        html +='<td>' + value['typing_test'] + '</td>';
        html +='<td>' + value['monthly_assessment'] + '</td>';
        html +='<td>' + value['leader'] + '</td>';
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
        html +='<td style="white-space: nowrap;"><a href="javascript:void(0)" onclick="editData(' + value['monthly_qa_id'] + ' )" class="btn btn-primary btn-circle edit" ><i class="fa fa-pencil-square"></i></a><a href="#" onclick="deleteData(' + value['monthly_qa_id'] + ')" class="btn btn-danger btn-circle" ><i class="fa fa-trash"></i></a></td>';
        html +='</tr>';
    });

    $('#table-data').html(html);
}

</script>