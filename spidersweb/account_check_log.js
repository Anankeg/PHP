$(document).ready(function(){
    $.getJSON("account_sever.php", function(json){ 
        if(json._log){
            $("#logalert").hide();
            $("#file").show();
            $("#changePassword").show();
            $("#id").html(json._id);
            $("#name").html(json._name);
            $("#email").html(json._email);
            $("#phone").html(json._phone);
            $(".avatar img").attr("src",json._avatar);
        }else{
            $("#logalert").show();
            $("#file").hide();
            $("#changePassword").hide();
        }
        
    }); 
});