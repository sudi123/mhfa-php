/*
 JQuery that performs username, password and gender check, username validation and AJAX calls to PHP pages based on the action.
 */
$(document).ready(function() {

    /*
     *   JQuery Registration form validation
     *   Username: Should be atleast 5 characters, required and must be lowercase
     *   Password: Required and should contain atleast 6 characters
     */
    $('#register-form').validate({

        rules: {
            username: {
                required:true,
                minlength:5,
                testlowercase: true
            },
            password: {
                required: true,
                minlength: 6
            },
            gender: {
                required:true
            }
        },
        messages: {
            username: {
                required: "Please provide a username",
                minlength: "The username should be atleast 5 characters",
                remote: 'Username already used'
            },
            password: {
                required: "Please provide a password",
                minlength: "The password should be atleast 6 characters"
            },
            gender: {
                required: "Atleast an option must be selected"
            }
        },

        errorPlacement: function(error, element) {
            if (element.attr("type") == "radio") {
                error.insertBefore(element);
            } else {
                error.insertAfter(element);
            }
        },
        errorClass: "my-error-class",
    });

    $.validator.addMethod("testlowercase", function(value, element) {
        return this.optional(element) || /^[a-z0-9]+$/.test(value);
    }, "username must contain only lower case letters or numbers");


    // Register form submit through ajax
    $("#register-form").submit(function(e)
    {
        e.preventDefault();
        //  check if the form passes the validation phase
        if(($(".form-control.my-error-class").length == 0) && $('[name="gender"]:checked').length != 0) {
            var postData = $(this).serialize();
            var formURL = $(this).attr("action");
            // ajax call to register.php to register the user
            $.ajax(
                {
                    url : formURL,
                    type: "POST",
                    data : postData,
                    headers: { 'x-my-custom-header': 'register' },
                    success: function(response)
                    {
                        var str = $("#checkusername").html();
                        if($.trim(str) == "Username accepted") {
                            // register only if the username is not duplicated
                            $("#message").html(response);
                            $("#message").addClass("my-success-class");
                            $("#register-form")[0].reset();
                            $("#checkusername").html('');
                        }
                    },
                    error: function(response)
                    {
                        $("#message").html(response);
                    }
                });
        }
    });
    
    // Login form submit through ajax
    $("#login-form").submit(function(e)
    {
        e.preventDefault();
        var postData = $(this).serialize();
        var formURL = $(this).attr("action");
        // ajax call to login.php to validate the login credentials
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            datatype: JSON,
            headers: { 'x-my-custom-header': 'login' },
            success: function(response) 
            {
                var resObj = JSON.parse(response);
                if(resObj.responseFlag) {
                    $("#message").html(resObj.responseMessage);
                    $("#message").removeClass("my-error-class");
                    $("#message").addClass("my-success-class");
                    $("#login-form")[0].reset();
                }else {
                    $("#message").html(resObj.responseMessage);
                    $("#message").removeClass("my-success-class");
                    $("#message").addClass("my-error-class");
                    $("#login-form")[0].reset();
                }
            },
            error: function(response) 
            {
                $("#message").html(response);      
            }
            
        });
    });
    
    /* Home page jquery code that toggles between Login and Register */
    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
        $("#message").html('');
        $(".my-success-class").css('background','white');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
        $("#message").html('');
        $(".my-success-class").css('background','white');
		e.preventDefault();
	});
    
    /* Username validation during Registration. Check if username already exists */
    $("#register-form").find('input[name="username"]').blur(function(e) {
        e.preventDefault();
        var userData = $(this).serializeArray();
        if($(".form-control.my-error-class").length == 0) {
            $.ajax(
                {
                    url : 'checkusername.php',
                    type: "POST",
                    data : userData,
                    headers: { 'x-my-custom-header': 'checkusername' },
                    success:function(response)
                    {
                        if($.trim(response) == "Username accepted") {
                            $("#checkusername").text(response);
                            $("#checkusername").css('color','green');
                        }
                        else {
                            $("#checkusername").text(response);
                            $("#checkusername").css('color','red');
                        }

                    },
                    error: function(response)
                    {
                        $("#checkusername").text(response);
                    }
                });

        }

    });
    
    /* Login form validation */
    $("#login-form").validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Please enter a username"
            },
            password: {
                required: "Please enter a password"
            }
        },
        errorClass: "my-error-class"
    });
});


