var qas_app = {};
$(function () {
    qas_app.baseurl = $('#qas_app_info').attr('baseurl');

    qas_app.getNewData = function(callback) {
        $.ajax({
            url: qas_app.paging.ajaxUrl,
            data: {data:JSON.stringify( qas_app.paging  ) },
            type: "post",
            success: function(data) {
                var jsonData = JSON.parse(data);
                qas_app.paging.permission = jsonData.permission;
                qas_app.drawTable(jsonData.table_data);
                qas_app.drawPager(jsonData);
                $('a[data-original-title]').tooltip();
                if (callback) {
                    callback(); // any change to callback refer to thomas
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    };
    
    qas_app.drawPager = function (data) {
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

});