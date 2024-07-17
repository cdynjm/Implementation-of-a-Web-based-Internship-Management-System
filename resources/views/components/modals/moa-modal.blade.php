<!-- The Modal -->
<div class="modal fade" id="uploadMOAModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New MOA</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="upload-moa">
                        @csrf
                            <input type="hidden" class="form-control mb-2" name="id" id="moa-id">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Upload File</label>
                                    <input type="file" class="form-control mb-2" name="moa" id="uploaded-moa" accept=".pdf" required>
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