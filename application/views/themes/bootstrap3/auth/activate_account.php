<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/content_head.php'); ?>


<div class="row">

    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

            <?php if (isset($error)) { ?>
            <div id="error">
                <div>
                    <h4><?php print $this->lang->line('activation_message_error_heading'); ?></h4>
                    <p><?php print $error; ?></p>
                </div>
            </div>
            <?php } ?>

            <?php if (isset($success)) { ?>
            <div id="success">
                <div>
                    <h4><?php print $this->lang->line('activation_message_success_heading'); ?></h4>
                    <p>Following is your account credentials</p>
                    <p>Username : <?php print $success['username']; ?></p>
                    <p>Password : <?php print $success['password']; ?></p>

                    <a href="<?php print base_url(); ?>"><h3>Proceed to login</h3></a>
                </div>
            </div>
            <?php } ?>
            <?php if (isset($expired)) { ?>
                <div id="error">
                    <div>
                        <h4><?php print $this->lang->line('activation_message_error_heading'); ?></h4>
                        <p><?php print $expired; ?></p>

                    </div>
                </div>
            <?php } ?>

    </div>

</div>
