$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/viewthreads", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
    $("#fillin_threads").html(content)
})
$.get("/phpscripts/fillin/getpinnedthreads", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
    $("#fillin_pinnedthreads").html(content)
})
$.get("/phpscripts/fillin/latestthreads", {url: window.location.pathname}, function(content){
    $("#fillin_latestthreads").html(content)
})
