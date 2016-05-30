
var target ="";
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  target = $(e.target).attr("href") // activated tab
  <li class="active"><a href="#user_info" data-toggle="tab"><?php print $this->lang->line('user_information')?></a></li>
  <li><a href="#daily_qa" data-toggle="tab"><?php print $this->lang->line('daily_qa')?></a></li>
  <li ><a href="#monthly_qa" data-toggle="tab"><?php print $this->lang->line('monthly_qa')?></a></li>
  <li ><a href="#ops_monthly" data-toggle="tab"><?php print $this->lang->line('ops_monthly')?></a></li>
  <li ><a href="#login_logout" data-toggle="tab"><?php print $this->lang->line('login')?>/<?php print $this->lang->line('logout')?></a></li>
  <li ><a href="#operator" data-toggle="tab"><?php print $this->lang->line('operator_utilization')?></a></li>
  <li ><a href="#qa_evaluation" data-toggle="tab"><?php print $this->lang->line('qa_evaluation')?></a></li>
  <li ><a href="#remarks" data-toggle="tab"><?php print $this->lang->line('remarks')?></a></li>

  switch(target) {
  case '#daily_qa':
      paging = daily_qa_paging;
      getNewData();
      setHeaderIcon();
      break;

  case '#monthly_qa':
     paging = monthly_qa_paging;
     getNewData();
     setHeaderIcon();
      break;
  case '#ops_monthly':
      paging = ops_monthly_paging;
      getNewData();
      setHeaderIcon();
      break;

  case '#login_logout':
     paging = login_logout_paging;
     getNewData();
     setHeaderIcon();
      break;
  case '#operator':
      paging = operator_paging;
      getNewData();
      setHeaderIcon();
      break;

  case '#qa_evaluation':
     paging = qa_evaluation_paging;
     getNewData();
     setHeaderIcon();
      break;
  case '#remarks':
     paging = remarks_paging;
     getNewData();
     setHeaderIcon();
      break;
  default:
}
});


var drawTable = function (data) {
    alert(target);

    switch(target) {
        case '#daily_qa':
            daily_qa_drawTable(data);
            break;

        case '#monthly_qa':
            monthly_qa_drawTable(data);
            break;

        case '#ops_monthly':
            ops_monthly_drawTable(data);
            break;

        case '#login_logout':
            login_logout_drawTable(data);
            break;

        case '#operator':
            operator_drawTable(data);
            break;

        case '#qa_evaluation':
            qa_evaluation_drawTable(data);
            break;

        case '#remarks':
            remarks_drawTable(data);
            break;
            
        default:
  }

}
