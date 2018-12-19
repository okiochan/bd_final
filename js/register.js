$( document ).ready(function() {

    function validate_form() {
        valid = true;
        var str = document.getElementById('Pass_Input').value;
        if (str.length <= 4) {
            alert("Password must be length at least 5");
            valid = false;
        }
        
        return valid;
    }
                        
    
    $('.reg_button').on('click', (e) => {
        
        if (validate_form() == true) {
            e.preventDefault();
            e.stopPropagation();
            
            var onSuccess = function(data, textStatus, jqXHR) {
                if (data.indexOf("success") != -1) {
                    alert("User register successful");
                    window.location = "movies.php";
                } else if (data.indexOf("userExist") != -1){
                    alert("User already exist");
                }else if (data.indexOf("emailExist") != -1){
                    alert("Email already exist");
                }else {
                    alert("error occured");
                }
                console.dir(data);
            };
            
            var onError = function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            };
            
            var data = $(".reg_form").serialize();
            var url = "db/register_user.php";
            var settings = {
                data: data,
                method: "POST",
                url: url,
                success: onSuccess,
                error: onError, 
            };
            $.ajax(settings);
        }
        else {
            e.preventDefault();
            e.stopPropagation();
        }
    });
    
});