$(document).ready(function loadUserRoles(){
    var user = $("#username").val();
    $("#rolesList .role").mousedown(function(e){
        e.preventDefault();
        var loc = $(this).attr("href");
        console.log(loc);
        var role = $(this).text();
        $.ajax({
            async: false,
            url: "change_role.php",
            data: {
                "user_mail": user,
                "role": role,
            },
            type: "POST",
            success: function(data, state){
                var dataBinary = $.parseJSON(data);
                if(dataBinary){
                    location.assign(loc);
                }
                return false;
            },
            error: function(request, state, error){
                return false;
            },
        });
    });
});