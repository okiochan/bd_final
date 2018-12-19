$( document ).ready(function() {
    $('.log_button').on('click', (e) => {
        
        e.preventDefault();
        e.stopPropagation();
            
        var onSuccess = function(data, textStatus, jqXHR) {
            if (data.indexOf("success") != -1) {
                alert("User login successful");
                window.location = "movies.php";
            } else if (data.indexOf("userNotFound") != -1){
                alert("User not found");
            }else if (data.indexOf("cookieDisabled") != -1){
                alert("Enable cookie please");
            } else {
                alert("Password incorrect");
            }
            console.dir(data);
        };
        
        var onError = function(data, textStatus, jqXHR) {
            console.dir(data);
        };
        
        var data = $(".log_form").serialize();
        var url = "worker/login_user.php";
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