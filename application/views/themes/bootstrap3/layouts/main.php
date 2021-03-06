<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php print Settings_model::$db_config['site_title']; ?>: <?php print $template['title']; ?></title>
    <?php print $template['metadata']; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Stylesheet -->
    <link href="<?php print base_url(); ?>assets/css/adminpanel/bootstrap.min.css" rel="stylesheet">
    <link href="<?php print base_url(); ?>assets/css/custom.css" rel="stylesheet">
    <link href="<?php print base_url(); ?>assets/js/vendor/jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet">

    <!-- Google web font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="/favicon.ico">
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script>window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js">\x3C/script>')</script>
    <script src="<?php print base_url(); ?>assets/js/vendor/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="<?php print base_url(); ?>assets/js/vendor/bootstrap.min.js"></script>
    <script src="<?php print base_url(); ?>assets/js/vendor/jquery.navgoco.js"></script>
    <script src="<?php print base_url(); ?>assets/js/vendor/jquery.slimscroll.min.js"></script>
    <script src="<?php print base_url(); ?>assets/js/vendor/bootbox.min.js"></script>
    <?php print $template['js']; ?>
    <?php $this->load->view('generic/js_system'); ?>
    <script type="text/javascript">
        var confirm_message = '<?php print $this->lang->line('confirm_message'); ?>';
        var delete_message = '<?php print $this->lang->line('delete_message'); ?>';
        var reset_message = '<?php print $this->lang->line('reset_message'); ?>';
    </script>
    <script src="<?php print base_url(); ?>assets/js/app.js"></script>
</head>

<body>

    <header>
        <?php print $template['partials']['header']; ?>
    </header>

    <aside id="extramenu" class="extramenu right pd-15">

        <h4>
            <strong>The state of this panel is remembered with localStorage. You can disable this in our JavaScript file.</strong>
        </h4>

        <p>
            Refresh the page and you will notice that the panel stays open. The same goes for the main side menu opposite to this menu.
        </p>

        <p>
            What should I put here? A chat system, quick navigation, tools or maybe profile info? Something will be added in future versions.
        </p>

        <p>
            In the meantime if you have any ideas you are most welcome to post them on <a href="http://codecanyon.net/user/rakinjakk"><em>my profile page on Codecanyon</em></a>.
        </p>

    </aside>

    <div class="content content-main">
        <?php print $template['body']; ?>
    </div>

    <footer class="footer footer-main">
        <?php print $template['partials']['footer']; ?>

    </footer>

    
</body>
</html>