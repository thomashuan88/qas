<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="header-fixed">

    <header class="navbar header" role="menu">

        <div class="navbar-header">
            <a class="navbar-brand block" href="<?php print base_url(); ?>">
                <?php if(!empty(Settings_model::$db_config['logo'])) { ?>
                <img src="<?php print base_url(); ?>assets/img/<?php print Settings_model::$db_config['logo']; ?>">
                <?php } ?>
                <!-- <i class="fa fa-cubes pull-left pd-r-10"></i>
                <div class="navbar-brand-title">
                    CI <span class="navbar-brand-title-small">Membership <small class="f900 text-primary"><em>v<?php print CIM_VERSION; ?></em></small></span>
                </div> -->
            </a>
        </div>

    </header>

</div>