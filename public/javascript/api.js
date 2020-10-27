$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        var count = getNumberOfImg();
        $.ajax({
            type: 'POST',
            url: 'index.php?url=api/image/getImages',
            dataType: 'json',
            data: {start: count, end: count+2},
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

$(window).on('load',function() {

    console.log('log3');
    $.ajax({
        type: 'POST',
        url: 'index.php?url=api/image/getImages',
        dataType: 'json',
        data: {start: 0, end: 2},
        success: function(data) {
            generateImages(data);
        },
        error: function(e) {
            console.log(e);
        }
    });
});