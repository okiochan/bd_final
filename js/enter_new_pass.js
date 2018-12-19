$( document ).ready(function() {
    
    // onfocus
    document.getElementById('Pass_Input').onfocus = function() {
        document.getElementById('Pass_Input').style.borderColor = 'green';
    };
    document.getElementById('Pass_Input1').onfocus = function() {
        document.getElementById('Pass_Input1').style.borderColor = 'green';
    };
    
    // onblur
    document.getElementById('Pass_Input').onblur = function() {
        document.getElementById('Pass_Input').style.borderColor = 'rgba(0, 0, 0, 0.1)';
    };
    document.getElementById('Pass_Input1').onblur = function() {
        document.getElementById('Pass_Input1').style.borderColor = 'rgba(0, 0, 0, 0.1)';
    };
    // --------------------------------------------             
    
    $('.reg_button').on('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            var onSuccess = function(data, textStatus, jqXHR) {
                
                if (data.indexOf("pass_mismatch") != -1) {
                    document.getElementById('Pass_Input').style.borderColor = 'red';
                    document.getElementById('Pass_Input1').style.borderColor = 'red';
                    document.getElementById('help_for_pass_input').innerHTML = "pass mismatch";
                    document.getElementById('help_for_pass_input').style.visibility = "visible";
                    return;
                }
                
                if (data.indexOf("pass_too_short") != -1) {
                    document.getElementById('Pass_Input').style.borderColor = 'red';
                    document.getElementById('help_for_pass_input').innerHTML = "pass is too short";
                    document.getElementById('help_for_pass_input').style.visibility = "visible";
                    return;
                }
                
                if (data.indexOf("success") != -1) {
                    window.location = "pass_changed.php";
                    return;
                }
                
                alert("error occured");
                window.location = "index.php";
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