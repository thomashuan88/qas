<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    <?php
    if ($this->session->flashdata('error') != "") {
        ?>
    <div id="error">
        <div class="alert alert-danger alert-dismissible fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></button>
            <h4><?php print $this->lang->line('message_error_heading'); ?></h4>
            <?php print $this->session->flashdata('error'); ?>
        </div>
        </div>
    <?php
    }
    ?>


    <?php
    if ($this->session->flashdata('success') != "") {
        ?>
    <div id="success">
        <div class="alert alert-success alert-dismissible fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></button>
            <h4><?php print $this->lang->line('message_success_heading'); ?></h4>
            <?php print $this->session->flashdata('success'); ?>
        </div>
    </div>
    <?php
    }
    ?>
