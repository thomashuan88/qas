<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/list_members/index/username/asc/post/0') ."\r\n"; ?>

<button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
    <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> expand</span> search <i class="fa fa-search pd-l-5"></i>
</button>

    <div id="search_wrapper" class="collapse">

        <div class="pd-15 bg-primary mg-t-15 mg-b-10">
            <h2 class="text-uppercase mg-t-0">
                <?php print $this->lang->line('search_member'); ?>
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




                <?php print form_close() ."\r\n"; ?>
            </div>
        </div>

		<div class="row mg-b-20">
			<div class="col-xs-12 clearfix">
                <button type="submit" name="member_search_submit" id="member_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
                    <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('search_member'); ?>
                </button>
            </div>
		</div>
    </div>

	<div class="row margin-top-30">

		<div class="col-xs-12">
            <div class="row">
                <div class="col-xs-7">
                    <h4 class="text-uppercase f900">
        				<?php print  $this->lang->line('total_members') .":". $total_rows; ?>
        			</h4>

        			<?php if (isset($members)) { ?>
                </div>

            </div>


			<?php print form_open('adminpanel/list_members/mass_action/'. $offset .'/'. $order_by .'/'. $sort_order .'/'. $search, 'id="mass_action_form"') ."\r\n"; ?>

            <!-- <?php $this->load->view('themes/adminpanel/partials/list_members_action.php'); ?> -->

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            <div class="app-checkbox">
                                <label class="pd-r-10">
                                    <input type="checkbox" class="js-select-all-members">
                                    <span class="fa fa-check"></span>
                                </label>
                            </div>
                        </th>
                        <!-- <th class="text-center"><a href="<?php print base_url() ."adminpanel/list_members/index/active/". ($order_by == "active" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>" class="<?php print ($order_by == "active" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"><i class="fa fa-plug"></i></a></th> -->
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/username/". ($order_by == "username" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "username" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i> <?php print $this->lang->line('username'); ?></a></th>
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/first_name/". ($order_by == "first_name" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "first_name" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i><?php print $this->lang->line('full_name'); ?></a></th>
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/last_name/". ($order_by == "last_name" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "last_name" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i><?php print $this->lang->line('role'); ?></a></th>
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/last_login/". ($order_by == "last_login" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "last_login" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i><?php print $this->lang->line('phone'); ?></a></th>
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/email/". ($order_by == "email" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "email" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i><?php print $this->lang->line('leader'); ?></a></th>
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/last_login/". ($order_by == "last_login" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "last_login" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i><?php print $this->lang->line('status'); ?></a></th>
                        <th><a href="<?php print base_url() ."adminpanel/list_members/index/last_login/". ($order_by == "last_login" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "last_login" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i><?php print $this->lang->line('action'); ?></a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($members->result() as $member):
                    ?>
                    <tr>
                        <td>
                            <?php if ($member->username != ADMINISTRATOR) { ?>
                            <div class="app-checkbox">
                                <label class="pd-r-10">
                                    <input type="checkbox" name="mass[]" value="<?php print $member->user_id; ?>" class="list_members_checkbox">
                                    <span class="fa fa-check"></span>
                                </label>
                            </div>
                        <?php } ?>
                        </td>


                        <td>
                            <!-- <a href="<?php print base_url(); ?>adminpanel/member_detail/<?php print $member->user_id; ?>"> -->
                                <?php print $member->username; ?>
                            <!-- </a> -->
                        </td>
                        <td><?php print $member->real_name; ?></td>

                        <td><?php print (!empty($member->first_name) ? $member->role : "-"); ?></td>
                        <td><?php print (!empty($member->last_name) ? $member->phone : "-"); ?></td>
                        <td><?php print (!empty($member->last_name) ? $member->leader : "-"); ?></td>

                        <td >
                            <?php if($member->status == "active") : ?>
                            <a class = "label label-success" href="<?php print site_url('adminpanel/list_members/toggle_active/'. $member->user_id ."/". $member->username ."/". $offset .'/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $member->status); ?>" title="]deactivate account">
                            <?php print $this->lang->line('active'); ?></a>
                        <?php else: ?>
                            <a class = "label label-danger" href="<?php print site_url('adminpanel/list_members/toggle_active/'. $member->user_id ."/". $member->username ."/". $offset .'/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $member->status); ?>" title="deinactivate account" >
                            <?php print $this->lang->line('inactive'); ?></a>
                        <?php endif; ?>
                        </td>
                        <td >
                            <a href="#" class="btn btn-info btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="User Sessions">
                                <i class="fa fa-list"></i>
                            </a>
                            <a href="<?php print base_url(); ?>adminpanel/member_detail/<?php print $member->user_id; ?>" class="btn btn-success btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="View User">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?php print base_url(); ?>adminpanel/member_detail/<?php print $member->user_id; ?>" class="btn btn-primary btn-circle edit" title="" data-toggle="tooltip" data-placement="top" data-original-title="Edit User">
                                <i class="fa fa-pencil-square"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-circle" title="" data-toggle="tooltip" data-placement="top" data-original-title="Delete User">
                                <i class="fa fa-trash"></i>
                            </a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- <?php $this->load->view('themes/adminpanel/partials/list_members_action.php'); ?> -->

			<input type="hidden" name="mass_action" id="mass_action" value="">

			<?php print form_close() ."\r\n"; ?>

            <div class="col-xs-2 pull-right">
                <?php print $this->pagination->create_links(); ?>
            </div>
			<?php }else{ ?>
				<p>No results found.</p>
			<?php } ?>

		</div>
	</div>
