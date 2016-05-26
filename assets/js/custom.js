var qas_app = {};

$(function () {
    //form conformation
    $('.form-confirm').on('submit', function (e) {
        e.preventDefault();
        var form = this;
        bootbox.confirm(confirm_message, function (confirmed) {
            if (confirmed) {
                form.submit();
            }
        });
    });

    //delete conformation
    $(".delete").on("click", function (e) {
        var delete_link = $(this).attr('href');
        e.preventDefault();
        bootbox.confirm(delete_message, function (confirmed) {
            if (confirmed) {
                window.location.href = delete_link;
            }
        });
    });

    //password reset conformation
    $('.form-reset').on('submit', function (e) {
        e.preventDefault();
        var form = this;
        bootbox.confirm(reset_message, function (confirmed) {
            if (confirmed) {
                form.submit();
            }
        });
    });

    $('.datetimepicker').datetimepicker({
        allowTimes:['00:00','00:30','01:00','01:30','02:00','02:30','03:00','03:30','04:00','04:30','05:00','05:30','06:00','06:30','07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30']
    });


    $('.datepicker').datetimepicker({
        timepicker : false,
        format: 'Y-m-d',
    });

    $('.timepicker').datetimepicker({
        datepicker :false,
        format: 'H:i',
        allowTimes:['00:00','00:30','01:00','01:30','02:00','02:30','03:00','03:30','04:00','04:30','05:00','05:30','06:00','06:30','07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30']
    });

});

// pagination
var getNewData = function(callback) {
    // console.log(JSON.stringify(paging));
    $.ajax({
        url: paging.ajaxUrl,
        data:JSON.stringify(paging),
        type: "post",
        success: function(data) {
            var jsonData = JSON.parse(data);
            paging.permission = jsonData.permission;
            drawTable(jsonData.table_data);
            drawPager(jsonData);
            $('a[data-original-title]').tooltip();
            if (callback) {
                callback();
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

var drawPager = function (data) {
    $('#total-rows').html(data.total_rows);

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

    $('#pager').html(pagerHTML);
}

var chgOrder = function( order_by ) {
    if(paging.order_by = order_by) {
        if(paging.sort_order == 'desc') {
            paging.sort_order = 'asc';
        } else {
            paging.sort_order = 'desc';
        }
    }
    paging.order_by = order_by;

    getNewData();
    setHeaderIcon();
}

var chgPage = function( newOffset) {
    paging.offset = newOffset;
    getNewData();
}

var setHeaderIcon = function() { // set table header
    var allth = $('.table-th');
    $.each( allth, function( key, value ) {
        value.setAttribute("class", "table-th");
    });

    if (paging.sort_order == 'desc') {
        $('[dataname=' + paging.order_by +']').addClass('fa fa-arrow-circle-o-up');
    } else {
        $('[dataname=' + paging.order_by +']').addClass('fa fa-arrow-circle-o-down');
    }
}
