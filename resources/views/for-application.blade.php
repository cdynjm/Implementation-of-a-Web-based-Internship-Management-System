

@extends('layouts.user_type.auth')

@section('content')

  <div>
    <div class="row">
        @if(empty(Session::get('year')))
            <label for="" class="text-danger text-sm fw-normal">Please Select Academic Year to Display Intern Records</label>
        @endif
        <div class="col-md-4 mb-4">
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
    <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-info">Pending Application</h5>
                        </div>
                        
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
                                        HTE/Company
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
                                    @if($int->status == 1)
                                        @if($int->training_status == 2)
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
                                                @if($int->hte != null)
                                                <p class="text-xs font-weight-bold mb-0">{{ $int->HTE->name }}</p>
                                                @else
                                                -
                                                @endif
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

                                                @foreach ($termination as $tm)
                                                    @if($tm->intern_id == $int->id)
                                                        <div class="text-xs text-danger fw-bold text-capitalize">Terminated</div>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('view-intern') }}" method="GET" class="d-inline">
                                                @csrf
                                                    <input type="hidden" class="form-control" value="{{ $int->id }}" name="id">
                                                    <button type="submit" class="btn border-none shadow-none text-sm p-0" data-bs-toggle="tooltip" title="View">
                                                        <i class="fa-regular fa-eye mt-4"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ url('ims-chatbox/'.$int->User->id) }}" class="btn border-none shadow-none text-sm p-0 mt-4 ms-2" data-bs-toggle="tooltip" title="Chat">
                                                    <i class="fa-solid fa-message"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @php $cnt += 1; @endphp
                                    @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  </div>
  
  @endsection
