
/*
function getVal() {
    var editor = ace.edit('test',{
        mode:'ace/mode/php_laravel_blade'
    });
    editor.setTheme("ace/theme/twilight")
    editor.setOption("firstLineNumber", 1)
}
var textarea = $('textarea[name="test"]');
$('#saveLayout').on("click", function (e) {
    $(this).attr('disabled', 'disabled');
    e.preventDefault();
    textarea.val(editor.getSession().getValue());
    let data = $(this).parent().serialize();
    axios.post('/admin/save',data).then(function (response) {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        })
    });
    editor.getSession().on("change", function () {
        $('#saveLayout').attr('disabled', false);
    });
});

 */
