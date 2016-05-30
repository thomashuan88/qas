<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?> 

<?php $this->load->view('generic/flash_error'); ?>

<?php $tab = (isset($_GET['tab'])) ? $_GET['tab'] : ""; ?>

<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="<?php echo ($tab == '')? 'active' : ''; ?>"><a href="#shift" aria-controls="shift" role="tab" data-toggle="tab"><?php print $this->lang->line('shift'); ?></a></li>
    <li class="<?php echo ($tab == 'product') ? 'active' : ''; ?>"><a href="#product" aria-controls="product" role="tab" data-toggle="tab"><?php print $this->lang->line('product'); ?></a></li>   
    <li class="<?php echo ($tab == 'live_person') ? 'active' : ''; ?>"><a href="#live_person" aria-controls="live_person" role="tab" data-toggle="tab"><?php print $this->lang->line('live_person'); ?></a></li>      
    <li class="<?php echo ($tab == 'system') ? 'active' : ''; ?>"><a href="#system" aria-controls="system" role="tab" data-toggle="tab"><?php print $this->lang->line('system'); ?></a></li>

  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane <?php echo ($tab == '') ? 'active' : ''; ?>" id="shift">
     	<div class="row margin-top-30">
    		<div class="col-xs-12"><br>
        		<?php if (!empty($shift)) { ?>  
        			<?php print form_open('adminpanel/settings'); ?> 
        			<div class="table-responsive">
                		<table class="table table-hover"> 
                			<thead>
                        		<tr>
                        			<th width="20%"><a href="#"><?php print $this->lang->line('number'); ?></a></th>
                        			<th><a href="#"><?php print $this->lang->line('working_shift'); ?></a></th>
                        			<th><a href="#"><?php print $this->lang->line('working_hour'); ?></a></th>
                        			<th width="20%"><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                        		</tr>
                        	</thead>
                    		<tbody>
                            <?php $count=1; ?>
                    		<?php foreach ($shift->result() as $shift): ?>
                    			<tr>
	                    			<td width="20%"><?php echo $count; ?></td>
	                            	<td><?php print $shift->key; ?></td>
	                            	<td><?php print $shift->value; ?></td>
	                            	<td width="20%">
                                        <?php if (!empty($permission['edit'])) {;?>
                                        <a href="<?php print base_url() ."adminpanel/settings/edit_shift/".$shift->sid; ?>"class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                        <i class="fa fa-pencil-square"></i></a>
                                        <?php }?>
	                            	</td>
	                            </tr>
                            <?php $count++; ?>
	                        <?php endforeach; ?>
                    		</tbody>
                		</table>
                	</div>
               		<?php print form_close() ."\r\n"; ?>
        		<?php }else{ ?>
        			 <div class="table-responsive">
                		<table class="table table-hover">
                    		<thead>
                        		<tr>
                        			<th width="20%"><a href="#"><?php print $this->lang->line('number'); ?></a></th>
                        			<th><a href="#"><?php print $this->lang->line('working_shift'); ?></a></th>
                        			<th><a href="#"><?php print $this->lang->line('working_hour'); ?></a></th>
                        			<th width="20%"><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                        		</tr>
                        	</thead>
                    		<tbody>
                        		<tr>
                            		<td colspan="13" class="text-center" style="color: #FF0000;">
                                	<?php print $this->lang->line('no_result'); ?>
                           			</td>
                        		</tr>
                    		</tbody>
                		</table>
            		</div>
            	<?php } ?>
        	</div>
        </div>			
    </div>
    <div role="tabpanel" class="tab-pane <?php echo ($tab == 'product') ? 'active' : ''; ?>" id="product">

        <div class="row margin-top-30">
            <div class="col-xs-12"><br>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10" style="text-align: right;">
                        <?php if (!empty($permission['add'])) {;?>
                        <a href="<?php print base_url() ."adminpanel/settings/product_settings_add/"?>">
                            <button type="button" class="btn btn-primary">
                                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                            </button>
                        </a>
                        <?php } ?>
                    </div>
                </div>

                
                <?php if (!empty($product)) { ?>  
                    <?php print form_open('adminpanel/settings'); ?> 
                    <div class="table-responsive">
                        <table class="table table-hover"> 
                            <thead>
                                <tr>
                                    <th width="20%"><a href="#"><?php print $this->lang->line('number'); ?></a></th>
                                    <th><a href="#"><?php print $this->lang->line('product_type'); ?></a></th>
                                    <th width="20%"><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $count=1; ?>
                            <?php foreach ($product->result() as $product): ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php print $product->value; ?></td>
                                    <td>
                                        <?php if (!empty($permission['edit'])) {;?>
                                        <a href="<?php print base_url() ."adminpanel/settings/edit_product/".$product->sid; ?>"class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                        <i class="fa fa-pencil-square"></i></a>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php $count++; ?>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                    </div>
                    <?php print form_close() ."\r\n"; ?>
                <?php }else{ ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="20%"><a href="#"><?php print $this->lang->line('number'); ?></a></th>
                                    <th><a href="#"><?php print $this->lang->line('product_type'); ?></a></th>
                                    <th width="20%"><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="13" class="text-center" style="color: #FF0000;">
                                    <?php print $this->lang->line('no_result'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>  
    </div>
    <div role="tabpanel" class="tab-pane <?php echo ($tab == 'live_person') ? 'active' : ''; ?>" id="live_person">
        <div class="row margin-top-30">
            <div class="col-xs-12"><br>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10" style="text-align: right;">
                        <?php if (!empty($permission['add'])) {;?>
                        <a href="<?php print base_url() ."adminpanel/settings/live_person_settings_add/"?>">
                            <button type="button" class="btn btn-primary">
                                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                            </button>
                        </a>
                        <?php } ?>
                    </div> 
                </div>
            <?php if (!empty($live_person)) { ?>   
              <?php print form_open('adminpanel/settings'); ?> 
                 <div class="table-responsive">
                    <table class="table table-hover"> 
                        <thead>
                            <tr>
                                <th width=""><a href="#"><?php print $this->lang->line('account_id'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('product_type'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('consumer_key'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('consumer_secret'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('access_token'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('access_token_secret'); ?></a></th>
                                <th width=""><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($live_person as $product => $value ): ?>
                            <tr>
                                <td><?php echo $value['account_id']; ?></td>
                                <td><?php print $product; ?></td>
                                <td><?php print $value['consumer_key']; ?></td>
                                <td><?php print $value['consumer_secret']; ?></td>
                                <td><?php print $value['access_token']; ?></td>
                                <td><?php print $value['access_token_secret']; ?></td>
                                <td>
                                <?php if (!empty($permission['edit'])) {;?>
                                    <a href="<?php print base_url() ."adminpanel/settings/edit_live_person/".$product; ?>"class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square"></i></a>
                                <?php }?>
                                </td>
                            </tr>
                        <?php $count++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php print form_close() ."\r\n"; ?> 
            <?php }else{ ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width=""><a href="#"><?php print $this->lang->line('account_id'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('product_type'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('consumer_key'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('consumer_secret'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('access_token'); ?></a></th>
                                <th><a href="#"><?php print $this->lang->line('access_token_secret'); ?></a></th>
                                <th width=""><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="13" class="text-center" style="color: #FF0000;">
                                <?php print $this->lang->line('no_result'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane <?php echo ($tab == 'system') ? 'active' : ''; ?>" id="system">
       <br>
        <?php print form_open_multipart('adminpanel/settings/save_system_settings', array('id' => 'system_setting_form')) ."\r\n"; ?>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="Site Title"><?php print $this->lang->line('site_title'); ?></label>
                    <input type="text" class="form-control" name="site_title" id="site_title" value="<?php print Settings_model::$db_config['site_title']; ?>" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
                </div>
                <div class="col-sm-6 form-group">
                   <label for="Predefined Email"><?php print $this->lang->line('predefined_email'); ?></label>
                   <input type="text" class="form-control" name="predefined_email" id="predefined_email" value="<?php print Settings_model::$db_config['predefined_email']; ?>" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
                   <label style="color:#9C9696; font-size:12px;">eg. @bexcel.com</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="Site Language"><?php print $this->lang->line('site_language'); ?></label>
                        <select class="form-control" name="site_language" id="site_language" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required >

                            <option value="english"               <?php (Settings_model::$db_config['site_language'] == 'english' )?  print 'selected' : ''; ?>
>English</option>
                            <option value="chinese"               <?php (Settings_model::$db_config['site_language'] == 'chinese' )?  print 'selected' : ''; ?>
>中文</option>
                        </select>
                </div>
                <div class="col-sm-6 form-group">
                   <label for="Footer Title"><?php print $this->lang->line('footer_title'); ?></label>
                   <input type="text" class="form-control" name="footer_title" id="footer_title" value="<?php print Settings_model::$db_config['footer_title']; ?>" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                   <label for="System Role"><?php print $this->lang->line('system_role'); ?></label>
                    <select class="form-control" id="system_role" name="system_role" data-parsley-trigger="focusout" data-parsley-errors-messages-disabled required>
                        <option value="<?php print Settings_model::$db_config['system_role']; ?>"selected><?php print Settings_model::$db_config['system_role']; ?></option>
                        <?php foreach($roles as $role) {  
                            if(($role->role_name)!=(Settings_model::$db_config['system_role']))
                            {?>
                            <option value="<?php print $role->role_name; ?>"><?php print $role->role_name; ?></option>
                        <?php } }?>
                   </select>
                </div>


       


                 <div class="col-sm-6 form-group">
                   <label for="Confidential Data Masking"><?php print $this->lang->line('confidential_data_masking'); ?></label>
                   <br>
                   <input type="radio" name="data_mask" value="Yes"  <?php (Settings_model::$db_config['data_mask'] == 'Yes' )?  print 'checked' : ''; ?>> <?php print $this->lang->line('yes')?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="radio" name="data_mask" value="No" <?php (Settings_model::$db_config['data_mask'] == 'No' )?  print 'checked' : ''; ?>> <?php print $this->lang->line('no')?>
                </div>
            </div>
             <div class="row">
                 <div class="col-sm-6 form-group">
                   <label for="Logo"><?php print $this->lang->line('logo'); ?></label>
                   <input type="file" class="form-control" name="userfile" id="userfile">



                </div>
                <div class="col-sm-6 form-group">
                   <label for="Search Section"><?php print $this->lang->line('search_section'); ?></label>
                   <br>
                   <input type="radio" name="search_section" value="in" 
                   <?php (Settings_model::$db_config['search_section'] == 'in' )?  print 'checked' : ''; ?>> <?php print $this->lang->line('open')?>&nbsp;&nbsp;&nbsp;&nbsp;


                    <input type="radio" name="search_section" value="" <?php (Settings_model::$db_config['search_section'] == '' )?  print 'checked' : ''; ?>> <?php print $this->lang->line('collapse')?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <button type="submit" id="system_setting_submit" class="btn btn-success js-btn-loading" ><i class="fa fa-floppy-o pd-r-5"></i> <?php print $this->lang->line('save'); ?></button>
                </div>
            </div>


        </div>
        <?php print form_close() ."\r\n"; ?>
    </div>

  </div>
</div>




























