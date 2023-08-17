function isEmpty(e) {
    let t = !0;
    return null != e && "null" != e && "undefined" != e && "" != e && (t = !1), t
}

function RemoveButtonSpinner(id, text, icon = null) {
    let html = (('<i class="' + icon + '">') ?? '') + text;
    $(id).html(html), $(this).attr('disabled', false)
}

function SubmitForm(id) {
    setTimeout(function () {
        $(id).submit();
    }, 100)
}

function OpenDeleteModel(url) {
    $('#delete_from').attr('action', url);
    $('#deleteModal').modal('show')
}
function FromFieldsReset(form_id) {
    var from = $(form_id)
    from.trigger('reset')
    from.find('.form-control').removeClass('is-invalid')
    from.find('.invalid-feedback').removeClass('d-block')
    if ($('.custom-switch').prop('checked') == true)
        $('.custom-switch').click()
}

$(document).ready(function () {

    //add button spinner
    $('.button-spinner').click(function () {
        $(this).html('<i class="spinner-border spinner-border-sm text-light mb-1"></i> Loading...'),
            $(this).attr('disabled', true)
    })

})





