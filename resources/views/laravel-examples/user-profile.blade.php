@extends('layouts.user_type.auth')

@section('content')

<div>
<div class="container-fluid py-4">
        <div class="row mt-2">
            <div class="col-md-12">
                
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="align-items-center text-center">
                        @if(auth()->user()->role == 1)
                        <a class="mt-3">
                            @if(auth()->user()->photo == null)
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/icon/profile-placeholder.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            @else
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.auth()->user()->photo) }}" class="ms-0 mb-4 mt-2" alt="...">
                            @endif
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                {{ auth()->user()->name }}
                            </span>
                        </a>
                        @endif
                        @if(auth()->user()->role == 2)
                        <a class="mt-3">
                            @if(auth()->user()->Coordinator->photo == null)
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/icon/profile-placeholder.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            @else
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.auth()->user()->Coordinator->photo) }}" class="ms-0 mb-4 mt-2" alt="...">
                            @endif
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                {{ auth()->user()->name }}
                            </span>
                        </a>
                        @endif
                        @if(auth()->user()->role == 3)
                        <a class="mt-3">
                            @if(auth()->user()->HTE->photo == null)
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/icon/profile-placeholder.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            @else
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.auth()->user()->HTE->photo) }}" class="ms-0 mb-4 mt-2" alt="...">
                            @endif
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                {{ auth()->user()->name }}
                            </span>
                        </a>
                        @endif
                        @if(auth()->user()->role == 4)
                        <a class="mt-3">
                            @if(auth()->user()->Deans->photo == null)
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/icon/profile-placeholder.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            @else
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.auth()->user()->Deans->photo) }}" class="ms-0 mb-4 mt-2" alt="...">
                            @endif
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                {{ auth()->user()->name }}
                            </span>
                        </a>
                        @endif
                        @if(auth()->user()->role == 5)
                        <a class="mt-3">
                            @if(auth()->user()->Intern->photo == null)
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/icon/profile-placeholder.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            @else
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.auth()->user()->Intern->photo) }}" class="ms-0 mb-4 mt-2" alt="...">
                            @endif
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                {{ auth()->user()->name }}
                            </span>
                        </a>
                        @endif
                        @if(auth()->user()->role == 1)
                            <h5 class="fw-bolder text-sm"><i class="fa-solid fa-user me-1"></i> Administrator</h5> 
                        @endif
                        @if(auth()->user()->role == 2)
                            <h5 class="fw-bolder text-sm"><i class="fa-solid fa-user me-1"></i> OJT Coordinator</h5> 
                        @endif
                        @if(auth()->user()->role == 3)
                            <h5 class="fw-bolder text-sm"><i class="fa-solid fa-user me-1"></i> HTE/Company</h5> 
                        @endif
                        @if(auth()->user()->role == 4)
                            <h5 class="fw-bolder text-sm"><i class="fa-solid fa-user me-1"></i> College Dean</h5> 
                        @endif
                        @if(auth()->user()->role == 5)
                            <h5 class="fw-bolder text-sm"><i class="fa-solid fa-user me-1"></i> Intern</h5> 
                        @endif
                            <p class="text-sm">Account Profile</p>
                        </div>
                    </div>
                    @if(auth()->user()->role == 1)
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form role="form" id="update-admin-account" action="">
                            @csrf
                            
                            <input type="hidden" class="form-control" name="id" value="{{ auth()->user()->id }}" required>

                            <div class="row">

                                <div class="col-md-6">
                                    <p class="text-sm">Personal Details</p>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                    </div>

                                    <label for="" class="mt-2">New Profile Picture</label>
                                    <input type="file" name="photo" class="form-control mb-2" id="admin-photo" onchange="createAdminProfilePhoto(this)">
                        
                                    <center>
                                        <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded" id="create-admin-profile-photo" style="width: 200px; height: auto">
                                    </center>

                                </div>

                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>
                                    <div class="flex flex-col mb-3">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="" aria-label="Email" required>
                                        @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <label for="">Change Password</label>
                                        <input type="password" name="password" class="form-control" aria-label="Password" id="password" placeholder="">
                                        @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                  
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="card">
                        <div class="card-header pb-0 px-3">
                            @if(auth()->user()->role == 1)
                            <h6 class="mb-0"><i class="fa-solid fa-newspaper"></i> Your Announcements</h6>
                            @else
                            <h6 class="mb-0"><i class="fa-solid fa-newspaper"></i> Announcements</h6>
                            @endif
                        </div>
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                            @foreach ($announcements as $an)
                            
                            <li class="list-group-item border-0 d-flex p-4 mb-4 bg-gray-100 border-radius-lg" data-value="{{ $an->id }}">
                                <div class="d-flex flex-column">
                                    <div class="align-items-center">
                                        <a class="mb-4">
                                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.$an->User->photo) }}" class="mb-2" alt="...">
                                            <span class="ms-3 sidebar-text fw-bolder text-sm mb-3">
                                                {{ $an->User->name }}
                                            </span>
                                        </a>
                                    </div>
                                <span class="text-dark font-weight-bold text-xs mt-2 mb-3">{{ $an->description }}</span>
                                @if($an->photo != null)
                                    <img style="width: 250px; height: auto; border-radius: 10px;" src="{{ asset('storage/announcements/'.$an->photo) }}" class="mb-2" alt="...">
                                @endif
                                <div class="mb-2 text-xs mt-3">{{ date('h:i a | M d, Y', strtotime($an->created_at)) }}</div>
                                </div>
                                <div class="ms-auto text-end">
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" id="delete-announcements"><i class="far fa-trash-alt me-2"></i></a>
                                </div>
                            </li>
                            @endforeach
                            </ul>
                        </div>
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->role == 2)
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form role="form" id="update-coordinator" action="">
                            @csrf
                            
                            <input type="hidden" class="form-control" name="id" value="{{ auth()->user()->Coordinator->id }}" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-sm">Personal Information</p>

                                    <label for="">Name</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->Coordinator->name }}" name="name" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->Coordinator->address }}" name="address" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->Coordinator->contact_number }}" name="contact_number" required>

                                    <label for="">New Profile Picture</label>
                                    <input type="file" name="photo" class="form-control mb-2" id="coordinator-photo" onchange="createCoordinatorProfilePhoto(this)">
                                        
                                    <center>
                                        <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded-circle" id="create-coordinator-profile-photo" style="width: 150px; height: auto">
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control mb-2" value="{{ auth()->user()->email }}" name="email" required>

                                    <label for="">Change Password</label>
                                    <input type="password" class="form-control mb-2" name="password">
                                </div>

                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if(auth()->user()->role == 3)
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form role="form" id="update-hte" action="">
                            @csrf
                            
                            <input type="hidden" class="form-control" name="id" value="{{ auth()->user()->HTE->id }}" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-sm">Personal Information</p>

                                    <label for="">Name</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->HTE->name }}" name="name" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->HTE->address }}" name="address" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->HTE->contact_number }}" name="contact_number" required>

                                    <label for="">Contact Person</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->HTE->contact_person }}" name="contact_person" required>

                                    <label for="">New Profile Picture</label>
                                    <input type="file" name="photo" class="form-control mb-2" id="hte-photo" onchange="createHTEProfilePhoto(this)">
                                        
                                    <center>
                                        <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded-circle" id="create-hte-profile-photo" style="width: 150px; height: auto">
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control mb-2" value="{{ auth()->user()->email }}" name="email" required>

                                    <label for="">Change Password</label>
                                    <input type="password" class="form-control mb-2" name="password">

                                    <label for="">Number of Interns Needed</label>
                                    <input type="number" class="form-control mb-2" value="{{ auth()->user()->HTE->slot }}" name="slot" required>

                                </div>

                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                    </div>

        
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Memorandum of Agreements</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                                        No.
                                    </th>
                                    
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        File
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               @php
                                   $count = 0;
                               @endphp
                               @foreach ($moa as $moa)
                                    @php
                                        $count += 1;
                                    @endphp
                                <tr>
                                 <td><p class="text-xs font-weight-bold mb-0 ms-4">{{ $count }}</p></td>   
                                    <td id="{{ $moa->id }}" class="">
                                        <a href="{{ asset('storage/MOA/'.$moa->file) }}" class="" target="_blank" data-bs-toggle="tooltip">
                                            <p class="text-xs font-weight-bold mb-0 ms-4"><i class="fa-solid fa-note-sticky text-lg me-2"></i>{{ $moa->description }}</p>
                                        </a>
                                    </td>
                                    <td class="">
                                        <p class="text-xs font-weight-bold mb-0 ms-4">{{ date('F d, Y | h:i A', strtotime($moa->created_at)) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

          
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Letter of Request for Termination</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                                        No.
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        File
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               @php
                                   $count = 0;
                               @endphp
                               @foreach ($pull_out as $po)
                                    @php
                                        $count += 1;
                                    @endphp
                                <tr>
                                 <td><p class="text-xs font-weight-bold mb-0 ms-4">{{ $count }}</p></td>   
                                    <td id="{{ $po->id }}" class="">
                                        <a href="{{ asset('storage/termination/'.$po->file) }}" class="" target="_blank" data-bs-toggle="tooltip">
                                            <p class="text-xs font-weight-bold mb-0 ms-4"><i class="fa-solid fa-note-sticky text-lg me-2"></i>{{ $po->description }}</p>
                                        </a>
                                    </td>
                                    <td class="">
                                        <p class="text-xs font-weight-bold mb-0 ms-4">{{ date('F d, Y | h:i A', strtotime($po->created_at)) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                    
                        <div class="card">
                        <div class="card-header pb-0 px-3">
                            <h6 class="mb-0"><i class="fa-solid fa-newspaper"></i> News and Updates</h6>
                        </div>
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                            @foreach ($news as $nw)
                            
                            <li class="list-group-item border-0 d-flex p-4 mb-4 bg-gray-100 border-radius-lg" data-value="{{ $nw->id }}">
                                <div class="d-flex flex-column">
                                    <div class="align-items-center">
                                        <a class="mb-4">
                                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.auth()->user()->HTE->photo) }}" class="mb-2" alt="...">
                                            <span class="ms-3 sidebar-text fw-bolder text-sm mb-3">
                                                {{ auth()->user()->HTE->name }}
                                            </span>
                                        </a>
                                    </div>
                                <span class="text-dark font-weight-bold text-xs mt-2 mb-3">{{ $nw->description }}</span>
                                @if($nw->photo != null)
                                    <img style="width: 250px; height: auto; border-radius: 10px;" src="{{ asset('storage/post/'.$nw->photo) }}" class="mb-2" alt="...">
                                @endif
                                <div class="mb-2 text-xs mt-3">{{ date('h:i a | M d, Y', strtotime($nw->created_at)) }}</div>
                                </div>
                                <div class="ms-auto text-end">
                                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" id="delete-post"><i class="far fa-trash-alt me-2"></i></a>
                                </div>
                            </li>
                            @endforeach
                            </ul>
                        </div>
                        </div>
                   

                    @endif

                    @if(auth()->user()->role == 4)
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form role="form" id="update-dean" action="">
                            @csrf
                            
                            <input type="hidden" class="form-control" name="id" value="{{ auth()->user()->Deans->id }}" required>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-sm">Personal Information</p>

                                    <label for="">Name</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->Deans->name }}" name="name" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->Deans->address }}" name="address" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control mb-2" value="{{ auth()->user()->Deans->contact_number }}" name="contact_number" required>

                                    <label for="">New Profile Picture</label>
                                    <input type="file" name="photo" class="form-control mb-2" id="dean-photo" onchange="createDeanProfilePhoto(this)">
                                        
                                    <center>
                                        <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded-circle" id="create-dean-profile-photo" style="width: 150px; height: auto">
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control mb-2" value="{{ auth()->user()->email }}" name="email" required>

                                    <label for="">Change Password</label>
                                    <input type="password" class="form-control mb-2" name="password">
                                </div>

                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if(auth()->user()->role == 5)
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form role="form" id="update-intern" action="">
                            @csrf
                            
                            <input type="hidden" class="form-control" name="id" value="{{ auth()->user()->Intern->id }}" required>

                            <div class="row">

                                <div class="col-md-6">
                                    <p class="text-sm">Your Internship Details</p>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Student Identification Card</label>
                                        <input type="text" class="form-control" name="studentid" value="{{ auth()->user()->Intern->studentid }}" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Full Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->Intern->name }}" readonly>
                                    </div>
                                   
                                    <div class="flex flex-col mb-2">
                                        <label for="">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ auth()->user()->Intern->address }}" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Contact Number</label>
                                        <input type="text" class="form-control" name="contact_number" value="{{ auth()->user()->Intern->contact_number }}" readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="">Birth Date</label>
                                            <input type="date" class="form-control" name="birthdate" value="{{ auth()->user()->Intern->birthdate }}" readonly>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="">Gender</label>
                                            <select name="gender" id="" class="form-select" disabled>
                                                <option value="M" @if(auth()->user()->Intern->gender == "M") selected @endif>Male</option>
                                                <option value="F" @if(auth()->user()->Intern->gender == "F") selected @endif>Female</option>
                                                <option value="P" @if(auth()->user()->Intern->gender == "P") selected @endif>Prefer Not to Say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Course/Program</label>
                                        <input type="text" class="form-control" name="course" value="BS in Information Technology" readonly>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Major</label>
                                          <select name="major" id="" class="form-select" disabled>
                                            <option value="">Select...</option>
                                              <option value="P" @if(auth()->user()->Intern->major == "P") selected @endif>Programming</option>
                                              <option value="N" @if(auth()->user()->Intern->major == "N") selected @endif>Networking</option>
                                          </select>
                                    </div>
                                    <div class="flex flex-col mb-2">
                                        <label for="">Academic Year</label>
                                        <select class="form-select fmxw-200 d-md-inline" name="year" aria-label="Message select example 2" disabled>
                                            <option value="">Select...</option>
                                            @php $count  = range(1,15); @endphp
                                            @php $from = 2023; @endphp
                                            @php $to = 2024; @endphp
                                            @foreach($count as $cnt)
                                                <option value="{{ $from }}-{{ $to }}" @if(auth()->user()->Intern->year == $from.'-'.$to) selected @endif>{{ $from }}-{{ $to }}</option>
                                                @php
                                                    $from += 1;
                                                    $to += 1;
                                                @endphp
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex flex-col mb-2">
                                        <label for="">HTE/Company</label>
                                          <select name="hte" id="" class="form-select" @if(auth()->user()->Intern->training_status == 0 || auth()->user()->Intern->training_status == 1 || auth()->user()->Intern->training_status == 2 ) @else disabled @endif>
                                            <option value="">Select...</option>
                                              @foreach ($hte as $hte)
                                                    <option value="{{ $hte->id }}" @if(auth()->user()->Intern->hte == $hte->id) selected @endif>{{ $hte->name }}</option>
                                              @endforeach
                                          </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <p class="text-sm">Account Information</p>
                                    <div class="flex flex-col mb-3">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="" aria-label="Email" required>
                                        @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <label for="">Change Password</label>
                                        <input type="password" name="password" class="form-control" aria-label="Password" id="password" placeholder="">
                                        @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <label for="" class="mt-2">New Profile Picture</label>
                                            <input type="file" name="photo" class="form-control mb-2" id="intern-photo" onchange="createInternProfilePhoto(this)">
                                            <label for="" class="mt-2">New Profile Picture</label>
                                            <center>
                                                <img src="{{ asset('storage/icon/profile-placeholder.jpg') }}" alt="" class="mt-4 img-fluid rounded" id="create-intern-profile-photo" style="width: 200px; height: auto">
                                            </center>
                                        </div>

                                        <div class="col-md-12 text-center mt-4">
                                            <label for="" class="mt-2">Student ORF for Verification</label>
                                            <center>
                                                <img src="{{ asset('storage/valid-id/'.auth()->user()->Intern->valid_id) }}" alt="" class="mt-4 img-fluid rounded" id="create-intern-valid-id" style="width: 200px; height: auto">
                                            </center>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </form>
                    </div>
                    @endif
        </div>
    </div>
</div>
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
    const input1 = document.querySelector('#admin-photo');
    const input2 = document.querySelector('#coordinator-photo');
    const input3 = document.querySelector('#hte-photo');
    const input4 = document.querySelector('#dean-photo');
    const input5 = document.querySelector('#intern-photo');

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

    input3.addEventListener('change', async (e) => {
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

    input4.addEventListener('change', async (e) => {
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

    input5.addEventListener('change', async (e) => {
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