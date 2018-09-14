$(document).ready(function(){
    
    // Get user data from drop-down selection
    $("#user").change(function(){
        var user_id = $(this).val();
        console.log(user_id);
        
        $.ajax({
            url: '../ajax/get-user-roles.php',
            type: 'GET',
            data: { user_id: user_id},
            cache: false,
            success: function(data){
                $("#user_roles").html(data);
            }
        });
    });
    
    
    
});