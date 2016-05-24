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
                    <div class="form-group">
                        <label for="first_name"><?php print $this->lang->line('full_name'); ?></label>
                        <input type="text" name="real_name" id="real_name" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="email"><?php print $this->lang->line('email_address'); ?></label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="last_name"><?php print $this->lang->line('leader'); ?></label>
                        <input type="text" name="leader" id="leader" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="email"><?php print $this->lang->line('status'); ?></label>
                        <select name="status" id="status" class="form-control">
                            <option value="active"><?php print $this->lang->line('active'); ?></option>
                            <option value="inactive"><?php print $this->lang->line('inactive'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

		<div class="row mg-b-20">
			<div class="col-xs-12 clearfix">
                <button type="submit" name="member_search_submit" id="member_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
                    <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('search_user'); ?>
                </button>
            </div>
		</div>
    </form>

    </div>

	<div class="row margin-top-30">

		<div class="col-xs-12">
            <div class="row">
                <div class="col-xs-7">
                    <h4 class="text-uppercase f900">
                        Total Users : <?php //print  $this->lang->line('total_members') .": "; ?> <span id="total-rows"></span>
        			</h4>
                </div>
            </div>
            <div class="table-responsive" id='user_listing_table' style="">
            <table class="table table-hover user_listing">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('user_id')"><i dataname="user_id" class="table-th"></i> ID</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('real_name')"><i dataname="real_name" class="table-th"></i> <?php print $this->lang->line('full_name'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('role')"><i dataname="role" class="table-th"></i> <?php print $this->lang->line('role'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('phone')"><i dataname="phone" class="table-th"></i><?php print $this->lang->line('phone'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('leader'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('status')"><i dataname="status" class="table-th"></i> <?php print $this->lang->line('status'); ?></a></th>
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
getNewData();
});

var paging = {
offset : 0,
order_by : 'user_id',
sort_order : 'desc',
search_data : {'status':'active'},
ajaxUrl: "<?php print base_url('adminpanel/List_members/get_report'); ?>"
}

var searchData = function() {
var new_username = $('#username').val();
var new_real_name = $('#real_name').val();
var new_email = $('#email').val();
var new_leader = $('#leader').val();
var new_status = $('#status').val();

paging.search_data = {
    username : new_username,
    real_name : new_real_name,
    email : new_email,
    leader : new_leader,
    status : new_status,
};

getNewData();

return false;
}

var drawTable = function (data) {
var html ='';

if (data.length != 0) {
    $('#user_listing_table').css('display', 'block');
    $('#no_result').css('display', 'none');
} else {
    $('#user_listing_table').css('display', 'none');
    $('#no_result').css('display', 'block');
}

$.each( data, function( key, value ) {
    html +='<tr>';
    // html +='<td>' + value['daily_qa_id'] + '</td>';
    html +='<td>' + value['user_id'] + '</td>';
    html +='<td>' + value['username'] + '</td>';
    html +='<td>' + value['real_name'] + '</td>';
    html +='<td>' + value['role'] + '</td>';
    html +='<td>' + value['phone'] + '</td>';
    html +='<td>' + value['leader'] + '</td>';
    html +='<td>' + value['status'] + '</td>';
    // html +='<td><a href="#" class="btn btn-info btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="User Sessions"><i class="fa fa-list"></i></a>'
    html +='<td><a href="<?php print base_url(); ?>adminpanel/member_detail/'+value['user_id']+'" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="View User"><i class="fa fa-eye"></i></a>'
    // html +='<a href="<?php print base_url(); ?>adminpanel/member_detail/'+value['user_id']+'" class="btn btn-primary btn-circle edit" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit User"><i class="fa fa-pencil-square"></i></a>'
    html +='<a href="#" onclick="inactiveUser(&quot;' +value['username'] + '&quot;,&quot;'+ value['status']+'&quot; )" class="btn btn-danger btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Delete User"><i class="fa fa-power-off"></i></a></td>';
    html +='</tr>';
});

$('#table-data').html(html);
}

var inactiveUser = function(username, current_status) {
    bootbox.confirm('Are you sure to inactive '+username+' ?', function(confirmed){
        if (confirmed) {
            data = {'username' : username, 'current_status' : current_status};
            $.ajax({
                url: "<?php print base_url('adminpanel/list_members/inactive_user'); ?>",
                data: data,
                type: "post",
                success: function(data) {
                    getNewData();
                    bootbox.alert(username+' has been deactivated');
                },
                error: function(data) {
                    bootbox.alert('Invalid Action.');
                }
            });
        }
    });
}


</script>
