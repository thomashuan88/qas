<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print Settings_model::$db_config['site_title']; ?>: <?php print $template['title']; ?></title>
    <?php print $template['metadata']; ?>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- stylesheet -->
    <link href="<?php print base_url(); ?>assets/css/adminpanel/bootstrap.min.css" rel="stylesheet">
    <?php print $template['css']; ?>

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

</head>

<body>
<div class="wrap header-fixed">


    <?php print $template['partials']['header']; ?>


    <aside class="aside">

        <ul id="demo1" class="menu">
            <li class="hidden-folded">
                <div class="menu-section-title text-left">Navigation</div>
            </li>
            <li></li>
            <li><a href="<?php print base_url(); ?>adminpanel"><span class="menu-link-icon fa fa-cubes"></span> <span class="menu-link-title">Adminpanel</span></a></li>
            <li><a href="<?php print base_url(); ?>private/dashboard"><span class="menu-link-icon fa fa-dashboard"></span> <span class="menu-link-title">Dashboard</span></a></li>
            <li><a href="<?php print base_url(); ?>private/profile"><span class="menu-link-icon fa fa-user"></span> <span class="menu-link-title">Profile</span></a></li>
            <li class="hidden-folded">
                <div class="menu-section-title text-left">Theming options</div>
            </li>
            <li><a href="javascript:"><span class="menu-link-icon fa fa-list-alt"></span> <span class="menu-link-title">Page Layouts</span></a>
                <ul>
                    <li><a href="<?php print base_url(); ?>"><span class="menu-link-icon fa fa-angle-right"></span> Left menu fluid</a></li>
                    <li><a href="<?php print base_url(); ?>"><span class="menu-link-icon fa fa-angle-right"></span> Left menu fixed</a></li>
                    <li><a href="<?php print base_url(); ?>"><span class="menu-link-icon fa fa-angle-right"></span> Right menu fluid</a></li>
                    <li><a href="<?php print base_url(); ?>"><span class="menu-link-icon fa fa-angle-right"></span> Right menu fixed</a></li>
                </ul>
            </li>
        </ul>

        <?php $this->load->view('themes/adminpanel/partials/aside-below.php'); ?>

    </aside>

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

    <div class="content">

        <?php print $template['body']; ?>

    </div>


    <footer class="footer">
        <?php print $template['partials']['footer']; ?>

    </footer>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js">\x3C/script>')</script>
<script src="<?php print base_url(); ?>assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/jquery.navgoco.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/jquery.slimscroll.min.js"></script>
<?php print $template['js'];
$this->load->view('generic/js_system');
?>
<script src="<?php print base_url(); ?>assets/js/app.js"></script>
</body>
</html>