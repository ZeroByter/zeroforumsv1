<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">

<style>
    #body_div{
        width: 600px;
        margin: 0 auto;
    }
    #textarea{
        max-width: 100%;
        height: 200px;
    }
    #texteditor_controls{
        margin-bottom: 10px;
    }
</style>

testing text editor<br><br><br><br><br><br><br>
<div class="panel panel-primary" id="body_div">
    <div class="panel-heading">Test text editor</div>
    <div class="panel-body">
        <!--button id="bold">bold</button!-->
        <div id="texteditor_controls">
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-bold"></span></button>
                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-italic"></span></button>
                </div>
            </div>
        </div>
        <div>
            <textarea class="form-control" id="textarea"></textarea>
        </div>
    </div>
</div>

<script>
    $("#bold").click(function(){
        var stringSelected = $("#textarea").val().slice(textarea.selectionStart, textarea.selectionEnd)
        var stringBefore = $("#textarea").val().slice(0, textarea.selectionStart)
        var stringAfter = $("#textarea").val().slice(textarea.selectionStart + stringSelected.length)

        $("#textarea").val(stringBefore + "[b]" + stringSelected + "[/b]" + stringAfter)
        textarea.selectionStart -= 4
        textarea.selectionEnd -= 4
        $("#textarea").focus()
    })
</script>
