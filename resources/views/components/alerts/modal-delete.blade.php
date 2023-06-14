<!-- Button trigger modal -->
<button type="button" class="btn btn-danger mt-1" data-bs-toggle="modal" data-bs-target={{ "#delete-". $subject . '-'. $id}}>
    Delete
</button>


<!-- Modal -->
<div class="modal fade" id={{ "delete-". $subject . '-'. $id }} tabindex="-1" aria-labelledby={{"delete-". $subject . '-'.
    $id }}
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this {{ $subject }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action={{ url($pathDelete . $id)}}>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>