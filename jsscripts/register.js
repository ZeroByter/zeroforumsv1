$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip()
})

$("#register_submit").click(function(){
    if($("#username_in").val() == ""){
        $("#username_warning").html("You must enter a username!")
        $("#username_in").focus()
        return
    }else{
        $("#username_warning").html("")
    }
    if($("#password_in").val() == ""){
        $("#password_warning").html("You must enter a password!")
        $("#password_in").focus()
        return
    }
    if($("#password_in").val().length <= 5){
        $("#password_warning").html("Your password must be longer than 5 charachters!")
        $("#password_in").focus()
        return
    }
    if($("#password_confirm_in").val() == ""){
        $("#password_warning").html("You must confirm your password!")
        $("#password_confirm_in").focus()
        return
    }
    if($("#password_in").val() != $("#password_confirm_in").val()){
        $("#password_warning").html("Passwords do not match!")
        $("#password_in").focus()
        return
    }else{
        $("#password_warning").html("")
    }
    if($("#email_in").val() != ""){
        if(!$("#email_in").val().includes("@")){
            return
        }
    }

    $.post("/phpscripts/requests/registeraccount.php", {username: $("#username_in").val(), password: $("#password_in").val(), displayname: $("#displayname_in").val(), email: $("#email_in").val()}, function(html){
        if(html.startsWith("error:")){
            $("#final_warning").html(html.split(":")[1])
        }else{
            $("#final_warning").html("")
        }
        if(html == "success"){
            window.location = "/"
        }
    })
})
