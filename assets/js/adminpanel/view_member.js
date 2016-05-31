
var target ="";
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  target = $(e.target).attr("href") // activated tab

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
         paging = log_in_out_paging;
         getNewData();
         setHeaderIcon();
         break;

        case '#operator':
          paging = operator_utilization_paging;
          getNewData();
          setHeaderIcon();
          break;

        case '#qa_evaluation':
        //  paging = qa_evaluation_paging;
        //  getNewData();
        //  setHeaderIcon();
         break;

        case '#remarks':
         paging = remarks_paging;
         getNewData();
         setHeaderIcon();
         break;

        default:
        // do nothing
    }
});

var drawTable = function (data) {

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
            log_in_out_drawTable(data);
            break;

        case '#operator':
            operator_utilization_drawTable(data);
            break;

        case '#qa_evaluation':
            qa_evaluation_drawTable(data);
            break;

        case '#remarks':
            remarks_drawTable(data);
            break;

        default:
        //do nothing
  }

}

var drawPager = function (data) {
    $('.total-rows').html(data.total_rows);

    var pagerHTML = '';
    var totalPage = Math.ceil( data.total_rows / data.per_page );
    var curPage = data.offset / data.per_page + 1;
    var maxDisplayPg = 3;

    if (totalPage > 1) {

        pagerHTML += '<div><ul class="pagination">';
        if ( curPage > 1 + maxDisplayPg) {
            pagerHTML += '<li><a href="javascript:void(0)" onclick="chgPage(0)">‹ First</a></li>';
        }
        if ( curPage > 1 ) {
            pagerHTML += '<li><a href="javascript:void(0)" onclick="chgPage(' + (curPage-2) * data.per_page  + ')"><</a></li>';
        }

        for (var i = curPage - maxDisplayPg; i <= curPage + maxDisplayPg; i++) {
            var pgOffset = (i-1) * data.per_page;
            if (i > 0 && i <= totalPage) {
                if (i == curPage) {
                    pagerHTML += '<li class="active"><a href="javascript:void(0)" ><strong>' + i + '</strong></a></li>';
                } else {
                    pagerHTML += '<li><a href="javascript:void(0)" onclick="chgPage(' + pgOffset + ')">' + i + '</a></li>';
                }
            }
        }

        if ( curPage < totalPage) {
            pagerHTML += '<li><a href="javascript:void(0)" onclick="chgPage(' + curPage * data.per_page + ')">></a></li>';
        }
        if ( curPage < totalPage - maxDisplayPg +1) {
            pagerHTML += '<li><a href="javascript:void(0)" onclick="chgPage(' + (totalPage-1) * data.per_page + ')">Last ›</a></li>';
        }

        pagerHTML += '</ul></div>';
    }

    $('.page_no').html(pagerHTML);
}
