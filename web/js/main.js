
$("document").ready(function () {
    $("#search_id").on('input', function () {
        var val = $(this).val();
        var obj = ($('#myform').serializeArray());
        $.ajax({
            url: '/user/index',
            data: obj,
            type: 'POST',
            success: function (res) {
                if (!res){
                   console.log('Ошибка!'); 
                }
                $('#list').html($(res).find('#list'));
            },
            error: function () {
                console.log('Error!');
            }
        });
    });
});
