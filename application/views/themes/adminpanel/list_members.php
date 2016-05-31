<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>


<button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
    <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> <?php print $this->lang->line('expand'); ?></span> <?php print $this->lang->line('search'); ?> <i class="fa fa-search pd-l-5"></i>
</button>

    <div id="search_wrapper" class="collapse <?php print Settings_model::$db_config['search_section']; ?>">
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
                        <label for="leader"><?php print $this->lang->line('report_to'); ?></label>
                        <input type="text" name="leader" id="leader" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="role"><?php print $this->lang->line('role'); ?></label>
                        <select name="role" id="role" class="form-control">
                            <option value=""><?php print $this->lang->line('all'); ?></option>
                            <?php foreach($roles as $role) {?>
                            <option value="<?php print $role->role_name; ?>"><?php print $role->role_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="status"><?php print $this->lang->line('status'); ?></label>
                        <select name="status" id="status" class="form-control">
                            <option value="active"><?php print $this->lang->line('active'); ?></option>
                            <option value="inactive"><?php print $this->lang->line('inactive'); ?></option>
                            <option value="pending"><?php print $this->lang->line('pending'); ?></option>
                            <option value=""><?php print $this->lang->line('all'); ?></option>
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
                    <h4 class="text-uppercase f900">
                        <?php print $this->lang->line('total_users'); ?> : <?php //print  $this->lang->line('total_members') .": "; ?> <span id="total-rows"></span>
        			</h4>
                </div>
            </div>
            <div class="table-responsive" id='user_listing_table' style="">
            <table class="table table-hover user_listing">
                <thead>
                <tr>
                    <th><a href="javascript:void(0)" onclick="chgOrder('count')"><i dataname="count" class="table-th"></i> No</a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('username')"><i dataname="username" class="table-th"></i> <?php print $this->lang->line('username'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('real_name')"><i dataname="real_name" class="table-th"></i> <?php print $this->lang->line('full_name'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('role')"><i dataname="role" class="table-th"></i> <?php print $this->lang->line('role'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('phone')"><i dataname="phone" class="table-th"></i><?php print $this->lang->line('phone'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('leader')"><i dataname="leader" class="table-th"></i> <?php print $this->lang->line('report_to'); ?></a></th>
                    <th><a href="javascript:void(0)" onclick="chgOrder('last_login')"><i dataname="last_login" class="table-th"></i> <?php print $this->lang->line('last_login'); ?></a></th>
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
var permission = <?php echo json_encode($permission, true); ?>;


$(document).ready(function($){


getNewData();
});

var paging = {
offset : 0,
order_by : 'user_id',
sort_order : 'desc',
search_data : {},
ajaxUrl: "<?php print base_url('adminpanel/List_members/get_users'); ?><?php isset($_GET['type'])? print '/'.$_GET['type'] : ''?>"
}

var searchData = function() {
var new_username = $('#username').val();
var new_real_name = $('#real_name').val();
var new_email = $('#email').val();
var new_leader = $('#leader').val();
var new_status = $('#status').val();
var new_role = $('#role').val();

paging.search_data = {
    username : new_username,
    real_name : new_real_name,
    email : new_email,
    leader : new_leader,
    status : new_status,
    role : new_role,

};
paging.search_data;
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
var count = paging.offset+1;
$.each( data, function( key, value ) {
    var date = new Date(value['last_login']) ;
    var dateYMD = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();

    var dateHSi = (date.getHours() % 12) + ':' + date.getMinutes() + ' ' + ( ( date.getHours() >= 12 ) ? 'PM' : 'AM' );

    for (var k in value){
        if (value.hasOwnProperty(k)) {
            if(value[k]=="0" || value[k]=="+60"){
                value[k] ="";
            }
        }
    }

    html +='<tr>';
    // html +='<td>' + value['daily_qa_id'] + '</td>';
    html +='<td>' + count + '</td>';
    html +='<td>' + value['username'] + '</td>';
    html +='<td>' + value['real_name'] + '</td>';
    html +='<td>' + value['role'] + '</td>';
    if ( permission.data_mask &&  value['phone']!=="") {
        value['phone'] = value['phone'].slice(0, -4) + "xxxx";
        html +='<td>' + value['phone'] + '</td>';

    } else {
        html +='<td>' + value['phone'] + '</td>';

    }
    html +='<td>' + value['leader'] + '</td>';
    html +='<td>' + dateYMD + '<br />' + dateHSi+'</td>';

    if(value['status'] == "Active"){
        html +='<td><label class="label label-success"><?php print $this->lang->line('active'); ?></label></td>';

    } else if(value['status'] == "Pending") {
        html +='<td><label class="label label-pending"><?php print $this->lang->line('pending'); ?></label></td>';

    }
    else if(value['status'] == "Inactive") {
        html +='<td><label class="label label-danger"><?php print $this->lang->line('inactive'); ?></label></td>';

    }
    html +='<td >';
    html +='<a href="<?php print base_url(); ?>adminpanel/member_detail/'+value['user_id']+'" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="<?php print $this->lang->line('details'); ?>"><i class="fa fa-eye"></i></a>'

    if ( permission.edit ) {
        html +='<a href="<?php print base_url(); ?>adminpanel/Edit_member_detail/'+value['user_id']+'" class="btn btn-primary btn-circle edit" title="" data-toggle="tooltip" data-placement="top" data-original-title="<?php print $this->lang->line('edit'); ?>"><i class="fa fa-pencil-square"></i></a>'
    }
    if ( permission.delete ) {
        if(status == "Active"){
            html +='<a href="#" onclick="inactiveUser(&quot;' +value['username'] + '&quot;,&quot;'+ value['status']+'&quot; )" class="btn btn-danger btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="<?php print $this->lang->line('inactive_user'); ?>"><i class="fa fa-power-off"></i></a>';
        }else {
            html +='<a href="#" onclick="inactiveUser(&quot;' +value['username'] + '&quot;,&quot;'+ value['status']+'&quot; )" class="btn btn-danger btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="<?php print $this->lang->line('activate_user'); ?>"><i class="fa fa-power-off"></i></a>';
        }
    }
    if ( value['status'] == "Pending" && permission.add) {
        html +='<a href="#" onclick="resend_activation_mail(&quot;' +value['email'] +'&quot; )" class="btn btn-info btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="<?php print $this->lang->line('resend_activation'); ?>"><i class="fa fa-envelope"></i></a>';
    }


    html +='</td>';
    html +='</tr>';
    count++
});

$('#table-data').html(html);
}

var inactiveUser = function(username, current_status) {
    bootbox.confirm( '<?php print $this->lang->line('change_status_msg'); ?>', function(confirmed){
        if (confirmed) {
            data = {'username' : username, 'current_status' : current_status};
            $.ajax({
                url: "<?php print base_url('adminpanel/list_members/change_status'); ?>",
                data: data,
                type: "post",
                success: function(data) {
                    bootbox.alert(data);
                    getNewData();
                },
                error: function(data) {
                    console.log(data);
                    bootbox.alert('Invalid Action.');
                }
            });
        }
    });
}

var resend_activation_mail = function(email) {
    bootbox.confirm('Are you sure to resend activation mail?', function(confirmed){
        if (confirmed) {
            data = {'email' : email};
            $.ajax({
                url: "<?php print base_url('adminpanel/list_members/resend_link_ajax'); ?>",
                data: data,
                type: "post",
                success: function(data) {
                    bootbox.alert(data);
                    getNewData();
                },
                error: function(data) {
                    console.log(data);
                    bootbox.alert('Invalid Action.');
                }
            });
        }
    });
}


</script>
