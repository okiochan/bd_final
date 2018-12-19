$( document ).ready(function() {

    $('.reg_button').on('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            var onSuccess = function(data, textStatus, jqXHR) {
                
                if (data.indexOf("pass_mismatch") != -1) {
                    alert("pass not match");
                    return;
                }
                
                if (data.indexOf("pass_too_short") != -1) {
                    alert("pass too short");
                    return;
                }
                
                if (data.indexOf("success") != -1) {
                    alert("pass changed");
                    window.location = "login.php";
                    return;
                }
                
                alert("error occured");
                console.dir(data);
            };
            
            var onError = function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            };
            
            var data = $(".pass_form").serialize();
            var url = "worker/save_new_pass.php";
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