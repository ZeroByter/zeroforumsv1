$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/latestthreads", {url: window.location.pathname}, function(content){
    $("#fillin_latestthreads").html(content)
})
$.get("/phpscripts/fillin/zeroeditor", function(html){
    $("#fillin_zeroeditor").html(html)
    $("#fillin_zeroeditor").css("height", "inherit")
})

$("#post_thread").click(function(){
    $.post("/phpscripts/requests/newthread", {parent: $("#get_parent_id").data("id"), subject: $("#subject_in").val(), body: getEditorString()}, function(html){
        console.log(html)
    })
})
$("#cancel").click(function(){
    window.location = "/subforum?id=" + $("#get_parent_id").data("id")
})
