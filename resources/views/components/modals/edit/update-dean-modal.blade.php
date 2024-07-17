<!-- The Modal -->
<div class="modal fade" id="editDeanModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Dean</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    
                    <div class="alert alert-info" style="display: none;" id='edit-processing-dean'></div>
                        <form action="" id="update-dean" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control mb-2" name="id" id="edit-id" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-sm">Personal Information</p>

                                    <label for="">Name</label>
                                    <input type="text" class="form-control mb-2" name="name" id="edit-name" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control mb-2" name="address" id="edit-address" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control mb-2" name="contact_number" id="edit-contact-number" required>

                                    <label for="">Upload New Profile Photo</label>
                                    <input type="file" name="photo" id="update-dean-photo" class="form-control mb-2" onchange="updateCoordinatorProfilePhoto(this)">
                                        
                                    <center>
                                        <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded-circle" id="update-coordinator-profile-photo" style="width: 150px; height: auto">
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control mb-2" name="email" id="edit-email" required>

                                    <label for="">Change Password</label>
                                    <input type="password" class="form-control mb-2" name="password">
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <input type="submit" class="btn bg-gradient-success mt-4" value="Update Account">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 

<script>
    const compressImage = async (file, { quality = 1, type = file.type }) => {
        // Get as image data
        const imageBitmap = await createImageBitmap(file);

        // Draw to canvas
        const canvas = document.createElement('canvas');
        canvas.width = imageBitmap.width;
        canvas.height = imageBitmap.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(imageBitmap, 0, 0);

        // Turn into Blob
        const blob = await new Promise((resolve) =>
            canvas.toBlob(resolve, type, quality)
        );

        // Turn Blob into File
        return new File([blob], file.name, {
            type: blob.type,
        });
    };

    // Get the selected file from the file input
  
    const updateInput = document.querySelector('#update-dean-photo');

    updateInput.addEventListener('change', async (e) => {
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