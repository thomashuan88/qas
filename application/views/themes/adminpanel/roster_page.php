<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
<style type="text/css">
    .mygrid-wrapper-div {
        height: 630px;
        width: 98%;
        overflow: scroll;
    }

    .fixedTable .table {
      background-color: white;
      width: auto;
    }
    .fixedTable .table tr td,
    .fixedTable .table tr th {
      min-width: 100px;
      width: 100px;
      min-height: 20px;
      height: 20px;
      padding: 5px;
    }
    .fixedTable-header {
      width: 99%;
      height: 126px;
      /*margin-left: 110px;*/
      overflow: hidden;
      border-bottom: 1px solid #CCC;
    }
    .fixedTable-sidebar {
      width: 400px;
      height: 400px;
      float: left;
      overflow: hidden;
      border-right: 1px solid #CCC;
    }
    .fixedTable-body {
      overflow: auto;
      width: 60%; /*folo this*/
      height: 400px;
      float: left;
    }
</style>

<?php if(empty($data)){ ?>
    <br>
    <div class="row" style="width:100%;">
        <div id="demo" class="fixedTable">
          <header class="fixedTable-header">
            <table class="table table-bordered">
              <thead>
                <tr class="row_week">
                    <th colspan="3" rowspan="3"><?php print $this->lang->line('monthly'); ?> <?php print $this->lang->line('schedule'); ?> <span id="this_year"></span></th>
                    <th rowspan="2"><?php print $this->lang->line('week'); ?></th>
                </tr>
                <tr class="row_dow"></tr>
                <tr class="row_date">
                    <th class="month_date"><?php print $this->lang->line('date'); ?></th>
                </tr>
                <tr>
                    <th><?php print $this->lang->line('number'); ?></th>
                    <th><?php print $this->lang->line('name'); ?></th>
                    <th><?php print $this->lang->line('designation'); ?></th>
                    <th><?php print $this->lang->line('schedule'); ?></th>
                </tr>
              </thead>
            </table>
          </header>
          <aside class="fixedTable-sidebar">
            <table class="table table-bordered">
              <tbody class="table-side-content">
              </tbody>
            </table>
          </aside>
          <div class="fixedTable-body">
            <table class="table table-bordered" id="scrollable">
              <tbody class="table-loop-content">
              </tbody>
            </table>
          </div>
        </div>
    </div>
<?php }else{?>

<!--<div class="row" style="margin-top:20px;">
    <div class="col-xs-7">
        <h4 class="text-uppercase">
            To Be Continue . . .
        </h4>
    </div>
</div>-->
<br>
<div class="row">
    <div class="mygrid-wrapper-div">
        <table class="table table-bordered table-hover">
            <thead class="table-loop-title">
                <tr class="row_week">
                    <th colspan="3" rowspan="3"><?php print $this->lang->line('monthly'); ?> <?php print $this->lang->line('schedule'); ?> <span id="this_year"></span></th>
                    <th rowspan="2"><?php print $this->lang->line('week'); ?></th>
                </tr>
                <tr class="row_dow"></tr>
                <tr class="row_date">
                    <th class="month_date"><?php print $this->lang->line('date'); ?></th>
                </tr>
                <tr>
                    <th><?php print $this->lang->line('number'); ?></th>
                    <th><?php print $this->lang->line('name'); ?></th>
                    <th><?php print $this->lang->line('designation'); ?></th>
                    <th><?php print $this->lang->line('schedule'); ?></th>
                </tr>
            </thead>
            <tbody class="table-loop-content">
            </tbody>
       </table>
   </div> <!-- /container -->
</div>
<?php }?>
<script type="text/javascript">
    (function () {
        var demo, fixedTable;
        fixedTable = function (el) {
            var $body, $header, $sidebar;
            $body = $(el).find('.fixedTable-body');
            $sidebar = $(el).find('.fixedTable-sidebar table');
            $header = $(el).find('.fixedTable-header table');
            return $($body).scroll(function () {
                $($sidebar).css('margin-top', -$($body).scrollTop());
                return $($header).css('margin-left', -$($body).scrollLeft());
            });
        };
        demo = new fixedTable($('#demo'));
    }.call(this));

    //days of week
    var weekday = new Array(7);
    weekday[0] = "<?php print $dow_arr['sunday']; ?>";
    weekday[1] = "<?php print $dow_arr['monday']; ?>";
    weekday[2] = "<?php print $dow_arr['tuesday']; ?>";
    weekday[3] = "<?php print $dow_arr['wednesday']; ?>";
    weekday[4] = "<?php print $dow_arr['thursday']; ?>";
    weekday[5] = "<?php print $dow_arr['friday']; ?>";
    weekday[6] = "<?php print $dow_arr['saturday']; ?>";
    //week
    var weekOf = "<?php print $this->lang->line('week'); ?>";

    function getDaysInMonth(month, year) {
        // Since no month has fewer than 28 days
        var date = new Date(year, month, 1);
        var days = [];
        while (date.getMonth() === month) {
            days.push(date.getDay());
            date.setDate(date.getDate() + 1);
        }
        return days;
    }

    function makeid(){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 7; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    function makerole(){
        var role = ["S-ECS", "ECS", "CS", "TL", "New-ECS"];
        return role[Math.floor(Math.random() * role.length)];
    }

    function makeshift(){
        var shift = ["Morning", "Noon", "Night"];
        return shift[Math.floor(Math.random() * shift.length)];
    }

    function makeDropDown(){

    }

    $(function() {
        //setup new schedule
        $('#scheduler').click(function(){
            // bootbox.confirm("Warning: <br> GOGO?", function(confirmed) {
            //     if (confirmed) {
                    window.location.href = '<?php print base_url();?>adminpanel/roster_management/set_roster_page';
            //     }
            // });
        });

        var dNow = new Date();
        var thisMonth = dNow.getMonth()+1;
        var return_date = getDaysInMonth(dNow.getMonth(), dNow.getFullYear());

        $("#this_year").html(dNow.getFullYear());
        //loop whole month for day matching
        var w = 0;
        var col_span = 0;
        for(m=0; m<return_date.length; m++){
            var row_week = "";
            var row_dow = "";
            var row_date = "";

            row_dow = "<th>"+weekday[return_date[m]]+"</th>";
            row_date += "<th>";
            row_date += m+1+"/"+ thisMonth;
            row_date += "</th>";

            
            if(return_date[m]==1){
                row_week = "<th colspan='"+col_span+"'>"+weekOf+" ";
                row_week += w+"</th>";
                w = w+1;
                col_span = 0;
            }else{
                var reverse_count = return_date.length - m;
            }
            col_span++;
            $('.row_dow').append(row_dow);
            $('.row_date').append(row_date);
            $('.row_week').append(row_week);
        }

        var row_last_week = "<th colspan='"+reverse_count+1+"'>"+weekOf+" "+w+"</th>";
        $('.row_week').append(row_last_week);
        
        var _day = return_date.length + 4;
        var _people = 50;
        
        //data content
        // for(i=1; i<=_people; i++){
        //     //loop row
        //     var row = "";
        //     var row_side = "";
        //     var bg_color = "";
        //     row += "<tr>";
        //     row_side += "<tr>";
        //     for(j=0; j<_day; j++){
        //         //loop column
        //         var r_name = makeid();
        //         if(j==0){
        //             //numbering
        //             row_side += "<td>"+i+"</td>";
        //         }else if(j==1){
        //             //user name
        //             row_side += "<td><b>"+r_name+"</b></td>";
        //         }else if(j==2){
        //             //user role
        //             var r_role = makerole();
        //             row_side += "<td>"+r_role+"</td>";
        //         }else if(j==3){
        //             //user shift
        //             var r_shift = makeshift();
        //             if(r_shift=="Morning"){
        //                 bg_color = "green";
        //             }else if(r_shift=="Noon"){
        //                 bg_color = "orange";
        //             }else{
        //                 bg_color = "red";
        //             }
        //             row_side += "<td style='color:"+bg_color+";'>"+r_shift+"</td>";
        //         }else{
        //             //actual roster
        //             row += "<td id='"+j+"_"+r_name+"' class='clickable' >"+j+"</td>";
        //         }
        //     }
        //     row += "</tr>";
        //     row_side += "</tr>";
        //     $('.table-loop-content').append(row);
        //     $('.table-side-content').append(row_side);
        // }

        for(i=1; i<=_people; i++){
            //loop row
            var row = "";
            var bg_color = "";
            row += "<tr>";
            for(j=0; j<_day; j++){
                //loop column
                var r_name = makeid();
                if(j==0){
                    //numbering
                    row += "<td>"+i+"</td>";
                }else if(j==1){
                    //user name
                    row += "<td><b>"+r_name+"</b></td>";
                }else if(j==2){
                    //user role
                    var r_role = makerole();
                    row += "<td>"+r_role+"</td>";
                }else if(j==3){
                    //user shift
                    var r_shift = makeshift();
                    if(r_shift=="Morning"){
                        bg_color = "green";
                    }else if(r_shift=="Noon"){
                        bg_color = "orange";
                    }else{
                        bg_color = "red";
                    }
                    row += "<td style='color:"+bg_color+";'>"+r_shift+"</td>";
                }else{
                    //actual roster
                    row += "<td>"+r_name+"-"+j+"</td>";
                }
            }
            row += "</tr>";
            $('.table-loop-content').append(row);
        }

        $('.clickable').click(function(event){
            var _id = $(this).attr("id");
        });
    });
</script>
