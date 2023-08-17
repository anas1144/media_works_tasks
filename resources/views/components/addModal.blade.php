{{--    add meeting model --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">New Meeting</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('meetings.store')}}" id="add_meeting_form">
                    @csrf
                    <div class="mb-3">
                        <label for="subject" class="col-form-label">Subject:</label>
                        <input type="text" name="subject" class="form-control" id="subject">
                    </div>
                    @error('subject')
                    <span class="invalid-feedback mb-2 d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <div class="mb-3">
                        <label for="recipient_email" class="col-form-label">Recipient Email:</label>
                        <select name="recipient_email" class="form-select " id="recipient_email">
                            <option value="">Select</option>
                            @forelse($users as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @empty
                                <option disabled>No Data Fund</option>
                            @endforelse
                        </select>
                    </div>
                    @error('recipient_email')
                    <span class="invalid-feedback mb-2 d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <div class="mb-3">
                        <label for="start_time" class="col-form-label">Start Time:</label>
                        <input type="datetime-local" name="start_time" class="form-control" id="start_time">
                    </div>
                    @error('start_time')
                    <span class="invalid-feedback mb-2 d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <div class="mb-3">
                        <label for="end_time" class="col-form-label">End Time:</label>
                        <input type="datetime-local" name="end_time" class="form-control" id="end_time">
                    </div>
                    @error('end_time')
                    <span class="invalid-feedback mb-2 d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="SubmitForm('#add_meeting_form')"
                        class="btn btn-primary button-spinner">Save</button>
            </div>
        </div>
    </div>
</div>
