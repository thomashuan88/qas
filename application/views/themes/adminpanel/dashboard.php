<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>


<div class="row text-center">
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <div class="panel-body bg-primary">
                <h4 class="f300">New members <small class="fg-white"><em>this week</em></small></h4>
            </div>
            <div class="panel-body bg-white">
                <h3 class="mg-0 f900"><?php print $new_week->count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <div class="panel-body bg-primary">
                <h4 class="f300">New members <small class="fg-white"><em>this month</em></small></h4>
            </div>
            <div class="panel-body bg-white">
                <h3 class="mg-0 f900"><?php print $new_month->count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <div class="panel-body bg-primary">
                <h4 class="f300">New members <small class="fg-white"><em>this year</em></small></h4>
            </div>
            <div class="panel-body bg-white">
                <h3 class="mg-0 f900"><?php print $new_year->count; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <div class="panel-body bg-primary">
                <h4>Total member count</h4>
            </div>
            <div class="panel-body bg-white">
                <h3 class="mg-0 f900"><?php print $total_users; ?></h3>
            </div>
        </div>
    </div>
</div>

<h2>Latest members</h2>

<div class="panel card bd-0">
    <div class="panel-body bg-white">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>

                <tr>
                    <th>id</th>
                    <th>username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($latest_members as $member) { ?>
                    <tr>
                        <td><?php print $member->user_id; ?></td>
                        <td><?php print $member->username; ?></td>
                        <td><?php print $member->first_name; ?></td>
                        <td><?php print $member->last_name; ?></td>
                        <td><?php print $member->email; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<h2>Static stuff</h2>

<p>
    We don't have any connection to the database on the examples below, all values are hard-coded. As more new features are added we will
    modify this page and you suggestions could definitely improve this page.
</p>

<div class="row">

    <div class="col-sm-6">

        <div class="panel card bd-0">

            <div class="panel-body bg-white text-center pd-0">

                <div class="row tbl">
                    <div class="col-xs-6 bd-light-gray-right">
                        <div class="row tbl">
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-star fa-2x pd-t-5 fg-warning"></i>
                            </div>
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">STARS</h5>
                                <h4 class="mg-0 fg-gray"><strong>5,685</strong></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 pd-15">
                        <div class="row tbl">
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-flag fa-2x pd-t-5 fg-success"></i>
                            </div>
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">FLAGS</h5>
                                <h4 class="mg-0 fg-gray"><strong>1,269</strong></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="hr-light-gray mg-0">

                <div class="row tbl">
                    <div class="col-xs-6 bd-light-gray-right">
                        <div class="row tbl">
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-share-alt fa-2x pd-t-5 fg-danger"></i>
                            </div>
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">SHARED</h5>
                                <h4 class="mg-0 fg-gray"><strong>18,474</strong></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 pd-15">
                        <div class="row tbl">
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-comments fa-2x pd-t-5 fg-info"></i>
                            </div>
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">COMMENTS</h5>
                                <h4 class="mg-0 fg-gray"><strong>86,910</strong></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="col-sm-6">

        <div class="panel card bd-0">

            <div class="panel-body bg-white text-center pd-0">

                <div class="row tbl">
                    <div class="col-xs-6 bd-light-gray-right">
                        <div class="row tbl">
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">SALES</h5>
                                <h4 class="mg-0 fg-gray"><strong>7,922</strong></h4>
                            </div>
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-money fa-2x pd-t-5 fg-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 pd-15">
                        <div class="row tbl">
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">DRINKS</h5>
                                <h4 class="mg-0 fg-gray"><strong>7,838</strong></h4>
                            </div>
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-glass fa-2x pd-t-5 fg-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="hr-light-gray mg-0">

                <div class="row tbl">
                    <div class="col-xs-6 bd-light-gray-right">
                        <div class="row tbl">
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">EVENTS</h5>
                                <h4 class="mg-0 fg-gray"><strong>561</strong></h4>
                            </div>
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-magic fa-2x pd-t-5 fg-inverse"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 pd-15">
                        <div class="row tbl">
                            <div class="col-xs-8">
                                <h5 class="mg-t-0">PARTS</h5>
                                <h4 class="mg-0 fg-gray"><strong>166</strong></h4>
                            </div>
                            <div class="col-xs-4 pd-0">
                                <i class="fa fa-cubes fa-2x pd-t-5 fg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row">
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <a href="javascript:" class="panel-body bg-white fg-info fg-darken pd-0">
                <div class="row tbl">
                    <div class="col-xs-4 pd-15">
                                <span class="icon icon-2x round bg-info bg-darken fg-white bd-0">
                                    <i class="fa fa-share-alt fa-2x"></i>
                                </span>
                    </div>
                    <div class="col-xs-8 pd-15 text-right">
                        <h2 class="mg-0 300">2,568</h2>
                        <span class="sml fg-gray fg-darken">CONNECTIONS</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <a href="javascript:" class="panel-body bg-white fg-success fg-darken pd-0">
                <div class="row tbl">
                    <div class="col-xs-4 pd-15">
                                <span class="icon icon-2x round bg-success bg-darken fg-white bd-0">
                                    <i class="fa fa-briefcase fa-2x"></i>
                                </span>
                    </div>
                    <div class="col-xs-8 pd-15 text-right">
                        <h2 class="mg-0 300">86</h2>
                        <span class="sml fg-gray fg-darken">PROJECTS</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <a href="javascript:" class="panel-body bg-white fg-warning fg-darken pd-0">
                <div class="row tbl">
                    <div class="col-xs-4 pd-15">
                                <span class="icon icon-2x round bg-warning bg-darken fg-white bd-0">
                                    <i class="fa fa-tasks fa-2x"></i>
                                </span>
                    </div>
                    <div class="col-xs-8 pd-15 text-right">
                        <h2 class="mg-0 300">7,506</h2>
                        <span class="sml fg-gray fg-darken">TASKS</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel card bd-0">
            <a href="javascript:" class="panel-body bg-white fg-danger fg-darken pd-0">
                <div class="row tbl">
                    <div class="col-xs-4 pd-15">
                                <span class="icon icon-2x round bg-danger bg-darken fg-white bd-0">
                                    <i class="fa fa-paperclip fa-2x"></i>
                                </span>
                    </div>
                    <div class="col-xs-8 pd-15 text-right">
                        <h2 class="mg-0 300">953</h2>
                        <span class="sml fg-gray fg-darken">FILE SHARES</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="panel card bd-00">
            <a class="panel-body bg-danger bg-darken fg-white">
                <div class="row">
                    <div class="col-xs-7 text-left">
                        <h1 class="mg-0 300">23%</h1>
                        SERVER LOAD<br>
                        <hr class="hr-white opacity-2 mg-t-5 mg-b-5">
                        <small><i class="fa fa-check"></i> Uptime: 99.98%</small>
                    </div>
                    <div class="col-xs-5 text-right">
                        <i class="fa fa-area-chart fa-4x mg-r-5"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel card bd-off">
            <a class="panel-body bg-info bg-darken fg-white">
                <div class="row">
                    <div class="col-xs-7 text-left">
                        <h1 class="mg-0 300">48</h1>
                        NEW TASKS<br>
                        <hr class="hr-white opacity-2 mg-t-5 mg-b-5">
                        <small><i class="fa fa-plus"></i> 14 new this week</small>
                    </div>
                    <div class="col-xs-5 text-right">
                        <i class="fa fa-tasks fa-4x mg-r-5"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>