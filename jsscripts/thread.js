$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/getreplies", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
    $("#fillin_replies").html(content)
})
$("#new_reply_btn").click(function(){
    $("#thread_reply").css("display", "block")
    window.location = "#thread_reply"
})
$("#new_reply_close").click(function(){
    $("#thread_reply").css("display", "none")
    window.location = "#"
})

CKEDITOR.replace("editor")

$("#post_reply_btn").click(function(){
    var text = CKEDITOR.instances.editor.getData()
    if(text != ""){
        $.post("/phpscripts/requests/newreply", {id: $("#getid").data("id"), text: text}, function(html){
            console.log(html)
            $.get("/phpscripts/fillin/getreplies", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
                $("#fillin_replies").html(content)
            })
            $("#thread_reply").css("display", "none")
            window.location = "#"
            CKEDITOR.instances.editor.setData("")
        })
    }
})
