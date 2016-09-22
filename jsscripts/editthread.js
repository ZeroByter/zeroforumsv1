$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/zeroeditor", function(content){
    $("#fillin_zeroeditor").html(content)
    setEditorString($("#getbody").html())
})

$("#edit_thread_btn").click(function(){
    $.post("/phpscripts/requests/editthread", {id: $("#getid").data("id"), subject: $("#subject_in").val(), body: getEditorString()}, function(html){
        window.location = "/thread?id=" + $("#getid").data("id")
    })
})
