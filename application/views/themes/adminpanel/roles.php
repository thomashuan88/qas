<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
<style type="text/css">
    .btn-circle{
        width: 30px;
        height: 30px;
        padding: 5px 0;
        border-radius: 15px;
        font-size: 12px;
    }
</style>
<div style="padding-bottom: 10px;">
        <button class="btn btn-primary"  id="add-user" style="float: right;margin-bottom: 20px;" onclick="add_user();">
            <i class="fa fa-plus"></i>
            <?php echo $this->lang->line('add_role'); ?>
        </button>
</div>

<div style="padding-bottom: 10px;">
       <div class="form-group" id="roles_status">
        <label for="status"><?php print $this->lang->line('status'); ?> </label>
        <select name="status" id="status" class="form-control" style="width:10%;display: inline-block;">
            <option value="active"><?php print $this->lang->line('active'); ?></option>
            <option value="inactive"><?php print $this->lang->line('inactive'); ?></option>
            <option value="all"><?php print $this->lang->line('show_all'); ?></option>
        </select>
    </div>
</div>
<?php print form_open('adminpanel/roles/add_role', 'id="add_role_form" class="mg-t-20 form-confirm"') ."\r\n"; ?>

    <div class="row" id="add_user" style="display:none;">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="role_name"><?php echo $this->lang->line('role_name'); ?></label>
            <input type="text" name="role_name" id="role_name" class="form-control input-lg">
        </div>
    </div>
        <button type="submit" class="btn btn-success btn-lg js-btn-loading" style="margin-top: 25px;" data-loading-text="Creating..."><i class="fa fa-floppy-o pd-r-5"></i><?php echo $this->lang->line('submit'); ?></button>
        <a href="" type="button" class="btn btn-danger btn-lg js-btn-loading" style="margin-top: 25px;"><i class="fa fa-ban pd-r-5"></i><?php echo $this->lang->line('cancel'); ?></a>
</div>
<?php print form_close() ."\r\n"; ?>
    <div >
        <div class="row" id="roles_data">
           <table class="table table-bordered table-hover list table-condensed table-striped">
                <thead>
                    <tr>
                        <th style="cursor:default;  text-align:center; color:#333333;text-shadow: 0 1px 0 #FFFFFF;  background-color: #e6e6e6;width:40px;"><?php echo $this->lang->line('no_num'); ?></th>
                        <th style="cursor:pointer; text-align:center; color:#333333;text-shadow: 0 1px 0 #FFFFFF;  background-color: #e6e6e6;"><?php echo $this->lang->line('role_name'); ?></th>
                        <th style="cursor:default;  text-align:center; color:#333333;text-shadow: 0 1px 0 #FFFFFF;  background-color: #e6e6e6;width:100px;"><?php echo $this->lang->line('status'); ?></th>
                        <th style="cursor:pointer; text-align:center; color:#333333;text-shadow: 0 1px 0 #FFFFFF;  background-color: #e6e6e6;width:15px;"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach ($roles as $role_id => $role) {  ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td name="role_name" id="role_name_<?php print $role_id; ?>" value=""><?php print $role['role_name']; ?></td>
                        <td class="text-center">
                            <?php if($role['status'] == "active") : ?>
                            <a class = "status_name" id="inactive" name="<?php print $role['role_name']; ?>" style="font-size: 14px;cursor:default;color:black;" href="#" title="activate account">
                            <?php echo $this->lang->line('active'); ?></a>
                            <?php else: ?>
                            <a class = "status_name" id="active" name="<?php print $role['role_name']; ?>"  style="font-size: 14px;cursor:default;color:black;" href="#" title="inactivate account">
                            <?php echo $this->lang->line('inactive'); ?></a>
                            <?php endif; ?>
                        </td>
                        <td ><a href="<?php print site_url('adminpanel/roles/toggle_active/'. $role_id ."/". $role['status']."/".  $role['role_name']); ?>" style="margin: 0 5px;" class="btn btn-danger btn-circle status" name="<?php print $role['role_name']; ?>" title="" data-toggle="tooltip" data-placement="top"><i class="fa fa-power-off"></i></a></td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
<script type="text/javascript">
$(function(){
var error = '<?php print $this->session->flashdata('iswrong'); ?>';
var role_name = '<?php print $this->session->flashdata('role'); ?>';

if(error != ""){
    $("#roles_data").hide();
    $("#add-user").hide();
    $("#roles_status").hide();
    $("#add_user").show();
    $("#role_name").val(role_name);
}

$(".status").on("click", function (e) {
    var status = $(".status_name").attr("id");
    var role_name = $(this).attr("name");
    var status_link = $(this).attr('href');
    e.preventDefault();
    bootbox.confirm("Are you sure to "+status+" "+role_name+"?", function (confirmed) {
        if (confirmed) {
            window.location.href = status_link;
        }
    });
});

	$('select').on('change', function() {
		var html ='';
		var status = this.value;
		var datastring = 'status=' + status;
		$.ajax({
			type: 'post',
			url: '<?php print base_url('adminpanel/roles/search_status'); ?>',
			data: datastring,
			dataType: "json",
			success: function(result){
                if(result != "norecord"){
                    var i = 1;
                    $.each( result, function( key, value ) {
                        var rolename = encodeURIComponent(value['role_name']);
                            html += "<tr>";
                            html += "<td class=\"text-center\">"+i+"</td>";
                            html += "<td name=\"role_name\" id=\"role_name_"+value['role_id']+"\">"+value['role_name']+"</td>";
                            html += "<td class=\"text-center\">";
                            if(value['status'] == "active"){
                                html += "<a class = \"status_name\" id=\"inactive\" style=\"font-size: 14px;cursor:default;color:black;\" href=\"#\" title=\"activate account\"><?php print $this->lang->line('active'); ?></a>"
                            }else{
                                html += "<a class = \"status_name\" id=\"active\"  name=\""+value['role_name']+"\" style=\"font-size: 14px;cursor:default;color:black;\" href=\"#\" title=\"inactivate account\"><?php print $this->lang->line('inactive'); ?></a>"
                            }
                            html += "</td>";
                            html += "<td>";
                            html += "<a href=\"<?php print base_url(); ?>adminpanel/roles/toggle_active/"+value['role_id']+"/"+value['status']+"/"+rolename+"\" style=\"margin: 0 5px;\" name=\""+value['role_name']+"\" class=\"btn btn-danger btn-circle status\" title=\"\" data-toggle=\"tooltip\" data-placement=\"top\"><i class=\"fa fa-power-off\"></i></a>";
                            html += "</td>";
                            html += "</tr>";
                        
                        i++;
                    });
                    $('tbody').html(html);
                    $(".status").on("click", function (e) {
                        var status = $(".status_name").attr("id");
                        var role_name = $(this).attr("name");
                        var status_link = $(this).attr('href');
                        e.preventDefault();
                        bootbox.confirm("Are you sure to "+status+" "+role_name+"?", function (confirmed) {
                            if (confirmed) {
                                window.location.href = status_link;
                            }
                        });
                    });
                }else{
                    html += "<tr>";
                    html += "<td colspan=\"4\" class=\"text-center\">no record</td>";
                    html += "</tr>";
                    $('tbody').html(html);
                }
            }
				
		});
	});
});
    function add_user(){
        $("#roles_data").hide();
        $("#add-user").hide();
        $("#roles_status").hide();
        $("#add_user").show();
    }
</script>
