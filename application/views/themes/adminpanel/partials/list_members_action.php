<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="mg-b-10">
    <strong>With selected:</strong><br>
    <div class="btn-group pd-r-5 pull-left" role="group">
        <button type="button" name="delete" id="delete" class="btn btn-primary" data-title="Are you sure you want to delete those members?"><i class="fa fa-trash-o"></i></button>
    </div>
    <div class="btn-group pd-r-5 pull-left" role="group">
        <button type="button" name="activate" id="activate" class="btn btn-primary" data-title="Are you sure you want to activate those members?"><i class="fa fa-check"></i></button>
        <button type="button" name="deactivate" id="deactivate" class="btn btn-primary" data-title="Are you sure you want to deactivate those members?"><i class="fa fa-times"></i></button>
    </div>
    <div class="btn-group" role="group">
        <button type="button" name="ban" id="ban" class="btn btn-primary" data-title="Are you sure you want to ban those members?"><i class="fa fa-lock"></i></button>
        <button type="button" name="unban" id="unban" class="btn btn-primary" data-title="Are you sure you want to unban those members?"><i class="fa fa-unlock"></i></button>
    </div>
</div>