<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('themes/'. Settings_model::$db_config['adminpanel_theme'] .'/partials/content_head.php'); ?>

<?php $this->load->view('generic/flash_error'); ?>
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
    .easytree-container {
        border: 0 !important;
    }
</style>
<div class="col-md">
    <div class="panel panel-default">
        <div class="panel-heading"><?php print $this->lang->line('new_roster'); ?></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="date_search"><?php print $this->lang->line('month'); ?></label>
                        <input type="text" name="date_search" id="date_search" class="form-control monthpicker">
                    </div>
                </div>

            </div>
            <br>
            <div class="row">
                <?php print form_open('adminpanel/roster_management/set_roster', array('id' => 'roster_form', 'class' => 'form-confirm')) ."\r\n"; ?>
                <div class="col-md-4">
                    <b>ASIGNEE</b>
                    <div style="height: 300px; overflow-y: scroll;" id="asignee_tree"></div>
                    <br>
                    <div class="form-group">
                        <p>
                            <button type="submit" name="submit_sc" id="submit_sc" class="btn btn-success btn-md js-btn-loading" data-loading-text="Adding..."><i class="fa fa-plus pd-r-5"></i> <?php print $this->lang->line('submit'); ?></button>
                            &nbsp;&nbsp;
                            <button type="button" id="return_sc" class="btn btn-danger btn-md"><i class="fa fa-reply pd-r-5"></i> <?php print $this->lang->line('cancel'); ?></button>
                        </p>
                    </div>
                </div>
                <div class="col-sm-1"><!-- #1d98da #2da4e3-->
                    <div style="height: 300px;padding-top:140px;text-align:center;color:gray;">
                        <i class="fa fa-exchange fa-3x" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <b>SHIFT</b>&nbsp;&nbsp;<span id="month_of_shift"></span>
                    <div style="height: 300px; overflow-y: scroll;" id="shift_tree"></div>
                </div>
                <div class="col-md-3">
                    <b>Instructions</b>
                    <div style="height: 300px; overflow-y: scroll;">
                        <?php   
                            echo "<pre>";
                            print_r($active_member);
                            echo "</pre>";
                            ?>
                    </div>
                </div>
                <?php print form_close() ."\r\n"; ?>
            </div>
        </div>
    </div>
</div>
<link href="<?php print base_url(); ?>assets/js/vendor/jstree/skin-lion/ui.easytree.css" rel="stylesheet">
<link href="<?php print base_url(); ?>assets/js/vendor/monthpicker/MonthPicker.css" rel="stylesheet">
<script src="<?php print base_url(); ?>assets/js/vendor/jstree/jquery.easytree.js"></script>
<script src="<?php print base_url(); ?>assets/js/vendor/monthpicker/MonthPicker.js"></script>
<script type="text/javascript">
    $(function() {
        //setup new schedule
        $('#return_sc').click(function(){
            window.location.href = '<?php print base_url();?>adminpanel/roster_management';
        });

        $('.monthpicker').MonthPicker({
            Button: false,
            MinMonth: 0,
            OnAfterChooseMonth: function(selectedDate) {
                var date = $('#date_search').val();
                $('#month_of_shift').html("( "+ date +" )");
            }
        });

        var jsonData = [{
                "uiIcon": "ui-icon-person",
                "text": "Home"
            }, {
                "children": [{
                    "uiIcon": "ui-icon-person",
                    "text": "Go to Google.com"
                }, {
                    "uiIcon": "ui-icon-person",
                    "text": "Go to Yahoo.com"
                }],
                "isActive": false,
                "isExpanded": true,
                "isFolder": true,
                "uiIcon": "ui-icon-person",
                "text": "Folder 1",
                "tooltip": "Bookmarks"
            }, {
                "isActive": false,
                "isExpanded": true,
                "isFolder": true,
                "uiIcon": "ui-icon-person",
                "text": "Node 1111",
                "children": [{
                    "uiIcon": "ui-icon-person",
                    "text": "Sub Node 1"
                }, {
                    "uiIcon": "ui-icon-person",
                    "text": "Sub Node 2"
                }, {
                    "uiIcon": "ui-icon-person",
                    "text": "Sub Node 3"
                }]
                
            }, {
                "uiIcon": "ui-icon-person",
                "text": "Node 2"
            }];

        var jsonData2 = [{
                "isActive": false,
                "isExpanded": false,
                "isFolder": true,
                "text": "Morning",
                "uiIcon": "ui-icon-radio-on",
                "tooltip": "Morning Shift"
            }, {
                "isActive": false,
                "isExpanded": false,
                "isFolder": true,
                "text": "Noon",
                "uiIcon": "ui-icon-clock", 
                "tooltip": "Noon Shift"
            }, {
                "isActive": false,
                "isExpanded": false,
                "isFolder": true,
                "text": "Night",
                "uiIcon": "ui-icon-star", 
                "tooltip": "Night Shift"
            }];
        
        ///////tree to tree
        function dropped1(event, nodes, isSourceNode, source, isTargetNode, target) {
            console.log(nodes);
            console.log(isTargetNode);
            console.log(source);
            console.log(target);
            if (isSourceNode && !isTargetNode) { // left to right drop
                easyTree2.addNode(source, target.id);
                easyTree1.removeNode(source.id);
                easyTree2.rebuildTree(); // rebuild 'other' tree
            }
        }
        
        function dropped2(event, nodes, isSourceNode, source, isTargetNode, target) {
            if (isSourceNode && !isTargetNode) { // Right to left drop
                easyTree2.removeNode(source.id);
                easyTree1.addNode(source, target.id);
                easyTree2.rebuildTree(); // rebuild 'other' tree
            }
        }


        ///////external drop
        function canDrop(event, nodes, isSourceNode, source, isTargetNode, target) {
            if (!isTargetNode && target.id == 'divAcceptHref' && isSourceNode){
                return source.href ? true : false;
            }
            if (isTargetNode && target.text == 'DroppableNode') {
                return true;
            }
        }

        function dropping(event, nodes, isSourceNode, source, isTargetNode, target, canDrop) {
            if (isSourceNode && !canDrop && target && (!isTargetNode && (target.id == 'divRejectAll' || target.id == 'divAcceptHref'))) {
                alertMessage("Dropping node rejected '" + source.text + "'");
            }
        }

        function dropped(event, nodes, isSourceNode, source, isTargetNode, target) {
            // internal to external drop
            if (isSourceNode && target && (!isTargetNode && (target.id == 'divAcceptAll' || target.id == 'divAcceptHref'))) {
                alertMessage("Dropped node accepted '" + source.text + "'");
            }
            if (isSourceNode && isTargetNode) { // internal to internal drop
                //alertMessage("Internal drop accepted, '" + source.text + "'  --> '" + target.text + "'");
                return false;
            }
            if (isTargetNode && !isSourceNode) { // external to internal drop
                // var node = {};
                // node.text = source.innerText;
                // easyTree.addNode(node, target.id);
                // alertMessage("Dropped '" + node.text + "' to '" + target.text + "'");
                return false;
            }
        }

        var easyTree1 = $('#asignee_tree').easytree({
            data: jsonData,
            enableDnd: true,
            dropped: dropped1
        });

        var easyTree2 = $('#shift_tree').easytree({
            data: jsonData2,
            enableDnd: true,
            canDrop: canDrop,
            dropped: dropped,
            dropping: dropping
        });


    });
</script>