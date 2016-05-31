<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

    <?php $this->load->view('generic/flash_error'); ?>
    <?php $tab = (isset($_GET['tab'])) ? $_GET['tab'] : ""; ?>


<style>


.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}


.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{margin-top:20px;
}


</style>
<div class="container">
    <div class="row">
		<div class="col-xs-12">
            <!-- <div class="col-xs-2">
                <a href="<?php print base_url()?>/adminpanel/list_members?type=session" class="btn btn-default js-btn-loading" data-loading-text="Going Back.."><i class="fa fa-reply"></i> Back</a>
                <br />
            </div> -->
            <div class="clearfix"></div>

            <div class="col-xs-11">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <a href="<?php print base_url()?>/adminpanel/list_members?type=session" class="btn btn-default js-btn-loading" data-loading-text="Going Back.."><i class="fa fa-reply"></i> <?php print $this->lang->line('back')?></a>
                        <br />
                    </div>
                    <div class="clearfix"></div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user_info" data-toggle="tab"><?php print $this->lang->line('user_information')?></a></li>
                        <li><a href="#daily_qa" data-toggle="tab"><?php print $this->lang->line('daily_qa')?></a></li>
                        <li ><a href="#monthly_qa" data-toggle="tab"><?php print $this->lang->line('monthly_qa')?></a></li>
                        <li ><a href="#ops_monthly" data-toggle="tab"><?php print $this->lang->line('ops_monthly')?></a></li>
                        <li ><a href="#login_logout" data-toggle="tab"><?php print $this->lang->line('login')?>/<?php print $this->lang->line('logout')?></a></li>
                        <li ><a href="#operator" data-toggle="tab"><?php print $this->lang->line('operator_utilization')?></a></li>
                        <li ><a href="#qa_evaluation" data-toggle="tab"><?php print $this->lang->line('qa_evaluation')?></a></li>
                        <li ><a href="#remarks" data-toggle="tab"><?php print $this->lang->line('remarks')?></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="user_info">

                            <div class="tabbable tabs-left">
                				<ul class="nav nav-tabs">
                					<li class="<?php echo ($tab == '')? 'active' : ''; ?>"><a href="#details" data-toggle="tab"><?php print $this->lang->line('user_details'); ?></a></li>
                                    <li class="<?php echo ($tab == 'profile') ? 'active' : ''; ?>"><a href="#profile" data-toggle="tab"><?php print $this->lang->line('user_profile'); ?></a></li>
                					<li class="<?php echo ($tab == 'ids') ? 'active' : ''; ?>"><a href="#ids" data-toggle="tab"><?php print $this->lang->line('user_ids'); ?></a></li>
                					<li class="<?php echo ($tab == 'leave') ? 'active' : ''; ?>"><a href="#leave" data-toggle="tab"><?php print $this->lang->line('leave_details'); ?></a></li>
                                    <!-- <li class="<?php echo ($tab == 'remark') ? 'active' : ''; ?>"><a href="#remark" data-toggle="tab"><?php print $this->lang->line('remarks'); ?></a></li>
                                    <li class="<?php echo ($tab == 'password') ? 'active' : ''; ?>"><a href="#password" data-toggle="tab"><?php print $this->lang->line('password'); ?></a></li> -->
                				</ul>
            				<div class="tab-content active">
            					<div class="tab-pane <?php echo ($tab == '') ? 'active' : ''; ?>" id="details">
                                    <div class="col-xs-10">
                                        <div class="row">
                                            <table class="table table-user-information">
                                               <tbody>
                                                <tr>
                                                   <td style="width : 35%"><?php print $this->lang->line('username')?> : </td>
                                                   <td><?php print $member->username?></td>
                                                </tr>
                                                <tr>
                                                   <td><?php print $this->lang->line('full_name')?> : </td>
                                                   <td><?php print $member->real_name?></td>
                                                </tr>
                                                <tr>
                                                   <td><?php print $this->lang->line('email_address')?> : </td>
                                                   <td><?php print $member->email?></td>
                                                </tr>
                                                <tr>
                                                   <td><?php print $this->lang->line('role')?> : </td>
                                                   <td><?php print $member->role?></td>
                                                </tr>
                                                <tr>
                                                   <td><?php print $this->lang->line('report_to')?> : </td>
                                                   <td><?php print $member->leader?></td>
                                                </tr>
                                                <tr>
                                                   <td>Windows ID : </td>
                                                   <td><?php print $member->windows_id?>  </td>
                                                </tr>
                                                <tr>
                                                    <td><?php print $this->lang->line('status')?> : </td>
                                                    <td><?php print $member->status?></td>
                                                </tr>

                                               </tbody>
                                            </table>
                                        </div>
                                    </div>
            					</div>
            					<div class="tab-pane <?php echo ($tab == 'profile') ? 'active' : ''; ?>" id="profile" >
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <table class="table table-user-information">
                                               <tbody>
                                                <tr>
                                                   <td style="width : 35%"><?php print $this->lang->line('nickname')?> : </td>
                                                   <td><?php print $member->nickname?></td>
                                                </tr>
                                                <tr>
                                                   <td><?php print $this->lang->line('dob')?> : </td>
                                                   <td><?php print $member->dob?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php print $this->lang->line('phone')?> : </td>
                                                   <td><?php print $member->phone?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php print $this->lang->line('emergency_contact')?> : </td>
                                                   <td><?php print $member->emergency_contact?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php print $this->lang->line('emergency_name')?> : </td>
                                                    <td><?php print $member->emergency_name?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php print $this->lang->line('relationship')?> : </td>
                                                   <td><?php print $member->relationship?></td>
                                                </tr>
                                               </tbody>
                                            </table>
                                        </div>
                                    </div>
            					</div>
            					<div class="tab-pane <?php echo ($tab == 'ids') ? 'active' : ''; ?>" id="ids">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <table class="table table-user-information">
                                               <tbody>
                                                <tr>
                                                   <td style="width : 35%">TB LP ID : </td>
                                                   <td><?php print $member->tb_lp_id?></td>
                                                </tr>
                                                <tr>
                                                   <td>TB LP Name : </td>
                                                   <td><?php print $member->tb_lp_name?></td>
                                                </tr>
                                                <tr>
                                                   <td>SY LP ID : </td>
                                                   <td><?php print $member->sy_lp_id?></td>
                                                </tr>
                                                <tr>
                                                   <td>SY LP Name : </td>
                                                   <td><?php print $member->sy_lp_name?></td>
                                                </tr>
                                                <tr>
                                                   <td>TB BO : </td>
                                                   <td><?php print $member->tb_bo?></td>
                                                </tr>
                                                <tr>
                                                   <td>GD BO : </td>
                                                   <td><?php print $member->gd_bo?></td>
                                                </tr>
                                                <tr>
                                                   <td>KENO BO : </td>
                                                   <td><?php print $member->keno_bo?></td>
                                                </tr>
                                                <tr>
                                                   <td>Cyber Roam : </td>
                                                   <td><?php print $member->cyber_roam?></td>
                                                </tr>
                                                <tr>
                                                   <td>RTX : </td>
                                                   <td><?php print $member->rtx?></td>
                                                </tr>

                                               </tbody>
                                            </table>
                                        </div>
                                    </div>
            					</div>
            					<div class="tab-pane <?php echo ($tab == 'leave') ? 'active' : ''; ?>" id="leave">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <table class="table table-user-information">
                                               <tbody>
                                                <tr>
                                                   <td style="width : 35%">AL : </td>
                                                   <td><?php
                                                           log_message('error', print_r($leave, true));
                                                           print $leave->total_al;?></td>
                                                </tr>
                                                <tr>
                                                   <td>ML : </td>
                                                   <td><?php print $leave->total_ml;?></td>
                                                </tr>
                                                <tr>
                                                   <td>EL : </td>
                                                   <td><?php print $leave->total_el;?></td>
                                                </tr>
                                                <tr>
                                                   <td>UL : </td>
                                                   <td><?php print $leave->total_ul;?></td>
                                                </tr>
                                                <tr>
                                                   <td>VW : </td>
                                                   <td><?php print $leave->total_vw;?></td>
                                                </tr>
                                                <tr>
                                                   <td>FW : </td>
                                                   <td><?php print $leave->total_fw;?></td>
                                                </tr>
                                               </tbody>
                                            </table>
                                        </div>
                                    </div>
            					</div>
                            </div>
			            </div>
                        </div>
                        <div class="tab-pane fade" id="daily_qa">
                            <?php $this->load->view('themes/adminpanel/member_details/daily_qa_table'); ?>
                        </div>
                        <div class="tab-pane fade" id="monthly_qa">
                            <?php $this->load->view('themes/adminpanel/member_details/monthly_qa_table'); ?>
                        </div>
                        <div class="tab-pane fade" id="ops_monthly">
                            <?php $this->load->view('themes/adminpanel/member_details/ops_monthly_table'); ?>
                        </div>
                        <div class="tab-pane fade" id="login_logout">
                            <?php $this->load->view('themes/adminpanel/member_details/log_in_out_table'); ?>
                        </div>
                        <div class="tab-pane fade" id="operator">
                            <?php $this->load->view('themes/adminpanel/member_details/operator_utilization_table'); ?>
                        </div>
                        <div class="tab-pane fade" id="qa_evaluation">
                            <?php $this->load->view('themes/adminpanel/member_details/qa_evaluation_table'); ?>
                        </div>
                        <div class="tab-pane fade" id="remarks">
                            <?php $this->load->view('themes/adminpanel/member_details/remark_table'); ?>
                        </div> <!-- end remark tab -->

                    </div>
                </div>
            </div>
        </div>

		</div>
	</div>
</div>

<script src="<?php print base_url(); ?>assets/js/adminpanel/view_member.js"></script>
