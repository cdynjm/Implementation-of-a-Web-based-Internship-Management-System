<!-- The Modal -->
<div class="modal fade" id="uploadPreRequirementModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Document</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    
                    <div class="alert alert-info" style="display: none;" id='processing-upload-pre-requirements'></div>
                        <form action="" id="upload-pre-requirements">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Filename</label>
                                    <select name="filename" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        @foreach ($requirements as $req)
                                            @if($req->type == 1)
                                                <option value="{{ $req->id }}">{{ $req->description }} @if($req->category == 1) (Required) @endif @if($req->category == 2) (Optional) @endif</option>
                                            @endif
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Upload File</label>
                                    <input type="file" class="form-control mb-2" id="pre-uploaded-file" name="document" accept=".pdf" required>
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