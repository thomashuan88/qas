<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul id="demo1" class="menu">
    <li class="hidden-folded">
        <div class="menu-section-title text-left">Control Panel</div>
    </li>
    <?php if (Site_Controller::check_permissions(1)) {  ?>
    <li<?php print ( in_array(Site_Controller::$page, array("list_members","add_member")) ? ' class="open"' : ""); ?>><a href="javascript:"><span class="menu-link-icon fa fa-users"></span> <span class="menu-link-title"><?php print $this->lang->line('user_management')?></span></a>
        <ul>
        <?php if (Site_Controller::check_permissions(2)) {  ?>
            <li<?php print ((trim(Site_Controller::$page) == "list_members") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/list_members"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('user_listing')?></a></li>
        <?php } ?>
         <?php if (Site_Controller::check_permissions(3)) {  ?>
            <li<?php print ((Site_Controller::$page == "add_member") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/add_member"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('add_user')?></a></li>
         <?php }?>
        </ul>
    </li>
    <?php }?>
     <?php if (Site_Controller::check_permissions(4)) {  ?>
    <li<?php print ( in_array(Site_Controller::$page, array("roles","permissions")) ? ' class="open"' : ""); ?>><a href="javascript:"><span class="menu-link-icon fa fa-diamond"></span> <span class="menu-link-title"><?php print $this->lang->line('roles_permissions')?></span></a>
        <ul>
         <?php if (Site_Controller::check_permissions(5)) {  ?>
            <li<?php print ((Site_Controller::$page == "roles") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/roles"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('role')?></a></li>
        <?php }?>
         <?php if (Site_Controller::check_permissions(6)) {  ?>
            <li<?php print ((Site_Controller::$page == "permissions") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/permissions"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('permissions')?></a></li>
        <?php }?>
        </ul>
    </li>
    <?php }?>
    <?php if (Site_Controller::check_permissions(7)) {  ?>
    <li<?php print ( in_array(Site_Controller::$page, array("daily_qa","monthly_qa","ops_monthly","log_in_out","qa_evaluation","operation_utilization")) ? ' class="open"' : ""); ?>><a href="javascript:"><span class="menu-link-icon fa fa-file-text"></span> <span class="menu-link-title"><?php print $this->lang->line('performance_report')?></span></a>
        <ul>
        <?php if (Site_Controller::check_permissions(8)) {  ?>
            <li<?php print ((Site_Controller::$page == "daily_qa") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/daily_qa"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('daily_qa')?></a></li>
         <?php }?>
         <?php if (Site_Controller::check_permissions(9)) {  ?>
            <li<?php print ((Site_Controller::$page == "monthly_qa") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/monthly_qa"><span class="menu-link-icon fa fa-angle-right"></span><?php print $this->lang->line('monthly_qa')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(10)) {  ?>
            <li<?php print ((Site_Controller::$page == "ops_monthly") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/ops_monthly"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('ops_monthly')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(11)) {  ?>
            <li<?php print ((Site_Controller::$page == "log_in_out") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/log_in_out"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('log_in_out')?></a></li>
         <?php }?>
         <?php if (Site_Controller::check_permissions(12)) {  ?>
            <li<?php print ((Site_Controller::$page == "qa_evaluation") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/qa_evaluation"><span class="menu-link-icon fa fa-angle-right"></span> <?php print $this->lang->line('qa_evaluation')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(13)) {  ?>
            <li<?php print ((Site_Controller::$page == "operation_utilization") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/operation_utilization"><span class="menu-link-icon fa fa-angle-right"></span>  <?php print $this->lang->line('operation_utilization')?></a></li>
        <?php }?>
        </ul>
    </li>
    <?php }?>
    <?php if (Site_Controller::check_permissions(14)) { 
// print Site_Controller::$page;
     ?>
    <li <?php print (Site_Controller::$page == "operation") ? ' class="open"' : ""; ?>><a href="javascript:"><span class="menu-link-icon fa fa-file-text"></span> <span class="menu-link-title">Operation</span></a>
        <ul>
        <?php if (Site_Controller::check_permissions(15)) {  ?>
            <li<?php print ((Site_Controller::$page == "shift_report") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/operation/shift_report"><span class="menu-link-icon fa fa-angle-right"></span>&nbsp;<?php print $this->lang->line('shift_report')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(16)) {  ?>
            <li<?php print ((Site_Controller::$page == "information_update") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/operation/information_update"><span class="menu-link-icon fa fa-angle-right"></span>&nbsp;<?php print $this->lang->line('information_update')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(17)) {  ?>
            <li<?php print ((Site_Controller::$page == "time_sheet") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/operation/time_sheet"><span class="menu-link-icon fa fa-angle-right"></span>&nbsp;<?php print $this->lang->line('time_sheet')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(18)) {  ?>
            <li<?php print ((Site_Controller::$page == "question_type") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/operation/question_type"><span class="menu-link-icon fa fa-angle-right"></span>&nbsp;<?php print $this->lang->line('question_type')?></a></li>
        <?php }?>
        <?php if (Site_Controller::check_permissions(19)) {  ?>
            <li<?php print ((Site_Controller::$page == "question_content") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/operation/question_content"><span class="menu-link-icon fa fa-angle-right"></span>&nbsp;<?php print $this->lang->line('question_content')?></a></li>
        <?php }?>
        </ul>
    </li>
    <?php }?>
    <?php if (Site_Controller::check_permissions(21)) {  ?>
    <li<?php print ((Site_Controller::$page == "roster_management") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/roster_management"><span class="menu-link-icon fa fa-table"></span> <span class="menu-link-title"> <?php print $this->lang->line('roster')?></span></a></li>
    <?php }?>

    <?php if (Site_Controller::check_permissions(23)) {  ?>
        <li<?php print ((Site_Controller::$page == "settings") ? ' class="open"' : ""); ?>><a href="<?php print base_url(); ?>adminpanel/settings"><span class="menu-link-icon fa fa-cogs"></span> <span class="menu-link-title"><?php print $this->lang->line('settings'); ?></span></a>
    <?php } ?>
</ul>
