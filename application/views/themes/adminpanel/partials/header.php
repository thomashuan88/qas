<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
.dropdown-menu > li > a:hover {
    background-color: #2a2f36;
    background-image: none;
}

</style>


    <header class="navbar header" role="menu">
        <div class="navbar-header">
            <a class="navbar-brand block" href="<?php print base_url(); ?>">
                <img src="<?php print base_url(); ?>assets/img/bexcel.png">
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
                <i class="fa fa-language"></i> Language <b class = "caret"></b>
            </a>
            <ul class = "dropdown-menu pull-right" style="border:none;min-width:107px;background-color:#2a2f36;color:#979797;">    
                <li style="">
                    <a href ="english" style="color:#979797;">English </a>
                </li>
                <li>
                    <a href ="chinese" style="color:#979797;">中文</a>
                </li>
            </ul>
        </li>

        <a class="btn navbar-btn pull-right">
            <select name="language" id="language" >
                <option value="english">English</option>
                <option value="chinese">中文</option>
            </select>
        </a>
        <a class="btn navbar-btn pull-right">
           <i class="fa fa-user">&nbsp;&nbsp;</i><?php print $this->session->userdata('username'); ?>
        </a> 
    </header>


<script type="text/javascript">


$(document).ready(function() {

    var link = $(this).attr('href');
  
    console.log(link);
});

//change language


   // var lang = "<?php echo $this->session->userdata['language']; ?>";

    // if(lang != ""){
    //     $("option[value='"+lang+"']").attr("selected", true);
    // }
//  $("select[name='language']").change(function(){

  
  // var language = $(this).text;
    // var data = "language=" + language;

//     $.ajax({
//         url: 'Header/change_language',
//         data: data,
//         type: 'post',
//         dataType: 'text',
//         success: function(result){
//             window.location.reload();
//         }
//     });
// });

</script>