<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

    <?php $this->load->view('generic/flash_error'); ?>

    <h2><?php print $this->lang->line('export_title'); ?></h2>

    <p>
        <span class="form_subtext"><?php print $this->lang->line('backup_text'); ?></span>
    </p>

    <?php print form_open('adminpanel/backup_export/export_members', array('id' => 'export_members_form')) ."\r\n"; ?>

    <p class="spacer">
        <button type="submit" name="export_submit" id="export_submit" class="message_cleanup btn btn-primary btn-lg js-btn-loading" data-loading-text="Working..."><i class="fa fa-list-ol pd-r-5"></i> Export memberlist</button>
    </p>

    <?php print form_close() ."\r\n";

    print form_open('adminpanel/backup_export/export_database', array('id' => 'export_database_form')) ."\r\n"; ?>

    <h2><?php print $this->lang->line('backup_title'); ?></h2>

    <p>
        <span class="form_subtext"><?php print $this->lang->line('backup_text'); ?></span><br>
        <span class="form_subtext"><?php print $this->lang->line('backup_warning1'); ?></span><br>
        <span class="form_subtext"><?php print $this->lang->line('backup_warning2'); ?></span><br>
    </p>

    <p class="spacer">
        <button type="submit" name="db_backup_submit" id="db_backup_submit" class="message_cleanup btn btn-primary btn-lg js-btn-loading" data-loading-text="Working..."><i class="fa fa-database pd-r-5"></i> Export database</button>
    </p>

    <?php print form_close() ."\r\n";