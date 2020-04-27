$(function () {
    $('.btn-submit-prefs').click(function (e) {
        e.stopImmediatePropagation();
        axios.post('/en/admin/settings/save_prefs', $("#submit-prefs").serialize())
            .then(response => {
                window.location.reload();
            })
    })
})
