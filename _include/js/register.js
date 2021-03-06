var ticketCopyManager = function(entryType) {
        var ticketCopyBuilder;
            copy = {
                entry: {
                    'ticket_name': "Entry Ticket- R150",
                    'blurb': "Full Access to all combined services and special seminars on Evangelism, Relationships, End Time Events and more."
                },
                half_entry: {
                    'ticket_name': "Conference Ticket- R250",
                    'blurb': "Includes stationery and cap."
                },    
                full_entry: {
                    'ticket_name': "Premium Conference Ticket- R500",
                    'blurb': "Includes stationery, cap, bag and t-shirt."
                    
                },
                sponsor: {
                    'ticket_name': "Sponsor Ticket- R1500",
                    'blurb': "Includes stationery, cap, bag and t-shirt."
                },
                pe_entry: {
                    'ticket_name': "Entry Ticket- R50",
                    'blurb': "Full Access to all combined services and special seminars on Evangelism, Relationships, End Time Events and more."
                }
        };
        $('#ticket_name').html(copy[entryType].ticket_name);
        $('#ticket_blurb').html(copy[entryType].blurb);
            
}; 
    

var reformatForm = function(type) {
    if (type == "port-elizabeth") {
        $("#meals_box").remove();            
        $("#accom_box").remove();            

    }    
};


$(document).ready(function(){

    ticketCopyManager($.cookie('amenConf2014__ticketType'));
     
    $("#reg-form input[name='entry_type']").val($.cookie('amenConf2014__ticketType'));
    var confLocation = $.cookie('amenConf2014__Location');
    if (confLocation === "cape-town") {
        $("#reg-form input[name='entry_location']").val('ct');
    }
    else if (confLocation === "port-elizabeth") {
        $("#reg-form input[name='entry_location']").val('pe');
            
    }
    else {
        $("#reg-form input[name='entry_location']").val('not sure');
    }

    reformatForm(confLocation);
    
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
            payment: "required"
            
        },
        messages: {
            full_name: "Please enter a valid name.",
            dob: "Please enter a valid date of birth. (dd-mm-yyyy)",
            email: "Please enter a valid email address.",
            mobile: "Please enter a valid mobile number.",
            gender: "Please enter a valid choice.",
            payment: "required"
            
        },
        submitHandler: function(e) {

            var post_data = $('#reg-form').serialize();
            $.ajax({
                url: '/ajax/register.php',
                type: 'post',
                data: post_data,
                dataType: 'json',
                success: function(data) { 
                    if (data.success == false) {
                        var errors = data.error_list;
                        for (var item in errors) {
                            $("#reg-form input[name='" + errors[item].field_name  + "']").addClass('error').after('<label for="' + errors[item].field_name  + '" class="error">' + errors[item].message  + '</label>')
                        }
                        $('html,body').animate({scrollTop: $("#reg-form input[name='" + errors[0].field_name + "']").offset().top - 50},'slow');
                        // Add successful feedback
                    }
                    else {
                        window.location = "/thank-you.html";    
                    }
                },
                error: function(x, e, r) {
                    console.log(x);
                }
            });
        },   
    } );    
});


