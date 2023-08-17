<!-- Modal Delete -->
<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabeldelete"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabeldelete">
                    Ohh No!
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Delete?</p>
            </div>
            <div class="modal-footer py-1">
                <button
                    type="button"
                    class="btn btn-outline-s"
                    data-dismiss="modal"
                >
                    Cancel
                </button>
                <button  onclick="SubmitForm('#delete_from')"  class="btn btn-danger button-spinner">Delete</button>
                <form id="delete_from" method="POST" action="">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                </form>
            </div>
        </div>
    </div>
</div>
