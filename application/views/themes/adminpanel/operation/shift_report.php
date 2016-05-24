<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/' . Settings_model::$db_config['adminpanel_theme'] . '/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

<div class="row">
    <div class="col-md-2">
        <button id="js-search" type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
            <span id="js-search-text"><i class="fa fa-expand pd-r-5"></i> expand</span> search <i class="fa fa-search pd-l-5"></i>
        </button>
    </div>
    <div class="col-md-10" style="text-align: right;">
        <a href="<?php print base_url() . "adminpanel/operation/shift_report_insert/" ?>">
            <button type="button" class="btn btn-primary">
                <span><i class="fa fa-plus pd-r-5"></i>&nbsp;<?php echo $this->lang->line('add_new'); ?></span>
            </button>
        </a>
    </div>
</div>

<?php print form_open('adminpanel/operation/shift_report/shift_reports_id/desc/post/0') . "\r\n"; ?>
<div id="search_wrapper" class="collapse">
    <div class="pd-15 bg-primary mg-t-15 mg-b-10">
        <h2 class="text-uppercase mg-t-0">
            <?php print $this->lang->line('search_shift_report'); ?>
        </h2>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="id"><?php print $this->lang->line('id'); ?></label>
                    <input type="text" name="id" id="id" class="form-control" value="<?php print $this->session->flashdata('id');?>">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="product"><?php print $this->lang->line('product'); ?></label>
                    <input type="text" name="product" id="product" class="form-control" value="<?php print $this->session->flashdata('product');?>">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="category"><?php print $this->lang->line('category'); ?></label>
                    <input type="text" name="category" id="category" class="form-control" value="<?php print $this->session->flashdata('category');?>">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="shift"><?php print $this->lang->line('shift'); ?></label>
                    <input type="text" name="shift" id="shift" class="form-control" value="<?php print $this->session->flashdata('shift');?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="remarks"><?php print $this->lang->line('remarks'); ?></label>
                    <input type="text" name="remarks" id="remarks" class="form-control" value="<?php print $this->session->flashdata('remarks');?>">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="status"><?php print $this->lang->line('status'); ?></label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" <?php print ($this->session->flashdata('status') == 'active') ? "selected" : ""; ?>><?php print $this->lang->line('active'); ?></option>
                        <option value="inactive" <?php print ($this->session->flashdata('status') == 'inactive') ? "selected" : ""; ?>><?php print $this->lang->line('inactive'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="submit_time"><?php print $this->lang->line('submit_time'); ?></label>
                    <input type="text" name="submit_time" id="submit_time" class="form-control datetimepicker" value="<?php print $this->session->flashdata('submit_time');?>">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="finish_time"><?php print $this->lang->line('finish_time'); ?></label>
                    <input type="text" name="finish_time" id="finish_time" class="form-control datetimepicker" value="<?php print $this->session->flashdata('finish_time');?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row mg-b-20">
        <div class="col-xs-12 clearfix">
            <button type="submit" name="shift_reports_search_submit" id="shift_reports_search_submit" class="btn btn-primary btn-lg js-btn-loading" data-loading-text="Searching...">
                <i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('search'); ?>
            </button>
        </div>
    </div>
</div>
<?php print form_close() . "\r\n"; ?>

<div class="row margin-top-30">
    <div class="col-xs-12">
        <div class="mg-b-10">
            <h4 class="text-uppercase f900">
                <?php print  $this->lang->line('total_shift_reports') ."&nbsp;:&nbsp;".$total_rows;?>
            </h4>
        </div>
        <?php if (!empty($reports)) { ?>
            <?php print form_open('adminpanel/operation/shift_report/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset, 'id="shift_report_form"') ."\r\n"; ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/shift_reports_id/". ($order_by == "shift_reports_id" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "shift_reports_id" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('id'); ?></a></th>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/product/". ($order_by == "product" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "product" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('product'); ?></a></th>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/category_id/". ($order_by == "category_id" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "category_id" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('category'); ?></a></th>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/remarks/". ($order_by == "remarks" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "remarks" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('remarks'); ?></a></th>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/status/". ($order_by == "status" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "status" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('status'); ?></a></th>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/finish/". ($order_by == "finish" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "finish" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('finish_time'); ?></a></th>
                            <th><a href="<?php print base_url() ."adminpanel/operation/shift_report/created_time/". ($order_by == "created_time" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "created_time" ? ($sort_order == "asc" ? "fa fa-arrow-circle-o-up" : "fa fa-arrow-circle-o-down" ) : ""); ?>"></i>&nbsp;<?php print $this->lang->line('submit_time'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('action'); ?></a></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reports->result() as $reports): ?>
                        <tr>
                            <td><?php print $reports->shift_reports_id; ?></td>
                            <td><?php print $reports->product; ?></td>
                            <td><?php print $reports->category_id; ?></td>
                            <td><?php print $reports->remarks; ?></td>
                            <td>
                                <?php if($reports->status == "active") : ?>
                                    <a class = "label label-success" href="#"><?php print $this->lang->line('active'); ?></a>
                                <?php else: ?>
                                    <a class = "label label-danger" href="#"><?php print $this->lang->line('inactive'); ?></a>
                                <?php endif; ?>
                            </td>
                            <td><?php print $reports->finish; ?></td>
                            <td><?php print $reports->created_time; ?></td>
                            <td>
                                <a href="<?php print base_url() ."adminpanel/operation/shift_report_follow_up/".$reports->shift_reports_id; ?>" class="btn btn-info btn-circle" title="follow up" data-toggle="tooltip" data-placement="top" data-original-title="Follow up">
                                    <i class="fa fa-retweet"></i>
                                </a>
                                <a href="<?php print base_url() ."adminpanel/operation/shift_report_edit/".$reports->shift_reports_id; ?>" class="btn btn-primary btn-circle edit" title="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                    <i class="fa fa-pencil-square"></i>
                                </a>
                                <a href="<?php print base_url() ."adminpanel/operation/shift_report_delete/".$reports->shift_reports_id; ?>" class="btn btn-danger btn-circle delete" title="delete" data-toggle="tooltip" data-placement="top" data-method="DELETE">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php print form_close() ."\r\n"; ?>
            <div class="col-xs-2 pull-right">
                <?php print $this->pagination->create_links(); ?>
            </div>
        <?php }else{ ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><a href="#"><?php print $this->lang->line('id'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('product'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('category'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('remarks'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('status'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('finish_time'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('submit_time'); ?></a></th>
                            <th><a href="#"><?php print $this->lang->line('action'); ?></a></th>
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