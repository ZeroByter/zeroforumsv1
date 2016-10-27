$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/getreplies", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
    $("#fillin_replies").html(content)
})
$.get("/phpscripts/fillin/zeroeditor", function(content){
    $("#fillin_zeroeditor").html(content)
})
$("#new_reply_btn").click(function(){
    $("#thread_reply").css("display", "block")
    window.location = "#thread_reply"
})
$("#new_reply_close").click(function(){
    $("#thread_reply").css("display", "none")
    window.location = "#"
})

$("#thread_body_div").html(filter_bbcode($("#thread_body_div").html()))

$("#post_reply_btn").click(function(){
    var text = getEditorString()
    if(text != ""){
        $.post("/phpscripts/requests/newreply", {id: $("#getid").data("id"), text: text}, function(html){
            $.get("/phpscripts/fillin/getreplies", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
                $("#fillin_replies").html(content)
            })
            $("#thread_reply").css("display", "none")
            window.location = "#"
            $("#textarea").html("")
        })
    }
})

$("#lock_thread_btn, #unlock_thread_btn").click(function(){
    $.post("/admin/requests/thread_toggle_lock", {id: $("#getid").data("id")}, function(html){
        location.reload()
    })
})
$("#pin_thread_btn, #unpin_thread_btn").click(function(){
    $.post("/admin/requests/thread_toggle_pin", {id: $("#getid").data("id")}, function(html){
        location.reload()
    })
})
$("#hide_thread_btn, #unhide_thread_btn").click(function(){
    $.post("/admin/requests/thread_toggle_hidden", {id: $("#getid").data("id")}, function(html){
        location.reload()
    })
})

$("#delete_thread_btn").click(function(){
    $.post("/admin/requests/thread_delete", {id: $("#getid").data("id")}, function(html){
        window.location = "/forums"
    })
})

$("#edit_thread_btn").click(function(){
    window.location = "/editthread?id=" + $("#getid").data("id")
})
