$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/getselfprofile", function(content){
    $("#fillin_selfprofile").html(content)
})

$("#login_submit").click(function(){
    var username = $("#username_in").val()
    var password = $("#password_in").val()

    $.post("/phpscripts/requests/login.php", {username: username, password: password}, function(html){
        console.log(html)
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
