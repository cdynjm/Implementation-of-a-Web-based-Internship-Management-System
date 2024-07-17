<!-- The Modal -->
<div class="modal fade" id="createHTEModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New HTE/Company</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    
                    <div class="alert alert-info" style="display: none;" id='processing-hte'></div>
                        <form action="" id="create-hte" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-sm">Company Information</p>

                                    <label for="">Company/HTE Name</label>
                                    <input type="text" class="form-control mb-2" name="name" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control mb-2" name="address" required>

                                    <label for="">Contact Person</label>
                                    <input type="text" class="form-control mb-2" name="contact_person" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control mb-2" name="contact_number" required>

                                    <label for="">Upload Profile Photo</label>
                                    <input type="file" name="photo" class="form-control mb-2" onchange="createHTEProfilePhoto(this)" id="create-hte-photo" required>
                                        
                                    <center>
                                        <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded-circle" id="create-hte-profile-photo" style="width: 150px; height: auto">
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control mb-2" name="email" required>

                                    <label for="">Password</label>
                                    <input type="password" class="form-control mb-2" name="password" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <input type="submit" class="btn bg-gradient-success mt-4" value="Create Account">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 

<script>

    // Get the selected file from the file input
    const createInput = document.querySelector('#create-hte-photo');

    createInput.addEventListener('change', async (e) => {
        // Get the files
        const { files } = e.target;

        // No files selected
        if (!files.length) return;

        // We'll store the files in this data transfer object
        const dataTransfer = new DataTransfer();

        // For every file in the files list
        for (const file of files) {
            // We don't have to compress files that aren't images
            if (!file.type.startsWith('image')) {
                // Ignore this file, but do add it to our result
                dataTransfer.items.add(file);
                continue;
            }

            // We compress the file by 50%
            const compressedFile = await compressImage(file, {
                quality: 0.4,
                type: 'image/jpeg'
            });

            // Save back the compressed file instead of the original file
            dataTransfer.items.add(compressedFile);
        }

        // Set value of the file input to our new files list
        e.target.files = dataTransfer.files;
    });
</script>