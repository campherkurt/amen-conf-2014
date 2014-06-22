var ticketFactory = function(ticketID){
    return function() {
        if (window.location.pathname.search('cape-town') > -1) {
            $.cookie('amenConf2014__Location', 'cape-town');  
        }
        if (window.location.pathname.search('port-elizabeth') > -1) {
            $.cookie('amenConf2014__Location', 'port-elizabeth');  
        }
        $.cookie('amenConf2014__ticketType', ticketID);  
        window.location = '/register.html';
    };
};
$(document).ready(function() {
    $(".registerhere").click(function(e) {
       e.preventDefault();
       var ticketSetter = ticketFactory($(this).attr('id'));
       ticketSetter();
    });

    
});
