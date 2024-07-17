<!-- The Modal -->
<div class="modal fade" id="uploadTerminationModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Letter of Request</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="upload-termination">
                        @csrf
                            <input type="hidden" class="form-control mb-2" name="id" id="pullout-id">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Upload File</label>
                                    <input type="file" class="form-control mb-2" name="termination" id="uploaded-termination" accept=".pdf" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <input type="submit" class="btn bg-gradient-info mt-4" value="Upload">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 