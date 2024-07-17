@extends('components.modals.decline-modal')
@extends('components.modals.decline-application-modal')
@extends('components.modals.decline-account-modal')
@extends('layouts.user_type.auth')

@section('content')

  <div>
    <div class="row">
        <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="align-items-center text-center">
                        @foreach ($intern as $int)
                            @if($int->status == 0)
                                <h5 class="fw-bolder text-danger"><i class="fa-solid fa-hourglass-start me-1"></i></i> Account Under Review</h5> 
                            @endif
                            @if($int->status == 1)
                                <h5 class="fw-bolder text-info"><i class="fa-solid fa-circle-check me-1"></i></i></i> Verified Account</h5> 
                            @endif
                        @endforeach
                            <p class="text-sm">Intern Account Information</p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">

                            <div class="alert alert-info" style="display: none;" id='processing-intern-validation'></div>

                            @foreach ($intern as $int)

                            <input type="hidden" class="form-control" value="{{ $int->id }}" id="id">


                            <div class="row">
                                @include('components.modals.view-orf-modal')
                                <div class="col-md-6">
                                    <p class="text-sm">Personal Details</p>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Student Identification Card</label>
                                        <input type="text" class="form-control bg-white" value="{{ $int->studentid }}" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Full Name</label>
                                        <input type="text" class="form-control bg-white" value="{{ $int->name }}" readonly>
                                    </div>
                                   
                                    <div class="flex flex-col mb-2">
                                        <label for="">Address</label>
                                        <input type="text" class="form-control bg-white" value="{{ $int->address }}" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Contact Number</label>
                                        <input type="text" class="form-control bg-white" value="{{ $int->contact_number }}" readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="">Birth Date</label>
                                            <input type="text" class="form-control bg-white" value="{{ date('F d, Y',strtotime($int->birthdate)) }}" readonly>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="">Gender</label>
                                            @if($int->gender == 'M')
                                                <input type="text" class="form-control bg-white" value="Male" readonly>
                                            @endif
                                            @if($int->gender == 'F')
                                                <input type="text" class="form-control bg-white" value="Female" readonly>
                                            @endif
                                            @if($int->gender == 'P')
                                                <input type="text" class="form-control bg-white" value="Prefer Not To Say" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Course/Program</label>
                                        <input type="text" class="form-control bg-white" value="BS in Information Technology" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Major</label>
                                        @if($int->major == 'P')
                                            <input type="text" class="form-control bg-white" value="Programming" readonly>
                                        @endif
                                        @if($int->major == 'N')
                                            <input type="text" class="form-control bg-white" value="Networking" readonly>
                                        @endif
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                    <div class="flex flex-col mb-2">
                                        <label for="">Academic Year</label>
                                        <input type="text" class="form-control bg-white" value="{{ $int->year }}" readonly>
                                    </div>

                                    <div class="flex flex-col mb-2">
                                        <label for="">Coordinator</label>
                                        @if(!empty($int->Coordinator->name))
                                            <input type="text" class="form-control bg-white" value="{{ $int->Coordinator->name }}" readonly>
                                        @else
                                            <input type="text" class="form-control bg-white" value="Not Assigned to any coordinators yet" readonly>
                                        @endif
                                    </div>

                                    <div class="flex flex-col mb-2">
                                        <label for="">HTE/Company</label>
                                        @if($int->hte != null)
                                        <input type="text" class="form-control bg-white" value="{{ $int->HTE->name }}" readonly>
                                        @else
                                        <input type="text" class="form-control bg-white" value="No HTE Selected Yet" readonly>
                                        @endif
                                        
                                    </div>
                                        <div class="col-md-6">
                                            <label for="" class="mt-2">Profile Picture</label>
                                
                                            <center>
                                                <img src="{{ asset('storage/photo/'.$int->photo) }}" alt="" class="mt-4 img-fluid rounded" id="create-intern-profile-photo" style="width: 200px; height: auto">
                                            </center>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="" class="mt-2">Student ORF for Verification</label>
                                
                                            <center>
                                                <img src="{{ asset('storage/valid-id/'.$int->valid_id) }}" alt="" class="view-orf mt-4 img-fluid rounded" id="create-intern-valid-id" style="width: 200px; height: auto">
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                        @if($int->status == 0)
                                            <div class="d-flex justify-content-center">
                                                <input type="button" class="btn bg-gradient-danger mt-4 me-2" id="decline-intern" value="Decline">
                                                <input type="button" class="btn bg-gradient-info mt-4" id="validate-intern" value="Validate">
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>

            <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Pre-Deployment Documents</h5>
                        </div>
                        
                      </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Documents
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date Uploaded
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Checkbox
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $doc)
                                  @if($doc->status != 0)
                                    @if($doc->type == 1)
                                        <tr>
                                            <td id="{{ $doc->id }}" class="">
                                            <a href="{{ asset('storage/documents/'.$doc->file) }}" class="" target="_blank" data-bs-toggle="tooltip">
                                                <p class="text-xs font-weight-bold mb-0 ms-4"><i class="fa-solid fa-note-sticky text-lg me-2"></i>{{ $doc->Requirements->description }}</p>
                                            </a>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 ms-4">{{ date('F d, Y', strtotime($doc->date)) }}</p>
                                            </td>
                                            
                                            <td class="text-center" data-value="{{ $doc->id }}">
                                            @if($doc->status == 1)
                                                <p class="text-xs font-weight-bold mb-0 ms-4"><input type="checkbox" id="checked-document" @if($doc->check_document == 1) checked @endif></p>
                                            @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        @foreach ($intern as $int)
                        
                        <input type="hidden" value="{{ $int->id }}" id="document-id" class="form-control">
                        <input type="hidden" value="for-application" id="url-path" class="form-control">

                        @if(auth()->user()->role == 2)
                        @if($int->status == 1 && $int->training_status == 1)
                            <div class="text-center">
                                <button class="btn btn-sm text-capitalize bg-gradient-danger mt-4" id="decline-pre-documents">Decline</button>
                                <button class="btn btn-sm text-capitalize bg-gradient-dark mt-4" id="approve-pre-documents">Approve</button>
                            </div>
                        @endif
                       
                        @if($int->status == 1 && $int->training_status == 2)
                            <div class="text-center">
                                <button class="btn btn-sm text-capitalize bg-gradient-danger mt-4" id="return-to-intern">Return</button>
                                <button class="btn btn-sm text-capitalize bg-gradient-info mt-4" id="for-application">Apply</button>
                            </div>
                        @endif
                        @endif
                        @if(auth()->user()->role == 3)
                        @if($int->status == 1 && $int->training_status == 3)
                            <div class="text-center">
                                <button class="btn btn-sm text-capitalize bg-gradient-danger mt-4" id="decline-application">Decline</button>
                                <button class="btn btn-sm text-capitalize bg-gradient-dark mt-4" id="accept-application">Accept</button>
                            </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Post-OJT Documents</h5>
                        </div>
                        
                      </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Documents
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date Uploaded
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $doc)
                                    
                                        @if($doc->type == 2)
                                        <tr>
                                            <td id="{{ $doc->id }}" class="">
                                            <a href="{{ asset('storage/documents/'.$doc->file) }}" class="" target="_blank" data-bs-toggle="tooltip">
                                                <p class="text-xs font-weight-bold mb-0 ms-4"><i class="fa-solid fa-note-sticky text-lg me-2"></i>{{ $doc->Requirements->description }}</p>
                                            </a>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0 ms-4">{{ date('F d, Y', strtotime($doc->date)) }}</p>
                                            </td>
                                        </tr>
                                        @endif
                                   
                                @endforeach
                            </tbody>
                        </table>
                        @if(auth()->user()->role == 3)
                        @foreach ($intern as $int)
                        <input type="hidden" value="{{ $int->id }}" id="document-id" class="form-control">
                        @if($int->status == 1 && $int->training_status == 4)
                            <div class="text-center">
                                <button class="btn btn-sm text-capitalize bg-gradient-dark mt-4" id="complete-training">Complete</button>
                            </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
    </div>
  </div>
  
  @endsection
