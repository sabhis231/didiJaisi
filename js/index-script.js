$(function() {
var isvalidMail = true;
        var isvalidName = true;
        var isvalidMobile = true;
    $("body").on("click", "#submit", function() {
        

        // $(".result").html("");
        var subscriber_plan = $("input[name='subscribe_pack']:checked").val();
        var subscriber_product = $("input[name='subscribe_product']:checked").val();
        var subscriber_type = $("input[name='subscribe_product_type']:checked").val();
        var subscriber_size = $("input[name='subscribe_product_size']:checked").val();

        var subscriber_name = ($("#name").val()).trim();
        var subscriber_email = ($("#email").val()).trim();
        var subscriber_mobile = ($("#mobile").val()).trim();
        var subscriber_address = ($("#address").val()).trim();
        var subscriber_occupation = ($("#occupation").val()).trim();
        var subscriber_message = ($("#message").val()).trim();
        $("body .name-error").remove();
        $("body .email-error").remove();
        $("body .mobile-error").remove();
        if (subscriber_name === "" || subscriber_name === undefined) {
            console.log(isvalidName);
            var nameError = '<div class="alert-message error name-error">Please enter your Name.<span class="close" href="#">x</span></div>';
            $(".result").append(nameError);
            isvalidName = false;
        } else {
            if (!validateName(subscriber_name)) {
               nameError = '<div class="alert-message error name-error">Please enter a valid Name.<span class="close" href="#">x</span></div>';
                $(".result").append(nameError);
                isvalidName = false;
            } else {
                
                isvalidName = true;
            }

        }
        if (subscriber_email === "" || subscriber_email === undefined) {
            // $("body .email-error").remove();
            var emailError = '<div class="alert-message error email-error">Please enter your Email.<span class="close" href="#">x</span></div>';
            $(".result").append(emailError);
            isvalidMail = false;
        } else {
            if (!validateEmail(subscriber_email) ) {
                $("body .email-error").remove();
                 emailError = '<div class="alert-message error email-error">Please enter a valid Email.<span class="close" href="#">x</span></div>';
                 $(".result").append(emailError);
                 isvalidMail = false;
            } else {
               isvalidMail = true;
            }


        }
        if (subscriber_mobile === "" || subscriber_mobile === undefined) {
            var mobileError = '<div class="alert-message error mobile-error">Please enter your Mobile.<span class="close" href="#">x</span></div>';
            $(".result").append(mobileError);
            isvalidMobile = false;
        } else {
            if (!validateMobile(subscriber_mobile)) {
                mobileError = '<div class="alert-message error mobile-error">Please enter valid Mobile Number.<span class="close" href="#">x</span></div>';
                $(".result").append(mobileError);
                isvalidMobile = false;
            } else {
                isvalidMobile = true;
            }

        }
console.log(isvalidName);
        if (isvalidMail && isvalidMobile && isvalidName) {
            $("#contact-form").hide();
            var processMessage = '<div class="alert-message success email-error">Processing Your Request.</div>';

            $(".result").html(processMessage);

            $.ajax({

                url: "subscribe_update.php",
                type: "POST",
                data: {
                    subscriber_name: capital_letter(subscriber_name),
                    subscriber_email: lower_Case(subscriber_email),
                    subscriber_mobile: capital_letter(subscriber_mobile),
                    subscriber_address: capital_letter(subscriber_address),
                    subscriber_occupation: capital_letter(subscriber_occupation),
                    subscriber_message: capital_letter(subscriber_message),

                    subscriber_plan: capital_letter(subscriber_plan),
                    subscriber_product: capital_letter(subscriber_product),
                    subscriber_type: capital_letter(subscriber_type),
                    subscriber_size: capital_letter(subscriber_size),
                    subscriber_type_image: subscriber_type
                },
                success: function(successdata) {
                    // console.log(successdata);
                        //  $(".result").html("");
                    responseData = JSON.parse(successdata);
                    if (responseData.responseCode == 1) {
                        var successMessage = '<div class="alert-message success email-error">Thank you for your subscription. Please check your mail for subscription details.<span class="close" href="#">x</span></div>';
                        $(".result").html(successMessage);
                    } else {
                        var errorMessage = '<div class="alert-message error email-error">Website Under maintenance. Please try after some Time.<span class="close" href="#">x</span></div>';
                        $(".result").html(errorMessage);
                        $("#contact-form").show();

                    }
                },
                error: function(errorData) {
                    console.log(errorData);

                }
            })
        }
        return false;

    });
});
var validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}


var capital_letter = function(str) {
    var splitStr = str.trim().toLowerCase().replace(/ {1,}/g," ").split(' ');
    for (var i = 0; i < splitStr.length; i++) {
       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
    }
    splitStr=splitStr.join(' ');
    if(splitStr===""){
        splitStr="Not Available";
    }
   return splitStr; 
}
var lower_Case = function(str) {
    
    return str.toLowerCase();
}
var validateName = function(str) {
    var name = /^[a-zA-Z ]{4,30}$/;
    return name.test(String(str).toLowerCase());
}
var validateMobile = function(str) {
    var phoneno = /^[0][1-9]\d{9}$|^[1-9]\d{9}$/g;
    return phoneno.test(String(str).toLowerCase());
}