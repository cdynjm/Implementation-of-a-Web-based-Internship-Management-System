<!-- The Modal -->
<div class="modal fade" id="declineAccountModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                            <div class="row">
                                <input type="hidden" id="decline-id" class="form-control" readonly>
                                <div class="col-md-12 mb-2">
                                    <label for="">Description</label>
                                    <input type="text" id="description" class="form-control">
                                </div>  
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" id="confirm-decline-intern" class="btn btn-sm bg-gradient-info">Confirm</button>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div> 