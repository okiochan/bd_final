$( document ).ready(function() {
    $('.comment_submit').on('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        var onSuccess = function(data, textStatus, jqXHR) {
            console.dir(data);
            window.location.reload();
        };

        var onError = function(data, textStatus, jqXHR) {
            console.dir(data);
        };

        var data = $(".comment_form").serialize();
        var url = "worker/add_comment.php";
        var settings = {
            data: data,
            method: "POST",
            url: url,
            success: onSuccess,
            error: onError,
        };
        $.ajax(settings);
    });

});