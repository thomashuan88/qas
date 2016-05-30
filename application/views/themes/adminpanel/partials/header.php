<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
.language-menu > li > a:hover {
    background-color: #141619;
    color: #e16e41 !important;
}
</style>


    <header class="navbar header" role="menu">
        <div class="navbar-header">
            <a class="navbar-brand block" href="<?php print base_url(); ?>">
            
                <img src="<?php print base_url(); ?>assets/img/<?php print Settings_model::$db_config['logo']; ?>">
            </a>

        </div>

        <a id="js-showhide-menu" href="javascript:" class="btn navbar-btn">
            <i class="fa fa-eye-slash"></i>
        </a>

        <a id="js-narrow-menu" href="javascript:" class="btn navbar-btn">
            <i class="fa fa-bars"></i>
        </a>

        <a href="<?php print base_url(); ?>logout" class="btn navbar-btn pull-right" data-toggle="tooltip" title=<?php print $this->lang->line('logout'); ?>>
            <i class="fa fa-power-off" style="color:#e16e41">&nbsp;&nbsp;</i><span style="color:#e16e41"><?php print $this->lang->line('logout'); ?></span>
        </a>
        <a id="js-extramenu" href="javascript:" class="btn navbar-btn pull-right">
            <i class="fa fa-sticky-note-o"></i>
        </a>
        


        <li class = "btn navbar-btn dropdown pull-right">
            <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown" >
                <i class="fa fa-language"></i> <?php print $this->lang->line('language'); ?> <b class = "caret"></b>
            </a>
            <ul class = "dropdown-menu  language-menu " style="border:none;min-width:100%;background-color:#2a2f36;color:#979797;">    
                <li style="">
                    <a class="language" href="javascript:location.reload();" id ="english" style="color:#979797;">English </a>
                </li>
                <li>
                    <a class="language" href="javascript:location.reload();" id ="chinese" style="color:#979797;">中文</a>
                </li>
            </ul>
        </li>

        <a class="btn navbar-btn pull-right">
           <i class="fa fa-user">&nbsp;&nbsp;</i><?php print $this->session->userdata('username'); ?>
        </a> 
    </header>


<script type="text/javascript">


$(document).ready(function() {

     $("a.language").click(function(){

        var link = $(this).attr('id');    
        var data = {language:link};
        $.post('/adminpanel/header/change_language', data);
     });
});

</script>