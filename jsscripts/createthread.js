$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/latestthreads", {url: window.location.pathname}, function(content){
    $("#fillin_latestthreads").html(content)
})
$.get("/phpscripts/fillin/zeroeditor", function(html){
    $("#fillin_zeroeditor").html(html)
    $("#fillin_zeroeditor").css("height", "inherit")
    $("#textarea").attr("required", "")
})

$("#submit_form").submit(function(){
    $.post("/phpscripts/requests/newthread", {parent: $("#get_parent_id").data("id"), subject: $("#subject_in").val(), body: getEditorString()}, function(html){
        window.location = "/thread?id=" + html
    })
    return false
})
$("#cancel").click(function(){
    window.location = "/subforum?id=" + $("#get_parent_id").data("id")
})
