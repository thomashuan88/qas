<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
<style type="text/css">
    .mygrid-wrapper-div {
        height: 630px;
        width: 98%;
        overflow: scroll;
    }

    .big_header {
        text-align: -webkit-auto;
        vertical-align: middle !important;
    }

    .schedule_header {
        background-color:#2E5396;
        color:white;
    }

    .schedule_header_2 {
        background-color:#64779A;
        color:white;
    }

    .schedule_header_3 {
        background-color:#A2ACB8;
    }

    .morning_shift_back {
        background-color:#7FFFAA;
    }

    .morning_shift_word {
        color:#227F00;
    }

    .noon_shift_back {
        background-color:#E8FF9F;
    }

    .noon_shift_word {
        color:#FF630A;
    }

    .night_shift_back {
        background-color:#FFC3B9;
    }

    .night_shift_word {
        color:#DC2828;
    }

    .admin_shift_back {
        background-color:#7BD5FF;
    }

    .admin_shift_word {
        color:#01587F;
    }

    .offday {
        color: black;
        background-color: #E9EAEA;
    }

    .schedule_table th,td{
        line-height: 10px !important;
    }

    .table-loop-content td{
        white-space: nowrap;
    }

    .tdMinWidth {
        min-width: 100px;
    }

    .blankTD {
        background-color:#E4EFFE;
    }

    .clickable {
        cursor: pointer;
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
        <table class="table table-bordered table-hover schedule_table">
            <thead class="table-loop-title">
                <tr class="row_week schedule_header"></tr>
                <tr class="row_dow schedule_header_2"></tr>
                <tr class="row_date schedule_header_3"></tr>
            </thead>
            <tbody class="table-loop-content"></tbody>
       </table>
   </div> <!-- /container -->
</div>

<div>
    <a href="#" id="status" data-type="select" data-url="" data-title="Select status"></a>
</div>

<link href="<?php print base_url(); ?>assets/js/vendor/monthpicker/MonthPicker.css" rel="stylesheet">
<link href="<?php print base_url(); ?>assets/js/vendor/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="<?php print base_url(); ?>assets/js/vendor/monthpicker/MonthPicker.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script type="text/javascript">
    /*** Languages ***/
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
    //table description
    var leader = "<?php print $this->lang->line('group_leader'); ?>";
    var senior = "<?php print $this->lang->line('senior'); ?>";
    var cs_short = "<?php print $this->lang->line('customer_service_short'); ?>";
    var head_count = "<?php print $this->lang->line('head_count'); ?>";
    var in_charge = "<?php print $this->lang->line('in_charge'); ?>";
    var hod = "<?php print $this->lang->line('hod'); ?>";
    var admin = "<?php print $this->lang->line('admin'); ?>";
    /*** END ***/

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

    function xeditable_initial(){
        //name
        $('.selectable_name').editable({
            showbuttons: false,
            placement: 'left',
            toggle: 'manual',
            title: 'Select username',
            source: [
                  {value: 1, text: 'Active'},
                  {value: 2, text: 'Blocked'},
                  {value: 3, text: 'Deleted'}
               ]
        });

        //remarks
        $('.selectable_remark').editable({ 
            showbuttons: false,
            title: 'Enter remark',
            placement: 'right',
            toggle: 'manual'
        });

        //shifts
        $('.selectable_shift').editable({
            showbuttons: false,
            title: 'Select shift',
            placement: 'right',
            toggle: 'manual',
            source: [
                  {value: 1, text: '07:00'},
                  {value: 2, text: '14:00'},
                  {value: 3, text: '22:30'}
               ]
        });
    }

    function click_manager(a,b,c,d){
        //alert(a+"-"+b+"-"+c+"-"+d);

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
            // alert(JSON.stringify(data));
            if(data.data.success){
                //alert('listed');
            }else{
                //alert('not listed');
            }

            //alert(JSON.stringify(data.table_structure));
            //alert(data.table_structure.shift_per_day);

            //var thisMonth = dNow.getMonth()+1;
            //var return_date = getDaysInMonth(dNow.getMonth(), dNow.getFullYear());

            //loop whole month for day matching
            $('.row_dow').html('');
            $('.row_date').html('');
            $('.row_week').html('');
            var w = 0;
            var col_span = 0;
            var row_week = "<th colspan='3' rowspan='2' class='big_header'><?php print $this->lang->line('monthly'); ?> <?php print $this->lang->line('schedule'); ?> <span id='this_year'></span></th>";
            row_week += "<th rowspan='2' class='big_header'><?php print $this->lang->line('week'); ?></th>";

            var row_date = "<th class='schedule_header'><?php print $this->lang->line('designation'); ?></th><th class='schedule_header'><?php print $this->lang->line('name'); ?></th><th class='schedule_header'><?php print $this->lang->line('request'); ?></th>";
            row_date += "<th class='month_date'><?php print $this->lang->line('schedule'); ?> / <?php print $this->lang->line('date'); ?></th>";
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

            //** draw data content start **//
            $('.table-loop-content').html('');
            var blank_row = "<tr><td colspan='"+_day+"' class='blankTD'></td></tr>";

            //offdays preset
            var offdays_admin = data.offdays.admin;
            var offdays_leader = data.offdays.leader;
            var offdays_senior = data.offdays.senior;
            var offdays_cs = data.offdays.cs;

            var offday_color = "offday";

            //data table looping
            for(shift=1; shift<=data.table_structure.shift_per_day; shift++ ){
                var row_color = "";
                var back_color = "";
                switch(shift) {
                    case 1:
                        back_color = 'morning_shift_back morning_shift_word';
                        row_color = 'morning_shift_word';
                        shiftTime = data.table_structure.shift.Morning;
                        break;
                    case 2:
                        back_color = 'noon_shift_back noon_shift_word';
                        row_color = 'noon_shift_word';
                        shiftTime = data.table_structure.shift.Afternoon;
                        break;
                    case 3:
                        back_color = 'night_shift_back night_shift_word';
                        row_color = 'night_shift_word';
                        shiftTime = data.table_structure.shift.Night;
                        break;
                }
                //loop shift
                for(i=1; i<=11; i++){
                    //loop row
                    var row = "";
                    var bg_color = "";
                    row += "<tr>";
                    if(i!=10 && i!=11){
                        for(j=0; j<_day; j++){
                            //loop day
                            if(j==0){
                                switch(i) {
                                    case 1:
                                        row += "<td class='"+row_color+"'><b><i>"+leader+shift+"</i></b></td>";
                                        break;
                                    case 2:
                                        row += "<td class='"+row_color+"'><b><i>"+senior+shift+"</i></b></td>";
                                        break;
                                    default:
                                        var cs_num = i-2;
                                        row += "<td class='"+row_color+"'>"+cs_short+cs_num+"</td>";
                                        break;
                                }
                            }else if(j==1){
                                //user name
                                var post_id = "";
                                if(i==1){
                                    post_id = "Leader";
                                }else if(i==2){
                                    post_id = "Senior";
                                }else{
                                    post_id = "CS";
                                }
                                //row += "<td class='tdMinWidth'><div><span class='fa fa-plus clickable'></span> <a href='#' class='selectable' id='name_"+post_id+"_"+shift+"_"+i+"' data-type='select' data-url='' data-title='Select status'>&nbsp;</a></div></td>";
                                row += "<td class='tdMinWidth clickable'><a href='#' class='selectable_name' id='name_"+post_id+"_"+shift+"_"+i+"' data-type='select' data-url='' data-title='Select status'></a></td>";
                            }else if(j==2){
                                //remarks
                                row += "<td class='clickable'><a href='#' class='selectable_remark' id='remark_"+post_id+"_"+shift+"_"+i+"' data-type='text' data-url='' data-title='Remarks'></a></td>";
                            }else if(j==3){
                                //shift slot
                                switch(shift) {
                                    case 1:
                                        row += "<td class='"+row_color+"'><?php print $this->lang->line('morning'); ?></td>";
                                        break;
                                    case 2:
                                        row += "<td class='"+row_color+"'><?php print $this->lang->line('afternoon'); ?></td>";
                                        break;
                                    case 3:
                                        row += "<td class='"+row_color+"'><?php print $this->lang->line('night'); ?></td>";
                                        break;
                                }
                            }else{
                                //actual roster
                                var post_roster = j+1;
                                var day_of_week = j - 4;
                                var cs_slot = i-2;
                                //looping preset offday
                                var _shifts = "";
                                var background = back_color;

                                _shifts = shiftTime;offday_color

                                if(i==1 && offdays_leader[shift][return_date[day_of_week]] == 'off'){
                                    background = offday_color;
                                    _shifts = "<span style='color:black;'>OFF</span>";
                                }else if (i==2 && offdays_senior[shift][return_date[day_of_week]] == 'off'){
                                    background = offday_color;
                                    _shifts = "<span style='color:black;'>OFF</span>";
                                }else if (i!=1 && i!=2 && offdays_cs[cs_slot][return_date[day_of_week]] == 'off'){
                                    background = offday_color;
                                    _shifts = "<span style='color:black;'>OFF</span>";
                                }
                                
                                //_shifts = shiftTime;
                                //row += "<td class='"+background+" clickable' id='shifts_"+shift+"_"+i+"_"+post_roster+"'>"+_shifts+"</td>";
                                row += "<td class='"+background+" clickable'><a href='#' class='selectable_shift' id='shifts_"+shift+"_"+i+"_"+post_roster+"' data-type='select' data-url='' data-title='Select shift'>"+_shifts+"</a></td>";
                            }
                        }

                        row += "</tr>";
                        $('.table-loop-content').append(row);
                    }else{
                        //loop total counts
                        var row_total = "";
                        row_total += "<tr>";
                        for(j=0; j< _day-3 ; j++){
                            if(i==10 && j==0){
                                row_total += "<td colspan='3' rowspan='2' class='big_header "+row_color+"'>"+head_count+"</td><td class='"+row_color+"'>"+leader+"</td>";
                            }else if(i!=10 && j==0){
                                row_total += "<td class='"+row_color+"'>"+cs_short+"</td>";
                            }else{
                                row_total += "<td></td>";
                            }
                        }

                        row_total += "</tr>";
                        //alert(row_total);
                        $('.table-loop-content').append(row_total);
                    }
                    
                    $("#this_year").html(thisYear);
                }
                $('.table-loop-content').append(blank_row);
                
            }
            //admin slot
            var normalShift = data.table_structure.shift.Normal;
            for(a=1; a<=4; a++){
                var _pos = "";
                switch (a){
                    case 1:
                        _pos = in_charge;
                        break;
                    case 4:
                        _pos = "QA";
                        break;
                    default:
                        _pos = hod;
                        break;
                }
                var row_admin = "";
                row_admin += "<tr>";
                for(j=0; j<_day; j++){
                    if(j==0){
                        row_admin += "<td>"+ _pos +"</td>";
                    }else if(j==1){
                        row_admin += "<td class='clickable'><a href='#' class='selectable_name' id='name_Administrator_4_"+a+"' data-type='select' data-url='' data-title='Select admin'></a></td>";
                    }else if(j==2){
                        row_admin += "<td class='clickable'><a href='#' class='selectable_remark' id='remark_Administrator_4_"+a+"' data-type='text' data-url='' data-title='Remarks'></a></td>";
                    }else if(j==3){
                        row_admin += "<td>"+admin+"</td>";
                    }else{
                        //admin shift
                        var _shifts = normalShift;
                        var day_of_week = j - 4;
                        var shift_slot = j + 1;
                        var background = "admin_shift_back admin_shift_word";
                        if(offdays_admin[a][return_date[day_of_week]] == 'off'){
                            background = offday_color;
                            _shifts = "<span style='color:black;'>OFF</span>";
                        }

                        row_admin += "<td class='"+background+" clickable' id='shift_admin_"+a+"_"+shift_slot+"'>"+_shifts+"</td>";
                    }

                }
                row_admin += "</tr>";
                $('.table-loop-content').append(row_admin);
            }
            $('.table-loop-content').append(blank_row);

            $('.clickable').click(function(event){
                //var _id = $(this).next().attr('id');
                var _id = $(this).children().attr('id');
                //alert(_id);
                //var _id = $(this).attr("id");
                var arr = _id.split('_');
                //arr[0] - type (shift, name, remarks)
                //arr[1] - position (leader, senior, cs, admin) or shift (shift1, shift2..)
                //arr[2] - which row, determines shift slots *need to change, inconsistent
                //arr[3] - day slot, determines which date of shift
                //click_manager(_id, arr[0], arr[1], arr[2], arr[3]);

                event.stopPropagation();
                switch(arr[0]){
                    case 'shift':
                    case 'name':
                        $('#'+_id).editable('toggle');
                        break;
                    case 'remark':
                        $('#'+_id).editable('toggle');
                        break;
                }
                
            });


            //initialize x-editable
            xeditable_initial();
        }, "JSON");
    }

    function click_manager(id, a, b, c, d){
        switch(a){
            case 'shift':
            case 'name':
                e.stopPropagation();
                $('#'+id).editable({});
                break;
            case 'remark':
                break;
        }
        // $('#'+id).editable({
        //     source: [
        //           {value: 1, text: 'Active'},
        //           {value: 2, text: 'Blocked'},
        //           {value: 3, text: 'Deleted'}
        //        ]
        // });
        //$('#'+id).editable('toggle');
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
