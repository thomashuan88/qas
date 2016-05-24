
$(function(){
    $.datepicker.setDefaults({
        beforeShow: function ( input, inst ) {
            setTimeout(function(){
                inst.dpDiv.css({
                    zIndex: 10000
                });
            })
        }
    });
    $('#dob').datepicker({
        format: 'yyyy-mm-dd',
    });
});
