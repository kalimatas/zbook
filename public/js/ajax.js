/* ajax code here */
$(function(){
    $('a#getAjaxResponse').click(function(){
        $.get('/index/ajax/?name=testAjaxString&format=html', function(data) {
            $('div#ajaxResponse').html($('div#ajaxResponse').html()+data);
        });
        return false;
    });
});
