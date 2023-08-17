$(document).ready(function () {
    // Select2 Single  with Placeholder
    $(".select2-single").select2({
        placeholder: "Select an Email",
        allowClear: true,
    });

});

function AddMeeting() {
    FromFieldsReset('#add_meeting_form')

}

function EditMeeting(update_url,edit_url) {
    FromFieldsReset('#update_meeting_form')
    GetMeeting(edit_url);
    $('#update_meeting_form').attr('action', update_url)
    $('#updateModal').modal('show')
}

function GetMeeting(edit_url) {
    $.ajax({
        url: edit_url,
        type: window.methods.GET,
        success: function(response) {
            FillMeetingFrom(response.meeting)
        },
        error: function(t) {
            return false
        },
        complete: function(t) {},
    });
}

function FillMeetingFrom(meeting) {
    $('#subject_update').val(meeting.subject)
    $('#start_time_update').val(meeting.start_time)
    $('#end_time_update').val(meeting.end_time)

}



