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
                                        <a href="<?php print base_url() ."adminpanel/settings/edit_shift/".$shift->sid; ?>"class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                        <i class="fa fa-pencil-square"></i></a>
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
                        <a href="<?php print base_url() ."adminpanel/settings/product_settings_add/"?>">
                            <button type="button" class="btn btn-primary">
                                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                            </button>
                        </a>
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
                                        <a href="<?php print base_url() ."adminpanel/settings/edit_product/".$product->sid; ?>"class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                        <i class="fa fa-pencil-square"></i></a>
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
                        <a href="<?php print base_url() ."adminpanel/settings/live_person_settings_add/"?>">
                            <button type="button" class="btn btn-primary">
                                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                            </button>
                        </a>
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
                                    <a href="<?php print base_url() ."adminpanel/settings/edit_live_person/".$product; ?>"class="btn btn-primary btn-circle edit" title="<?php print $this->lang->line('edit'); ?>" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                        <i class="fa fa-pencil-square"></i></a>
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
        <?php print form_open('adminpanel/settings/save_system_settings', array('id' => 'save_system')) ."\r\n"; ?>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="Site Title"><?php print $this->lang->line('site_title'); ?></label>
                    <input type="text" class="form-control" name="site_title" id="site_title" value="<?php print Settings_model::$db_config['site_title']; ?>">
                </div>
                <div class="col-sm-6 form-group">
                   <label for="Predefined Email"><?php print $this->lang->line('predefined_email'); ?></label>
                   <input type="text" class="form-control" name="predefined_email" id="predefined_email" value="<?php print Settings_model::$db_config['predefined_email']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="Site Language"><?php print $this->lang->line('site_language'); ?></label>
                        <select class="form-control" name="site_language" id="site_language" >
                            <option value="english">English</option>
                            <option value="chinese">中文</option>
                        </select>
                </div>
                <div class="col-sm-6 form-group">
                   <label for="Footer Title"><?php print $this->lang->line('footer_title'); ?></label>
                   <input type="text" class="form-control" name="footer_title" id="footer_title" value="<?php print Settings_model::$db_config['footer_title']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                   <label for="System Role"><?php print $this->lang->line('system_role'); ?></label>
                   <input type="text" class="form-control" name="system_role" id="system_role" value="<?php print Settings_model::$db_config['system_role']; ?>"> 
                </div>
                 <div class="col-sm-6 form-group">
                   <label for="Website URL"><?php print $this->lang->line('website_url'); ?></label>
                   <input type="text" class="form-control" name="website_url" id="website_url" >
                </div>
            </div>
             <div class="row">
                 <div class="col-sm-6 form-group">
                   <label for="Logo"><?php print $this->lang->line('logo'); ?></label>
                   <input type="file" class="form-control" name="logo" id="logo" >
                </div>
                <div class="col-sm-6 form-group">
                   <label for="Website URL"><?php print $this->lang->line('search'); ?></label>
                   <input type="text" class="form-control" name="website_url" id="website_url" >
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <button type="submit" class="btn btn-success js-btn-loading" ><?php print $this->lang->line('save'); ?></button>
                </div>
            </div>


        </div>
        <?php print form_close() ."\r\n"; ?>
    </div>

  </div>
</div>





























