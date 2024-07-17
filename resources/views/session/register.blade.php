@extends('layouts.user_type.guest')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="container-fluid py-4">
        <div class="row mt-7">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="align-items-center text-center">
                        <a class="mt-3" href="{{ route('dashboard') }}">
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/logo/ccsit-logo.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                CCSIT - IMS
                            </span>
                        </a>
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-graduate me-1"></i> Register Account</h5> 
                            <p class="text-sm">Intern Registration Form</p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form role="form" id="create-intern" action="">
                            @csrf
                            
                            <div class="row" id="hide-form">
                                
                                <div class="col-md-6">
                                    <p class="text-sm">Your Internship Details</p>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Student Identification Card</label>
                                        <input type="text" class="form-control" name="studentid" required>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Full Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                   
                                    <div class="flex flex-col mb-2">
                                        <label for="">Address</label>
                                        <input type="text" class="form-control" name="address" required>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Contact Number</label>
                                        <input type="text" class="form-control" name="contact_number" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="">Birth Date</label>
                                            <input type="date" class="form-control" name="birthdate" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="">Gender</label>
                                            <select name="gender" id="" class="form-select" required>
                                                <option value="">Select...</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="P">Prefer Not to Say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Course/Program</label>
                                        <input type="text" class="form-control" name="course" value="BS in Information Technology" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Major</label>
                                          <select name="major" id="" class="form-select" required>
                                            <option value="">Select...</option>
                                              <option value="P">Programming</option>
                                              <option value="N">Networking</option>
                                          </select>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Academic Year</label>
                                        <select class="form-select fmxw-200 d-md-inline" name="year" aria-label="Message select example 2" required>
                                            <option value="">Select...</option>
                                            @php $count  = range(1,15); @endphp
                                            @php $from = 2023; @endphp
                                            @php $to = 2024; @endphp
                                            @foreach($count as $cnt)
                                                <option value="{{ $from }}-{{ $to }}">{{ $from }}-{{ $to }}</option>
                                                @php
                                                    $from += 1;
                                                    $to += 1;
                                                @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>
                                    <div class="flex flex-col mb-3">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email')}}" placeholder="" aria-label="Email" required>
                                        @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <label for="">Password</label>
                                        <input type="password" name="password" class="form-control" aria-label="Password" id="password" placeholder="" required>
                                        @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="" class="mt-2">Profile Picture</label>
                                            <input type="file" name="photo" class="form-control mb-2" id="profile-photo" onchange="createInternProfilePhoto(this)" required>
                                
                                            <center>
                                                <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded" id="create-intern-profile-photo" style="width: 200px; height: auto">
                                            </center>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="" class="mt-2">Student ORF for Verification</label>
                                            <input type="file" name="validID" class="form-control mb-2" id="valid-id" onchange="createInternValidID(this)" required>
                                
                                            <center>
                                                <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded" id="create-intern-valid-id" style="width: 200px; height: auto">
                                            </center>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="alert alert-info mt-2" style="display: none;" id='processing-intern'></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <button type="button" id="verify-email-btn" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Register</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row" id="show-verification" style="display: none;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <h5>Email Verification</h5>
                                    <p class="text-sm">A verification code has been delivered to the email address you provided.</p>
                                    <label for="" class="mt-2">Verification Code</label>
                                    <input type="text" class="form-control text-center" id="code" name="code" required>

                                    <button type="submit" id="submit-btn" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Verify</button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
  </section>

@endsection

@push('dashboard')
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
    const input1 = document.querySelector('#profile-photo');
    const input2 = document.querySelector('#valid-id');

    input1.addEventListener('change', async (e) => {
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

    input2.addEventListener('change', async (e) => {
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
@endpush