@extends('components.modals.moa-modal')
@extends('components.modals.pullout-modal')
@extends('layouts.user_type.auth')

@section('content')

  <div>
    <div class="row">
    @if(auth()->user()->role != 5)
    <div class="col-md-4 mb-4">
        @if(empty(Session::get('year')))
            <label for="" class="text-danger text-sm fw-normal">Please Select Academic Year to Display Intern Records</label>
        @endif
            <select class="form-select fmxw-200 d-md-inline text-secondary" aria-label="Message select example 2" id="select-year">
            <option value="">Select Academic Year...</option>
            @php $count  = range(1,15); @endphp
            @php $from = 2023; @endphp
            @php $to = 2024; @endphp
            @foreach($count as $cnt)
                <option value="{{ $from }}-{{ $to }}" @if(Session::get('year') == $from.'-'.$to) selected @endif>{{ $from }}-{{ $to }}</option>
                @php
                    $from += 1;
                    $to += 1;
                @endphp
            @endforeach
        </select>
    </div>
    @endif

        @php
            $id = 0;
        @endphp
        @foreach ($hte as $hte)
        @php
            $id = $hte->id;
        @endphp
        <input type="hidden" value="{{ $hte->id }}" class="form-control" id="hteid">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="align-items-center text-center">
                        <a class="mt-3">
                            
                            @if($hte->photo == null)
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/icon/profile-placeholder.jpg') }}" class="ms-0 mb-4 mt-2" alt="...">
                            @else
                            <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.$hte->photo) }}" class="ms-0 mb-4 mt-2" alt="...">
                            @endif
                            <span class="ms-3 sidebar-text fw-bolder fs-4 mb-3">
                                {{ $hte->name }}
                            </span>

                        </a>
                        <h5 class="fw-bolder text-sm"><i class="fa-solid fa-user me-1"></i> HTE/Company</h5> 
                            </div>
                        </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-sm">Personal Information</p>

                                <label for="">Name</label>
                                <input type="text" class="form-control mb-2 bg-white" value="{{ $hte->name }}" name="name" readonly>

                                <label for="">Address</label>
                                <input type="text" class="form-control mb-2 bg-white" value="{{ $hte->address }}" name="address" readonly>

                                <label for="">Contact Number</label>
                                <input type="text" class="form-control mb-2 bg-white" value="{{ $hte->contact_number }}" name="contact_number" readonly>

                            </div>
                            <div class="col-md-6">
                                <p class="text-sm">Account Information</p>

                                <label for="">Email</label>
                                <input type="email" class="form-control mb-2 bg-white" value="{{ $hte->User->email }}" name="email" readonly>
                            
                                <label for="">Number of Interns Needed</label>
                                <input type="number" class="form-control mb-2 bg-white" value="{{ $hte->slot }}" name="slot" readonly>

                                <label for="">Contact Person</label>
                                <input type="text" class="form-control mb-2 bg-white" value="{{ $hte->contact_person }}" name="contact_person" readonly>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-12 mt-2">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-dark">Interns</h5>                           
                        </div>
                        <a href="{{ route('print-interns', ['id' => $id]) }}" class="mb-0 text-sm" type="button"><i class="fa-solid fa-print text-sm me-1"></i> Print</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Student ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Coordinator
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Major
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Academic Year
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $cnt = 1; @endphp
                                @foreach ($interns as $int)
                                   
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bolder mb-0">{{ $int->studentid }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset('storage/photo/'.$int->photo) }}" class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $int->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $int->User->email }}</p>
                                                </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $int->Coordinator->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if($int->major == 'P')
                                                    <p class="text-xs font-weight-bold mb-0">Programming</p>
                                                @endif
                                                @if($int->major == 'N')
                                                    <p class="text-xs font-weight-bold mb-0">Networking</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $int->year }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if($int->training_status == null || $int->training_status == 1)
                                                    <span class="text-sm text-danger fw-bolder text-capitalize">Submit Requirements</span>
                                                @endif
                                                @if($int->training_status == 2 || $int->training_status == 3)
                                                    <span class="text-sm text-warning fw-bolder text-capitalize">For Application</span>
                                                @endif
                                                @if($int->training_status == 4)
                                                    <span class="text-sm text-info fw-bolder text-capitalize">On Training</span>
                                                @endif
                                                @if($int->training_status == 5)
                                                    <span class="text-sm text-success fw-bolder text-capitalize">Completed</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ url('ims-chatbox/'.$int->User->id) }}" class="btn border-none shadow-none text-sm p-0 mt-4 ms-2" data-bs-toggle="tooltip" title="Chat">
                                                    <i class="fa-solid fa-message"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @php $cnt += 1; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Memorandum of Agreements</h5>
                        </div>
                        @if(auth()->user()->role == 2)
                            <a href="#" class="btn bg-gradient-info btn-sm mb-0" id="create-moa" type="button">+&nbsp; Add</a>
                        @endif
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
                                        Date Uploaded
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
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
                                    <td class="">
                                        <a href="#" class="" data-bs-toggle="tooltip" id="delete-moa">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Letter of Request for Termination</h5>
                        </div>
                        @if(auth()->user()->role == 2)
                            <a href="#" class="btn bg-gradient-info btn-sm mb-0" id="create-termination" type="button">+&nbsp; Add</a>
                        @endif
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
                                        Date Uploaded
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
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
                                    <td class="">
                                        <a href="#" class="" data-bs-toggle="tooltip" id="delete-termination">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-md-12 mt-2">
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
                                    <img style="width: 50px; height: 50px; border-radius: 50px;" src="{{ asset('storage/photo/'.$nw->HTE->photo) }}" class="mb-2" alt="...">
                                    <span class="ms-3 sidebar-text fw-bolder text-sm mb-3">
                                        {{ $nw->HTE->name }}
                                    </span>
                                </a>
                            </div>
                        <span class="text-dark font-weight-bold text-xs mt-2 mb-3">{{ $nw->description }}</span>
                        @if($nw->photo != null)
                            <img style="width: 250px; height: auto; border-radius: 10px;" src="{{ asset('storage/post/'.$nw->photo) }}" class="mb-2" alt="...">
                        @endif
                        <div class="mb-2 text-xs mt-3">{{ date('h:i a | M d, Y', strtotime($nw->created_at)) }}</div>
                        </div>
                    </li>
                    @endforeach
                    </ul>
                </div>
                </div>
            </div>
    </div>
</div>
@endsection
