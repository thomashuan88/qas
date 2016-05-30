<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>
<link href="<?php print base_url(); ?>assets/js/vendor/plupload-2.1.9/js/jquery.ui.plupload/css/jquery.ui.plupload.css" rel="stylesheet">
<script src="<?php print base_url(); ?>assets/js/vendor/plupload-2.1.9/js/plupload.full.min.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/plupload-2.1.9/js/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>

<div class="row">
    <div class="col-md-4">
        <button type="button" name="confirm_import" id="confirm_import" class="btn btn-success btn-md" style="display:none;" ><i class="fa fa-play"></i> &nbsp; <?php print $this->lang->line('confirm_import'); ?></button>
        <?php if ( isset( $permission['delete'] ) ): ?>
        <button type="button" name="delete_import" id="delete_import" class="btn btn-danger btn-md" style="display:none;" ><i class="fa fa-ban"></i> &nbsp; <?php print $this->lang->line('delete_import'); ?></button>
        <?php endif; ?>
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-compress pd-r-6"></i> <?php print $this->lang->line('collapse'); ?></span> <i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
    <div class="col-md-8" style="text-align: right;">
        <?php if ( isset( $permission['add'] ) ): ?>
        <button type="button" name="import_btn" id="import_btn" class="btn btn-default btn-md" style="margin-right: 18px;" ><i class="fa fa-download"></i> &nbsp; <?php print $this->lang->line('import'); ?></button>
        <?php endif; ?>
        <button type="button" name="export_btn" id="export_btn" class="btn btn-default btn-md" style="margin-right: 18px;"><i class="fa fa-upload"></i> &nbsp; <?php print $this->lang->line('export'); ?></button>
        <a href="<?php print base_url() . '/tmp/report_template/log_in_out.xls' ;?>" target="_self"><button type="button" name="template_btn" id="template_btn" class="btn btn-default btn-md"><i class="fa fa-file-text"></i> &nbsp; <?php print $this->lang->line('template'); ?></button></a>
        &nbsp; &nbsp; &nbsp;
        <button type="button" name="pending" id="pending" class="btn btn-default btn-md" ><i class="fa fa-step-forward"></i> &nbsp; <?php print $this->lang->line('view_pending'); ?></button>
        <button type="button" name="confirmed" id="confirmed" class="btn btn-default btn-md" style="display:none;" ><i class="fa fa-check"></i> &nbsp; <?php print $this->lang->line('import_done'); ?></button>
    </div>
</div>
<!-- search -->
<div id="search_container">
    <div id="search_wrapper" class="collapse <?php print Settings_model::$db_config['search_section']; ?>">
        <form name="log_in_out_qa_f" id="log_in_out_qa_f" onsubmit="return searchData();">
            <div class="pd-15 bg-primary mg-t-15 mg-b-10">
                <h2 class="text-uppercase mg-t-0">
                    <?php print $this->lang->line('search_record'); ?>
                </h2>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="leader"><?php print $this->lang->line('leader'); ?></label>
                            <input type="text" name="leader" id="leader" class="form-control">
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

<div id="uploader" style="display: none;"></div>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-7">
                <h4 class="text-uppercase f900">
                    <?php print $this->lang->line('total_record'); ?> : <span id="total-rows"></span>
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
                <?php if( isset( $permission['delete'] ) || isset( $permission['edit'] ) ): ?>
                    <th><a href="javascript:void(0)"><i class="table-th"></i> <?php print $this->lang->line('action'); ?></a></th>
                <?php endif;?>
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

var permission = <?php echo json_encode($permission, true); ?>;
var paging = {
    offset : 0,
    order_by : 'import_date',
    sort_order : 'desc',
    search_data : {},
    ajaxUrl: '<?php print base_url('adminpanel/log_in_out/get_report'); ?>'
}

// import file 
jQuery(document).ready(function($){
    var errMsg = '<?php echo $this->lang->line('msg_success_import'); ?>';
    var err = 0;

    var uploader = $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : "<?php print base_url('adminpanel/log_in_out/import_report'); ?>",
        multi_selection: true,
        max_file_size : '500kb',
        chunk_size: '1mb',
        filters : [{title : "Excel Files", extensions : "xls"}],
        rename: true,
        sortable: true,
        dragdrop: true,
        views: {
            thumbs: true,
            active: 'thumbs'
        },
        init : {
            FileUploaded: function( upldr, file, object ) {
                var response = JSON.parse(object.response);
                if(response.error) {
                    errMsg = response.message;
                    err = 1;
                }
            },
            Error: function( uploader, error ) {
                bootbox.alert( "<?php echo $this->lang->line('msg_import_invalid_file_size1'); ?>" + error.file.name + " <?php echo $this->lang->line('msg_import_invalid_file_size1'); ?>" );
                err = 1;
            },
            UploadComplete: function( up, file, info ) { // upload callback
                if (err == 0) {
                    bootbox.confirm(errMsg, function(confirmed){
                        if (confirmed) {
                            confirmImport();
                        } else {
                            $('#confirm_import').prop('disabled', false);
                            $('#delete_import').prop('disabled', false);
                            getNewData();
                        }
                    });
                } else {
                    bootbox.alert(errMsg);
                }

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
        searchDataUrl += key + "/";
        if (encodeURIComponent(paging.search_data[key]) == '') {
            searchDataUrl +=  null;
        } else {
            searchDataUrl +=  encodeURIComponent(paging.search_data[key]);
        }
    }

    window.open('<?php print base_url('adminpanel/log_in_out/export_report'); ?>/' + encodeURIComponent(paging.order_by) + '/' + encodeURIComponent(paging.sort_order) + '/' + searchDataUrl, '_blank' );
});

$("#pending").click(function() {
    $("#js-search").css("display", "none");

    $("#search_container").removeClass("collapse in");
    $("#search_container").addClass("collapse");
    
    $("#confirmed").css("display", "");
    $("#pending").css("display", "none");
    $("#confirm_import").css("display", "");
    $("#delete_import").css("display", "");

    $("#export_btn").css("display", "none");
        
    paging = {
        offset : 0,
        order_by : 'import_date',
        sort_order : 'desc',
        ajaxUrl: '<?php print base_url('adminpanel/log_in_out/get_pending'); ?>',
        search_data : {
            status: 0,
            import_by : '<?php print $this->session->userdata('username'); ?>'
        }
    }
    getNewData();
});

$("#confirmed").click(function() {;
    $("#js-search").css("display", "block");

    $("#search_container").removeClass("collapse");
    $("#search_container").addClass("collapse in");
    $("#search_container").attr("aria-expanded", true);
    
    $("#pending").css("display", "");
    $("#confirmed").css("display", "none");
    $("#confirm_import").css("display", "none");
    $("#delete_import").css("display", "none");

    $("#export_btn").css("display", "");

    paging = {
        offset : 0,
        order_by : 'import_date',
        sort_order : 'desc',
        search_data : {},
        ajaxUrl: '<?php print base_url('adminpanel/log_in_out/get_report'); ?>'
    }

    getNewData();
    setHeaderIcon();
});

$('#confirm_import').click(function() {
    bootbox.confirm('<?php print $this->lang->line('msg_confirm_import'); ?>', function(confirmed){
        if ( confirmed ) {
            confirmImport();
        }
    });
})

var confirmImport = function () {
    var requestData = { import_by: paging.search_data.import_by };

    $.ajax({
        url: '<?php print base_url('adminpanel/log_in_out/confirm_pending'); ?>',
        data: requestData,
        type: 'post',
        dataType: 'json',
        success: function(data) {
            bootbox.alert(data.message);
            $('#confirm_import').prop('disabled', true);
            $('#delete_import').prop('disabled', true);
            getNewData();
        },
        error: function(data) {
            $('#pending').click();
            $('#confirm_import').prop('disabled', false);
            $('#delete_import').prop('disabled', false);
            bootbox.alert("<?php print $this->lang->line('account_unknown_error'); ?>");
        }
    });
}

$('#delete_import').click(function() {
    bootbox.confirm('<?php print $this->lang->line('msg_delete_import'); ?>', function(confirmed){
        if (confirmed) {
            var requestData = { import_by: paging.search_data.import_by };

            $.ajax({
                url: '<?php print base_url('adminpanel/log_in_out/delete_pending'); ?>',
                data: requestData,
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    bootbox.alert(data.message);
                    $('#confirm_import').prop('disabled', true);
                    $('#delete_import').prop('disabled', true);
                    getNewData();
                },
                error: function(data) {
                    bootbox.alert("<?php print $this->lang->line('account_unknown_error'); ?>");
                }
            });
        }
    });
})

var searchData = function() {
    var date = $('#date').val();
    var new_username = $('#leader').val();

    paging.search_data = {
        date : date,
        leader : new_username,
    };

    getNewData();

    return false;
}

var deleteData = function(data_id) {
    bootbox.confirm('Are you sure to delete this record?', function(confirmed){
        if (confirmed) {
            $.ajax({
                url: "<?php print base_url('adminpanel/log_in_out/delete_report'); ?>",
                data: { data:JSON.stringify( data_id  ) },
                type: "post",
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        bootbox.alert(data.message);
                    } else {
                        bootbox.alert(data.message);
                    }

                    getNewData();
                },
                error: function(data) {
                    bootbox.alert("<?php print $this->lang->line('account_unknown_error'); ?>");
                }
            });
        }
    });
}

var drawTable = function (data) {
    var html = '';
    if (data.length != 0) {
        $('#content_data_table').css('display', 'block');
        $('#no_result').css('display', 'none');
    } else {
        $('#content_data_table').css('display', 'none');
        $('#no_result').css('display', 'block');
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
        <?php if( isset( $permission['delete'] ) ): ?>
        html +='<td style="white-space: nowrap;"><a href="#" onclick="deleteData(' + value['log_in_out_id'] + ')" class="btn btn-danger btn-circle" title="<?php print $this->lang->line('delete')?>" data-toggle="tooltip" data-placement="top" data-original-title="" data-method="DELETE"><i class="fa fa-trash"></i></a></td>';
        <?php endif; ?>
        
        html +='</tr>';
    });

    $('#table-data').html(html);
}

</script>