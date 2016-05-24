<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<?php $this->load->view('themes/'. Settings_model::$db_config['active_theme'] .'/partials/content_head.php'); ?>

<div class="row text-center">

    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
    	<div><img src="<?php print base_url(); ?>assets/img/ironcat.png" style="height:300px;"></div>

        <h1 class="text-primary f900"><?php print $this->lang->line('error_404'); ?></h1>

        <p>
            <a href="<?php print base_url(); ?>default_page"><?php print $this->lang->line('return_to_home'); ?></a>
        </p>

    </div>

</div>
