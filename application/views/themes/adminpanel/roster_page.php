<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
<style type="text/css">
    .mygrid-wrapper-div {
        height: 630px;
        width: 98%;
        overflow: scroll;
    }
</style>

<div class="row">
    <div class="col-sm-2">
        <div class="form-group contain-datepicker">
            <label for="date_search"><?php print $this->lang->line('month'); ?></label>
            <input type="text" name="date_search" id="date_search" class="form-control monthpicker" value="<?php print date('m/Y');?>">
        </div>
    </div>

</div>
<br>
<div class="row">
    <div class="mygrid-wrapper-div">
        <table class="table table-bordered table-hover">
            <thead class="table-loop-title">
                <tr class="row_week"></tr>
                <tr class="row_dow"></tr>
                <tr class="row_date"></tr>
                <tr>
                    <th><?php print $this->lang->line('number'); ?></th>
                    <th><?php print $this->lang->line('name'); ?></th>
                    <th><?php print $this->lang->line('designation'); ?></th>
                    <th><?php print $this->lang->line('schedule'); ?></th>
                </tr>
            </thead>
            <tbody class="table-loop-content"></tbody>
       </table>
   </div> <!-- /container -->
</div>

<link href="<?php print base_url(); ?>assets/js/vendor/monthpicker/MonthPicker.css" rel="stylesheet">
<script src="<?php print base_url(); ?>assets/js/vendor/monthpicker/MonthPicker.js"></script>
<script type="text/javascript">
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

    function randomStuff(_type){
        var reData = "";
        switch(_type) {
            case 'code':
                var text = "";
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for( var i=0; i < 7; i++ )
                    reData += possible.charAt(Math.floor(Math.random() * possible.length));
                break;
            case 'role':
                var role = ["S-ECS", "ECS", "CS", "TL", "New-ECS"];
                reData = role[Math.floor(Math.random() * role.length)];
                break;
            case 'shift':
                var shift = ["Morning", "Noon", "Night"];
                reData = shift[Math.floor(Math.random() * shift.length)];
                break;
            default:
                reData = "random";
                break;
        }
        return reData;
    }

    function generateSchedule(_date=''){
        //setup new schedule
        if(_date!=""){
            var date_arr = _date.split('/');
            var thisMonth = parseInt(date_arr[0]); 
            var thisYear = date_arr[1];
            var return_date = getDaysInMonth(thisMonth-1, thisYear);
        }else{
            var dNow = new Date();
            var thisMonth = dNow.getMonth()+1;
            var thisYear = dNow.getFullYear();
            var return_date = getDaysInMonth(dNow.getMonth(), dNow.getFullYear());
            if(thisMonth<10){
                var intMonth = "0"+thisMonth;
            }
            _date = intMonth+"/"+thisYear;
        }
        //get data content
        var postData = {
                "schedule_month" : _date
            };
        $.post( "<?php print base_url();?>adminpanel/roster_management/get_roster", postData, function( data ) {
            //alert(data);
        });
        
        //var thisMonth = dNow.getMonth()+1;
        //var return_date = getDaysInMonth(dNow.getMonth(), dNow.getFullYear());

        //loop whole month for day matching
        $('.row_dow').html('');
        $('.row_date').html('');
        $('.row_week').html('');
        var w = 0;
        var col_span = 0;
        var row_week = "<th colspan='3' rowspan='3'><?php print $this->lang->line('monthly'); ?> <?php print $this->lang->line('schedule'); ?> <span id='this_year'></span></th>";
        row_week += "<th rowspan='2'><?php print $this->lang->line('week'); ?></th>";
        var row_date = "<th class='month_date'><?php print $this->lang->line('date'); ?></th>";
        var row_dow = "";
        for(m=0; m<return_date.length; m++){
            row_dow += "<th>"+weekday[return_date[m]]+"</th>";
            row_date += "<th>";
            row_date += m+1+"/"+ thisMonth;
            row_date += "</th>";
            
            if(return_date[m]==1){
                row_week += "<th colspan='"+col_span+"'>"+weekOf+" ";
                row_week += w+"</th>";
                w = w+1;
                col_span = 0;
            }else{
                var reverse_count = return_date.length - m;
            }
            col_span++;
        }
        $('.row_dow').html(row_dow);
        $('.row_date').html(row_date);
        $('.row_week').html(row_week);

        var row_last_week = "<th colspan='"+reverse_count+1+"'>"+weekOf+" "+w+"</th>";
        $('.row_week').append(row_last_week);
        
        var _day = return_date.length + 4;
        var _people = 50;

        //draw data content
        $('.table-loop-content').html('');
        for(i=1; i<=_people; i++){
            //loop row
            var row = "";
            var bg_color = "";
            row += "<tr>";
            for(j=0; j<_day; j++){
                //loop column
                var r_name = randomStuff('code');
                if(j==0){
                    //numbering
                    row += "<td>"+i+"</td>";
                }else if(j==1){
                    //user name
                    row += "<td><b>"+r_name+"</b></td>";
                }else if(j==2){
                    //user role
                    var r_role = randomStuff('role');
                    row += "<td>"+r_role+"</td>";
                }else if(j==3){
                    //user shift
                    var r_shift = randomStuff('shift');
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

            $("#this_year").html(thisYear);
        }

        $('.clickable').click(function(event){
            var _id = $(this).attr("id");
        });
    }

    $(function() {
        $('.monthpicker').MonthPicker({
            Button: false,
            MinMonth: 0,
            OnAfterChooseMonth: function(selectedDate) {
                var date = $('#date_search').val();
                generateSchedule(date);
            }
        });

        generateSchedule();
    });
</script>
