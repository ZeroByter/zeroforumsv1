$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
    $("#fillin_navbar").html(content)
})
$.get("/phpscripts/fillin/forums", {url: window.location.pathname}, function(content){
    $("#fillin_forums").html(content)
})
$.get("/phpscripts/fillin/latestthreads", {url: window.location.pathname}, function(content){
    $("#fillin_latestthreads").html(content)
})
