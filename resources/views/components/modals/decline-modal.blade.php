<!-- The Modal -->
<div class="modal fade" id="createDeclineModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Decline Documents</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    
                    <div class="alert alert-info" style="display: none;" id='processing-decline'></div>
                        <form action="" id="create-decline">
                            @csrf
                            <input type="hidden" class="form-control" id="decline-id" name="id">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Comment/Feedback</label>
                                    <textarea class="form-control mb-2" name="comment" cols="30" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <input type="submit" class="btn bg-gradient-info mt-4" value="Decline">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 