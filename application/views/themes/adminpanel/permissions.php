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
            <?php print form_open('adminpanel/roles/save_role_permissions', 'id="save_role_permissions_form_'. $role_id .'"') ."\r\n"; ?>
                <table class="table table-bordered table-hover list table-condensed table-striped">
                    <thead>
                        <tr >
                        <!-- <th style="width: 30px;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: #e6e6e6;text-align: center;">No.</th> -->
                        <th rowspan="2" style="width: 60%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;"><?php print $this->lang->line('module_name')?></th>
                        <th style="width: 25%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;"><?php print $this->lang->line('action')?></th>
                        <th style="width: 30%;cursor:default; color:#333333;text-shadow: 0 1px 0 #FFFFFF;background-color: white;text-align: center;">check all</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($role['permissions'] as $id => $permission) {  ?>
                        <?php if($permission['parentid'] == 0){ ?>
                        <tr>
                            <!-- <th style="text-align:center;"><?php echo $i;?></th> -->
                            <th><?php print $permission['description']; ?></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php }else{  ?>
                        <tr id ="<?php print $id; ?>" name="check_list">
                            <!-- <td style="text-align:center;"><?php echo $i;?></td> -->
                            <td><?php print $permission['description']; ?></td>
                            <td style="text-align:center;">
                            <label class="checkbox inline">
                                <?php print form_checkbox(array('name' => 'add[]', 'class' => 'check_action_'.$role_id.'_'.$id, 'value' => $id, 'checked' => ($permission['add'] == 'yes' ? true : false))); ?> Add</label>
                            <label class="checkbox inline">
                                <?php print form_checkbox(array('name' => 'edit[]', 'class' => 'check_action_'.$role_id.'_'.$id, 'value' => $id, 'checked' => ($permission['edit'] == 'yes' ? true : false))); ?> Edit</label>
                            <label class="checkbox inline">
                                <?php print form_checkbox(array('name' => 'delete[]', 'class' => 'check_action_'.$role_id.'_'.$id, 'value' => $id, 'checked' => ($permission['delete'] == 'yes' ? true : false))); ?> Delete</label>
                            <label class="checkbox inline"> 
                                <?php print form_checkbox(array('name' => 'view[]', 'class' => 'check_action_'.$role_id.'_'.$id, 'value' => $id, 'checked' => ($permission['view'] == 'yes' ? true : false))); ?>view</label>
                            </td>
                            <td style="text-align:center;">
                            <label class="checkbox inline">
                                <input type="checkbox" name="check_all" class="check_all" id="check_all_<?php print $role_id; ?>_<?php print $id; ?>" />
                             </label>
                            </td>
                        </tr>
                        <?php }?>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                 <div class="form-group mg-b-0">
                    <button type="submit" name="save_roles" class="btn btn-success"><i class="fa fa-check pd-r-5"></i> Save</button>
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
    }

    // var permi_id = $("input[name=check_all]").attr("id");
    // alert(permi_id);
    
    $(".check_all").change(function(e){
        var permission_id = $(this).attr("id");
       // alert(permission_id);
      //$(".check_action").prop('checked', $(this).prop("checked"));
    });

   
});


</script>
