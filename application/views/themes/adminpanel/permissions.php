<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?> 

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
<style type="text/css">
    .checkbox{
        padding-left: 30px;
        display: inline;
    }
    th{
        width: 30px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;
    }
</style>
    <div class="col-xs-12" style="margin-bottom: 20px;padding-left: 0px;"> <!-- required for floating -->
      <ul class="nav nav-tabs"><!-- 'tabs-right' for right tabs -->
      <?php foreach ($roles_name as $name) { ?>
        <li class="role"><a href="#<?php print $name->role_id; ?>" id="role_name" data-toggle="tab"><?php print $name->role_name; ?></a></li>
        <?php }?>
      </ul>
    </div>
     <div class="tab-content">
    <?php foreach ($roles as $role_id => $role) { ?>
            <div class="tab-pane" id="<?php print $role_id; ?>">
            <?php print form_open('adminpanel/permissions/save_role_permissions', 'id="save_role_permissions_form_'. $role_id .'" class="form-confirm"') ."\r\n"; ?>
                <table class="table table-bordered table-hover list table-condensed table-striped" id="table_list">
                    <thead>
                        <tr >
                        <th rowspan="2" style="width: 60%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;vertical-align: middle;"><?php print $this->lang->line('module_name')?></th>
                        <th rowspan="2" style="width: 28%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;vertical-align: middle;white-space: nowrap;"><?php print $this->lang->line('action')?></th>
                        <th style="width: 30%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;"><input type="checkbox" name="<?php print $role_id; ?>" class="check_full_access"/> <?php print $this->lang->line('full_access')?></th>
                        </tr>
                        <tr>
                         
                        <th style="width: 30%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;"><?php print $this->lang->line('check_all')?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($role['permissions'] as $id => $permission) {  ?>
                        <?php if($permission['parentid'] == 0){ ?>
                        <tr>
                            <th><?php print $permission['description']; ?></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php }else{  ?>
                        <tr id ="<?php print $id; ?>" name="check_list" class="check_list">
                            <td><?php print $permission['description']; ?>  </td>
                            <td style="text-align:center;white-space: nowrap;">
                            <label class="checkbox inline">
                                <?php print form_checkbox(array('name' => 'add[]', 'class' => 'check_action', 'value' => $id, 'id' => $role_id, 'checked' => ($permission['add'] == 'yes' ? true : false))); ?> <?php print $this->lang->line('add')?></label>
                            <label class="checkbox inline">
                                <?php print form_checkbox(array('name' => 'edit[]', 'class' => 'check_action', 'value' => $id, 'id' => $role_id,'checked' => ($permission['edit'] == 'yes' ? true : false))); ?> <?php print $this->lang->line('edit')?></label>
                            <label class="checkbox inline">
                                <?php print form_checkbox(array('name' => 'delete[]', 'class' => 'check_action', 'value' => $id, 'id' => $role_id, 'checked' => ($permission['delete'] == 'yes' ? true : false))); ?> <?php print $this->lang->line('delete')?></label>
                            <label class="checkbox inline"> 
                                <?php print form_checkbox(array('name' => 'view[]', 'class' => 'check_action', 'value' => $id, 'id' => $role_id, 'checked' => ($permission['view'] == 'yes' ? true : false))); ?> <?php print $this->lang->line('view')?></label>
                            </td>
                            <td style="text-align:center;">
                            <?php if($permission['view'] == "yes" && $permission['add'] == "yes" && $permission['edit'] == "yes" && $permission['delete'] == "yes"){ 
                                   $check = "checked";
                                }elseif($permission['view'] == "no" || $permission['add'] || "no" && $permission['edit'] || "no" || $permission['delete'] == "no"){ 
                                     $check = "";
                                }
                            ?>
                            <label class="checkbox inline">
                                <input type="checkbox" name="<?php print $role_id; ?>" class="check_all" id="<?php print $id; ?>"  <?php print $check;?>/>
                                <input type="hidden" name="checkbox" id="checkbox_id" value="<?php print $role_id; ?>">
                             </label>
                            </td>
                        </tr>
                        <?php }?>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                 <div class="form-group mg-b-0">
                    <button type="submit" name="save_roles" class="btn btn-success"><i class="fa fa-floppy-o pd-r-5"></i> <?php print $this->lang->line('save')?></button>
                    <input type="hidden" name="role_id" value="<?php print $role_id; ?>">
                </div>
                <?php print form_close() ."\r\n"; ?>
            </div>
    <?php } ?>
    </div>
<script type="text/javascript">
$(document).ready(function(){
    var id = $("#role_name").attr("href");
    var default_id = id.replace(/^#+/i, ''); 
    $('.nav-tabs a[href="#' + default_id + '"]').tab('show');

    var role_id = '<?php print $this->session->flashdata('role_id'); ?>';

    if(role_id != ""){
        $('.nav-tabs a[href="#' + role_id + '"]').tab('show');
        var role_session_id = '<?php echo $roleid; ?>';
        $("#"+role_session_id).find('.check_action:not(:checked)').attr('disabled', 'disabled');
        $("#"+role_session_id).find('.check_full_access:not(:checked)').attr('disabled', 'disabled');
        $("#"+role_session_id).find('.check_all:not(:checked)').attr('disabled', 'disabled');
    }

    $(".check_all").change(function(e){
        var checkedStatus = this.checked;
        var permi_id = $(this).attr("id");
        var role_id = $(this).attr("name");
        $("#"+role_id).find("#"+permi_id+" td label input").each(function () {
            $(this).prop('checked', checkedStatus);
        }); 

        if($("#"+role_id).find(".check_all").length == $("#"+role_id).find(".check_all:checked").length) {
            $("#"+role_id).find(".check_full_access").attr("checked", "checked");
            $("#"+role_id).find(".check_full_access").prop('checked', true);
        } else {
            $("#"+role_id).find(".check_full_access").removeAttr("checked");
        }
    });

    $(".check_action").change(function(e){
        var checkedStatus = this.checked;
        var permi_id = $(this).val();
        var role_id = $(this).attr("id"); 

        if($("#"+role_id).find("#"+permi_id+" td label .check_action").length == $("#"+role_id).find("#"+permi_id+" td label .check_action:checked").length) {
           $("#"+role_id).find("#"+permi_id+" td label .check_all").attr('checked', 'checked');
           $("#"+role_id).find("#"+permi_id+" td label .check_all").prop('checked', true);
        } else {
          $("#"+role_id).find("#"+permi_id+" td label .check_all").removeAttr("checked");
        }

        if($("#"+role_id).find(".check_action").length == $("#"+role_id).find(".check_action:checked").length) {
            $("#"+role_id).find(".check_full_access").attr("checked", "checked");
            $("#"+role_id).find(".check_full_access").prop('checked', true);
        } else {
            $("#"+role_id).find(".check_full_access").removeAttr("checked");
        }

    });

    $(".check_full_access").change(function(e){
        var checkedStatus = this.checked;
        var role_id = $(this).attr("name"); 
        $("#"+role_id).find("td label input").prop('checked', checkedStatus); 
    });

    var role_id = '<?php echo $roleid; ?>';
    $('a[href="#'+role_id+'"]').click(function(){
         $("#"+role_id).find('.check_action:not(:checked)').attr('disabled', 'disabled');
         $("#"+role_id).find('.check_full_access:not(:checked)').attr('disabled', 'disabled');
         $("#"+role_id).find('.check_all:not(:checked)').attr('disabled', 'disabled');
    }); 
});
</script>
