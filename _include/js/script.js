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


var menuManager = function(EventLocation) {
    $(".menu-item").each(function(item, elem){
         var oldHref = $(elem).attr('href');
         $(elem).attr('href', "/" + EventLocation + oldHref);
    }); 
        
};

var menuClicks = function() {
    $(".menu-item").each(function(index, elem) {
       console.log("Just doi");
       $(elem).click(function(){
           window.location = $(this).attr('href');
       });
    });
};

$(document).ready(function() {
    $(".registerhere").click(function(e) {
       e.preventDefault();
       var ticketSetter = ticketFactory($(this).attr('id'));
       ticketSetter();
    });

    menuManager($.cookie('amenConf2014__Location'));
    menuClicks();
});
