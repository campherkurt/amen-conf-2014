$(document).ready(function(){
    $("#reg-submit").click(function(){
        $("#reg-form").trigger('submit'); 
        return false 
    });
    $("#reg-form").validate({
        rules: {
            full_name: "required",
            dob: "required",
            email: {
                email: true,
                required: true    
            },    
            mobile: "required",
            gender: "required",
            payment: "required",
        },
        messages: {
            full_name: "Please enter a valid name.",
            dob: "Please enter a valid date of birth. (dd-mm-yyyy)",
            email: "Please enter a valid email address.",
            mobile: "Please enter a valid mobile number.",
            gender: "Please enter a valid choice.",
            payment: "required",
            
        },
        submitHandler: function(e) {
            $("#reg-form input[name='entry_type']").val($.cookie('amenConf2014__ticketType'));
            $("#reg-form input[name='entry_location']").val($.cookie('amenConf2014__Location'));
            var post_data = $('#reg-form').serialize();
            $.ajax({
                url: '/ajax/register.php',
                type: 'post',
                data: post_data,
                dataType: 'json',
                success: function(data) { 
                    console.log(data);
                },
                error: function(x, e, r) {
                    console.log(x);    
                }
            });
        },   
    
    
    } );    
    
    
    
})


