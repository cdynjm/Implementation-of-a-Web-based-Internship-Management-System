<!-- The Modal -->
<div class="modal fade" id="createRequirementModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Requirement</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    
                    <div class="alert alert-info" style="display: none;" id='processing-requirements'></div>
                        <form action="" id="create-requirements">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Category</label>
                                    <select name="type" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        <option value="1">Pre-Deployment</option>
                                        <option value="2">Post-OJT</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Type</label>
                                    <select name="category" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        <option value="1">Required</option>
                                        <option value="2">Optional</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Description</label>
                                    <input type="text" class="form-control mb-2" name="description" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <input type="submit" class="btn bg-gradient-info mt-4" value="Add">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 