$(document).ready(function(){
    $.getJSON("log_Bar.php", function(json){ 
        if(json._log){
            $("#user_Bar").show();
            $("#exitlog_Bar").show();
            $("#login_Bar").hide();
            $("#username_Bar").html(json._name);
        }else{
            $("#user_Bar").hide();
            $("#exitlog_Bar").hide();
            $("#login_Bar").show();
        }
        
    }); 
});