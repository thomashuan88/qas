<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>

    <p>
        <a href="<?php print base_url(); ?>adminpanel/oauth_new_provider" class="btn btn-default">Add new</a>
    </p>

<?php if (!empty($providers)) { ?>

    <p><strong><?php print $this->lang->line('provider_subtitle'); ?></strong></p>
    <div class="table-responsive">
        <table  class="table table-hover">
            <thead>
            <tr>
                <th><?php print $this->lang->line('provider_name'); ?></th>
                <th><?php print $this->lang->line('client_id'); ?></th>
                <th><?php print $this->lang->line('client_secret'); ?></th>
                <th><?php print $this->lang->line('provider_enabled'); ?></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($providers as $provider) { ?>

                <?php print form_open('adminpanel/oauth2_providers/action') ."\r\n"; ?>

                <tr>
                    <td><input type="text" name="name" class="form-control input-lg" value="<?php print $provider->name; ?>"></td>
                    <td><input type="text" name="client_id" class="form-control input-lg" value="<?php print $provider->client_id; ?>"></td>
                    <td><input type="text" name="client_secret" class="form-control input-lg" value="<?php print $provider->client_secret; ?>"></td>
                    <td>
                        <?php print form_dropdown('enabled', $enabled, $provider->enabled, 'class="form-control input-lg"'); ?>
                    </td>
                    <td>
                        <button type="submit" name="save" class="btn-lg btn btn-primary js-btn-loading"><i class="fa fa-check pd-r-5"></i> <?php print $this->lang->line('provider_save'); ?></button>
                        <button type="submit" name="delete" class="btn btn-danger btn-lg js-confirm-delete"><i class="fa fa-trash-o pd-r-5"></i> <?php print $this->lang->line('provider_delete'); ?></button>
                        <input type="hidden" name="id" value="<?php print $provider->id; ?>">
                    </td>
                </tr>

                <?php print form_close() ."\r\n"; ?>

            <?php } ?>

            </tbody>
        </table>
    </div>
<?php } ?>