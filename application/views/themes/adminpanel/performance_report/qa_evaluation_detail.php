<link href="<?php print base_url(); ?>assets/js/vendor/bar-rating/themes/bars-square.css" rel="stylesheet">
<link href="<?php print base_url(); ?>assets/js/vendor/bar-rating/themes/fontawesome-stars.css" rel="stylesheet">
<script src="<?php print base_url(); ?>assets/js/vendor/bar-rating/jquery.barrating.min.js"></script>
<div id="qa_evaluation_detail_block">
    <div class="page-title mg-b-20">
        <h2 class="f900 mg-0 pd-t-20 pd-b-20">QA Evaluation Details</h2>

    </div>
    <div class="col-xs-12" style="margin-bottom: 20px;padding-left: 0px;">
        <!-- required for floating -->
        <ul class="nav nav-tabs">
            <!-- 'tabs-right' for right tabs -->
            <li class="role"><a href="#session_log" id="session_log_tab" data-toggle="tab">Session Log</a></li>
            <li class="role"><a href="#evaluation" id="evaluation_tab" data-toggle="tab">Evaluation</a></li>

        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane" id="session_log">
            <form id="qa_session_log" method="post" accept-charset="utf-8">

            </form>
        </div>
        <div class="tab-pane" id="evaluation">
            <form  id="qa_evaluation_form" accept-charset="utf-8">
                <table class="table table-bordered table-hover list table-condensed table-striped" >
                    <tbody>
                        <tr>
                            <td style="text-align:right;background-color:#eee">Name : </td>
                            <td>asasfd</td>
                            <td style="text-align:right;background-color:#eee">Evaluated By : </td>
                            <td>Jackson</td>
                            <th style="text-align:center;background-color:#eee" width="340">QA Score</th>
                        </tr>
                        <tr>
                            <td style="text-align:right;background-color:#eee">Coverage : </td>
                            <td>LivePerson</td>
                            <td style="text-align:right;background-color:#eee">Date : </td>
                            <td>04/03/2016</td>
                            <td style="text-align:center" rowspan="2"><span id="qa_score"></span>%</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;background-color:#eee">Player : </td>
                            <td>you999</td>
                            <td style="text-align:right;background-color:#eee">Brand : </td>
                            <td>Casino</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover list table-condensed table-striped" >
                    <tbody>
                        <tr>
                            <td style="text-align:center">Comments</td>

                            <td width="170" style="text-align:center">Weight</td>
                            <td width="170" style="text-align:center">Rating</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover table-striped" style="margin-top:-21px">
                    <tbody>
                        <tr class="question_type">
                            <td colspan="3" style="background-color:#ddd">
                                <div style="float:left">
                                    Basic Quality Requirement (60 points)<br />基本要求 (60分)
                                </div>
                                <div style="float:right">
                                    <button  class="btn btn-default qaform_add_question" qtype="basic">
                                    <i class="fa fa-plus-circle"></i> &nbsp; Add Qestion</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="set_question" style="display:none">
                            <td colspan="3">
                                <div class="form-group mg-b-0">
                                    <label for="question" class="col-sm-1 control-label" style="text-align:right">Question : </label>
                                    <div class="col-sm-4">
                                        <textarea required="required" data-parsley-trigger="focusout" class="form-control" name="question" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group mg-b-0">
                                    <label for="question" class="col-sm-1 control-label" style="text-align:right">Weight : </label>
                                    <div class="col-sm-3">
                                        <input class="form-control" required="required" data-parsley-trigger="focusout" data-parsley-type="number" data-parsley-maxlength="2" type="text" name="weight" />
                                    </div>
                                </div>
                                <div class="form-group mg-b-0">
                                    <button class="btn btn-success" name="done_add_question" style="margin-left:80px"><i class="fa fa-check pd-r-5"></i> Done</button>
                                    <button class="btn btn-warning" name="cancel_add_question" style="margin-left:5px"><i class="fa fa-times pd-r-5"></i> Cancel</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="question_row" style="display:none">
                            <td></td>
                            <td width="170" style="text-align:center"></td>
                            <td width="170" style="text-align:center"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover table-striped" style="margin-top:-19px">
                    <tbody>
                        <tr class="question_type">
                            <td colspan="3" style="background-color:#ddd">
                                <div style="float:left">
                                    Soft Skills (20 points)<br />聊天技巧  (20分)
                                </div>
                                <div style="float:right">
                                    <button  class="btn btn-default qaform_add_question" qtype="soft_skills">
                                    <i class="fa fa-plus-circle"></i> &nbsp; Add Qestion</button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered table-hover table-striped" style="margin-top:-19px">
                    <tbody>
                        <tr class="question_type">
                            <td colspan="3" style="background-color:#ddd">
                                <div style="float:left">
                                    Follow the product procedure (20 points)<br />遵循其他流程（20分） 
                                </div>
                                <div style="float:right">
                                    <button  class="btn btn-default qaform_add_question" qtype="product_procedure">
                                    <i class="fa fa-plus-circle"></i> &nbsp; Add Qestion</button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="form-group mg-b-0">
                    <button type="submit" name="save_evaluation" class="btn btn-success"><i class="fa fa-check pd-r-5"></i> Save Evaluation</button>
                    <input type="hidden" name="role_id" value="26">
                </div>
            </form>
        </div>

    </div>    
</div>
<script>
qas_app.qa_form_question = [];
qas_app.qa_question_init = function(data, obj) {

    var qa_score = 0;
    
    for (var x in data) {
        var type = data[x].question_type;
        var this_tbody = $('.qaform_add_question[qtype='+type+']', obj).closest('tbody');

        qa_score += parseFloat(data[x].weight) * (parseFloat(data[x].rating) / 5);
        if (typeof qas_app.question_row == 'undefined') {
            qas_app.question_row = this_tbody.find('.question_row').remove().show();
            qas_app.question_row.find('td:eq(0)').html('<button class="btn remove-question" style="background-color:transparent;float:left"><i class="fa fa-minus-circle"></i> </button>');
            qas_app.question_row.find('td:eq(2)').html('<select name="mark"><option value=""></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>');

            qas_app.question_row.find('button.remove-question').click(function(){
                var this_tr = $(this).closest('tr');
                var rowid = this_tr.attr('rowid');
                bootbox.confirm('Are you sure to delete this question?<br/>'+this_tr.find('span.question-txt').html(), function(confirmed){
                    if (confirmed) {
                        var qa_score = 0;
                        for (var x in qas_app.qa_form_question) {
                            if (qas_app.qa_form_question[x].rowid == parseInt(rowid)) {
                                qas_app.qa_form_question.splice(x, 1);
                            } else {
                                qa_score += parseFloat(qas_app.qa_form_question[x].weight) * (parseFloat(qas_app.qa_form_question[x].mark) / 5);

                            }
                        }
                        $('#qa_score', obj).html(qa_score.toFixed(2));
                        this_tr.remove();             
                    }
                });


            });
        }

        if ( this_tbody.find('.question_row').length) {
             this_tbody.find('.question_row').remove();
        }

        var qrow = qas_app.question_row.clone(true);

        var nowtime = data[x].id;
        qrow.removeAttr('class');
        qrow.attr("rowid", nowtime);
        qrow.find('td:eq(0)').append('<span class="question-txt" style="display:block;float:left">'+data[x].question_text+'</span>');
        qrow.find('td:eq(1)').html(data[x].weight+'%');
        qrow.find('select[name=mark]').barrating({
            theme: 'fontawesome-stars',
            onSelect: function(value,text,event) {
                var rowid = $(event.currentTarget).closest('tr').attr('rowid');
                var qa_score = 0;

                if (value == "") {
                    value = 0;
                }
                for (var x in qas_app.qa_form_question) {
                    if (parseInt(qas_app.qa_form_question[x].rowid) == parseInt(rowid)) {
                        qas_app.qa_form_question[x].mark = parseInt(value);
                    }
                    qa_score += parseFloat(qas_app.qa_form_question[x].weight) * (parseFloat(qas_app.qa_form_question[x].mark) / 5);
                }
                $('#qa_score', obj).html(qa_score.toFixed(2));
            }
        });
        qrow.appendTo(this_tbody);

        qas_app.qa_form_question.push({
            rowid: nowtime,
            mark:parseInt(data[x].rating),
            weight: parseInt(data[x].weight),
            type: data[x].question_type,
            row_obj: qrow
        });

        $('#qa_score', obj).html(qa_score.toFixed(2));
    }
};

$(function(){

    var thisblock = $('#qa_evaluation_detail_block');

    var initial_question = <?php echo !empty($this->ev_chat_data)?json_encode($this->ev_chat_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT):'[]'; ?>;
    
    qas_app.qa_question_init(initial_question, thisblock);

    thisblock.find('#session_log_tab').click();
    thisblock.find('form').submit(function(){
        return false;
    })
    
    var session_log = thisblock.find('#session_log');
    var evaluation = thisblock.find('#evaluation');

    qas_app.qa_clear_form = function(obj) {
        thisblock.find('button.qaform_add_question').prop('disabled', false);
        thisblock.find('button[name=save_evaluation]').prop('disabled',false);
        $(obj).closest('tr').remove();
    };
    

    var add_question_form = $('.set_question').remove();

    add_question_form.find('button[name=cancel_add_question]').click(function(){
        qas_app.qa_clear_form(this);
    });


    add_question_form.find('button[name=done_add_question]').click(function(){
        var this_tbody = $(this).closest('tbody');
        var this_tr = $(this).closest('tr');
        var question = $('textarea[name=question]', this_tr).val();
        var weight = $('input[name=weight]', this_tr).val();
        
        if (question == "" || weight == "" || !weight.match(/[0-9]+/)) {
            return false;
        }

        var total_basic = 0;
        var total_soft_skills = 0;
        var total_product_procedure = 0;
        for(var x in qas_app.qa_form_question) {
            if (qas_app.qa_form_question[x].type == 'basic') {
                total_basic += qas_app.qa_form_question[x].weight;
            }
            if (qas_app.qa_form_question[x].type == 'soft_skills') {
                total_soft_skills += qas_app.qa_form_question[x].weight;
            }
            if (qas_app.qa_form_question[x].type == 'product_procedure') {
                total_product_procedure += qas_app.qa_form_question[x].weight;
            }
            
        }
        if (this_tr.attr('qtype') == 'basic') {
            total_basic += parseInt(weight);
        }
        if (this_tr.attr('qtype') == 'soft_skills') {
            total_soft_skills += parseInt(weight);
        }
        if (this_tr.attr('qtype') == 'product_procedure') {
            total_product_procedure += parseInt(weight);
        }
        
        if (total_basic > 60) {
            return false;
        }
        if (total_soft_skills > 20) {
            return false;
        }
        if (total_product_procedure > 20) {
            return false;
        }

        qas_app.qa_clear_form(this);

        if (typeof qas_app.question_row == 'undefined') {
            qas_app.question_row = this_tbody.find('.question_row').remove().show();
            qas_app.question_row.find('td:eq(0)').html('<button  class="btn remove-question" style="background-color:transparent"><i class="fa fa-minus-circle"></i> </button>');
            qas_app.question_row.find('td:eq(2)').html('<select name="mark"><option value=""></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>');

            qas_app.question_row.find('button.remove-question').click(function(){
                var this_tr = $(this).closest('tr');
                var rowid = this_tr.attr('rowid');
                bootbox.confirm('Are you sure to delete this question?<br/>'+this_tr.find('span.question-txt').html(), function(confirmed){
                    if (confirmed) {
                        var qa_score = 0;
                        for (var x in qas_app.qa_form_question) {
                            if (qas_app.qa_form_question[x].rowid == parseInt(rowid)) {
                                qas_app.qa_form_question.splice(x, 1);
                            } else {
                                qa_score += parseFloat(qas_app.qa_form_question[x].weight) * (parseFloat(qas_app.qa_form_question[x].mark) / 5);

                            }
                        }
                        $('#qa_score', thisblock).html(qa_score.toFixed(2));
                        this_tr.remove();             
                    }
                });


            });
        }

        if ( this_tbody.find('.question_row').length) {
             this_tbody.find('.question_row').remove();
        }

        var qrow = qas_app.question_row.clone(true, true);

        var nowtime = $.now();
        qrow.removeAttr('class');
        qrow.attr("rowid", nowtime);
        qrow.find('td:eq(0)').append('<span class="question-txt">'+question+'</span>');
        qrow.find('td:eq(1)').html(parseFloat(weight).toFixed(2)+'%');
        qrow.find('select[name=mark]').barrating({
            theme: 'fontawesome-stars',
            onSelect: function(value,text,event) {
                var rowid = $(event.currentTarget).closest('tr').attr('rowid');
                var qa_score = 0

                if (value == "") {
                    value = 0;
                }

                for (var x in qas_app.qa_form_question) {
                    if (qas_app.qa_form_question[x].rowid == rowid) {
                        qas_app.qa_form_question[x].mark = parseInt(value);
                    }
                    qa_score += parseFloat(qas_app.qa_form_question[x].weight) * (parseFloat(qas_app.qa_form_question[x].mark) / 5);
                }
                $('#qa_score', thisblock).html(qa_score.toFixed(2));
            }
        });
        qrow.appendTo(this_tbody);

        qas_app.qa_form_question.push({
            rowid: nowtime,
            mark:0,
            weight: parseInt(weight),
            type: this_tr.attr('qtype'),
            row_obj: qrow
        });
    });

    $('.qaform_add_question', thisblock).click(function(){
        var this_tr = $(this).closest('tr');

        $('.qaform_add_question', thisblock).prop('disabled', true);
        thisblock.find('button[name=save_evaluation]').prop('disabled',true);

        var this_add_question_form = add_question_form.clone(true);
        this_tr.after(this_add_question_form.attr("qtype", $(this).attr('qtype')).show());
        thisblock.find('#qa_evaluation_form').parsley();
    });
});
</script>