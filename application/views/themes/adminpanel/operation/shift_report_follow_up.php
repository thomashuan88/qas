<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table class="table ">
                <tr>
                    <td><label><?php print $this->lang->line('product'); ?></label></td>
                    <td><span class="info"><?php print $report->product ?></span></td>
                    <td><label><?php print $this->lang->line('player_name'); ?></label></td>
                    <td><span class="info"><?php print $report->player_name ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('category'); ?></label></td>
                    <td><span class="info"><?php print $report->category_id ?></span></td>
                    <td><label><?php print $this->lang->line('sub_category'); ?></label></td>
                    <td><span class="info"><?php print $report->sub_category_id ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('follow_up_by'); ?></label></td>
                    <td><span class="info"><?php print $report->follow_up ?></span></td>
                    <td><label><?php print $this->lang->line('shift'); ?></label></td>
                    <td><span class="info"><?php print $report->shift ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('finish_time'); ?></label></td>
                    <td><span class="info"><?php print $report->finish ?></span></td>
                    <td><label><?php print $this->lang->line('status'); ?></label></td>
                    <td><span class="info"><?php print $report->status ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('submit_time'); ?></label></td>
                    <td><span class="info"><?php print $report->created_time ?></span></td>
                    <td><label><?php print $this->lang->line('submit_by'); ?></label></td>
                    <td><span class="info"><?php print $report->created_by ?></span></td>
                </tr>
                <tr>
                    <td><label><?php print $this->lang->line('remark'); ?></label></td>
                    <td colspan="3"><span class="info"><?php print $report->remarks ?></span></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="mg-b-10">
            <h4 class="text-uppercase f900">
                <?php print  $this->lang->line('total_follow_up_reports') . "&nbsp;:&nbsp;" . $total_rows; ?>
            </h4>
        </div>
        <div class="mg-b-10">
            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up_insert/". $report->shift_reports_id; ?>">
                <button type="button" class="btn btn-primary">
                    <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
                </button>
            </a>
        </div>
        <?php if (!empty($follow_up)) { ?>
            <?php print form_open('adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/' . $order_by . '/' . $sort_order . '/' . $search . '/' . $offset) . "\r\n"; ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/follow_up_id/" . ($order_by == "follow_up_id" ? ($sort_order == "asc" ? "desc" : "asc") : "asc") . "/" . $search . "/0"; ?>">
                                <i class="<?php print ($order_by == "follow_up_id" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down") : ""); ?>"></i>&nbsp;<?php print $this->lang->line('id'); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/follow_up/" . ($order_by == "follow_up" ? ($sort_order == "asc" ? "desc" : "asc") : "asc") . "/" . $search . "/0"; ?>">
                                <i class="<?php print ($order_by == "follow_up" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down") : ""); ?>"></i>&nbsp;<?php print $this->lang->line('follow_up_by'); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/status/" . ($order_by == "status" ? ($sort_order == "asc" ? "desc" : "asc") : "asc") . "/" . $search . "/0"; ?>">
                                <i class="<?php print ($order_by == "status" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down") : ""); ?>"></i>&nbsp;<?php print $this->lang->line('status'); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/remarks/" . ($order_by == "remarks" ? ($sort_order == "asc" ? "desc" : "asc") : "asc") . "/" . $search . "/0"; ?>">
                                <i class="<?php print ($order_by == "remarks" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down") : ""); ?>"></i>&nbsp;<?php print $this->lang->line('remark'); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/created_by/" . ($order_by == "created_by" ? ($sort_order == "asc" ? "desc" : "asc") : "asc") . "/" . $search . "/0"; ?>">
                                <i class="<?php print ($order_by == "created_by" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down") : ""); ?>"></i>&nbsp;<?php print $this->lang->line('submit_by'); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php print base_url() . "adminpanel/operation/shift_report_follow_up/' . $report->shift_reports_id . '/created_time/" . ($order_by == "created_time" ? ($sort_order == "asc" ? "desc" : "asc") : "asc") . "/" . $search . "/0"; ?>">
                                <i class="<?php print ($order_by == "created_time" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down") : ""); ?>"></i>&nbsp;<?php print $this->lang->line('submit_time'); ?>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($follow_up->result() as $follow_up): ?>
                        <tr>
                            <td><?php print $follow_up->follow_up_id; ?></td>
                            <td><?php print $follow_up->follow_up; ?></td>
                            <td>
                                <?php if ($follow_up->status == "active") : ?>
                                    <a class="label label-success" href="#"><?php print $this->lang->line('active'); ?></a>
                                <?php else: ?>
                                    <a class="label label-danger" href="#"><?php print $this->lang->line('inactive'); ?></a>
                                <?php endif; ?>
                            </td>
                            <td><?php print $follow_up->remarks; ?></td>
                            <td><?php print $follow_up->created_by; ?></td>
                            <td><?php print $follow_up->created_time; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php print form_close() . "\r\n"; ?>
            <div class="col-xs-2 pull-right">
                <?php print $this->pagination->create_links(); ?>
            </div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><a href="#"><?php print $this->lang->line('id'); ?></a></th>
                        <th><a href="#"><?php print $this->lang->line('follow_up_by'); ?></a></th>
                        <th><a href="#"><?php print $this->lang->line('status'); ?></a></th>
                        <th><a href="#"><?php print $this->lang->line('remark'); ?></a></th>
                        <th><a href="#"><?php print $this->lang->line('submit_by'); ?></a></th>
                        <th><a href="#"><?php print $this->lang->line('submit_time'); ?></a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="6" class="text-center" style="color: #FF0000;">
                            <?php print $this->lang->line('no_result'); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
