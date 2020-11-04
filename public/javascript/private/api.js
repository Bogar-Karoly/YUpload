
$(window).scroll(function() {
    
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        var count = getNumberOfImg()+6;
        console.log('log1');
        $.ajax({
            type: 'POST',
            url: 'index.php?url=api/image/myImages',
            dataType: 'json',
            data: {start: count, end: count},
            success: function(data) {
                console.log('got the data1');
                generateImages(data);
            },
            error: function() {
                console.log('error1');
            }
        });
    }
});

$(document).ready(function() {

    $.ajax({
        type: 'POST',
        url: 'index.php?url=api/image/myImages',
        dataType: 'json',
        data: {start: 0, end: getWindowSize()},
        success: function(data) {
            console.info(data);
            generateImages(data);

        },
        error: function(e) {
            console.log(e);
        }
    });
});