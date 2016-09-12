<script src="/ckeditor/ckeditor.js"></script>

<div style="width:700px;margin:100 auto;">
    <textarea name="editor" id="editor"></textarea>
    <button onclick="submit()">click</button>
</div>

<script>
    CKEDITOR.replace("editor")

    function submit(){
        console.log(CKEDITOR.instances.editor.getData())
    }
</script>
