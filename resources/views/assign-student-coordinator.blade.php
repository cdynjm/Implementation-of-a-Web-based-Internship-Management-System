

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
        <div class="col-md-4 mb-4">
            
        </div>
        <div class="col-md-4 mb-4">
            
        </div>

    @foreach ($coordinators as $cd)
        @php
            $count = 0;
        @endphp
        <div class="col-md-4 mb-xl-0 mb-4">
            <a>
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ $cd->name }}</p>
                        <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                            @foreach ($interns as $int)
                                @if($int->coordinator == $cd->id) @php $count += 1; @endphp @endif
                            @endforeach
                            {{ $count }}
                        </h5>
                    </div>
                    </div>
                    <div class="col-4 text-end mt-3">
                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                        <i class="fa-solid fa-user-graduate text-lg opacity-10"></i>
                    </div>
                    </div>
                    <p class="mb-0 text-xs">
                        Total Students
                    </p>
                </div>
                </div>
            </div>
            </a>
        </div>
    @endforeach

    <div class="col-12 mt-4">
        <div class="card mb-4">
        <form id="assign-intern-coordinator">
            @csrf
            <div class="card-header pb-0">
            <div class="row">
                <div class="col-md-6">
                    <input type="checkbox" id="check-all">
                    <label for="">Check All</label>
                </div>
                <div class="col-md-5">
                <select class="form-select fmxw-200 d-md-inline text-secondary" aria-label="Message select example 2" name="coordinator" required>
                    <option value="">Select Coordinator...</option>
                    @foreach ($coordinators as $cd)
                        <option value="{{ $cd->id }}">{{ $cd->name }}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-md-1">
                    <div class="d-flex justify-content-center">
                        <input class="btn bg-gradient-secondary me-2" type="submit" value="Assign">
                    </div>
                </div>
            </div>
               
                
                <div class="d-flex flex-row justify-content-between">
                        <h5 class="mb-2 text-sm text-info">Students</h5>
                   
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="assign-intern-table">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                                    Checkbox
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Student ID
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Name
                                </th>
                               
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Major
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Academic Year
                                </th>
                                
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $cnt = 1; @endphp
                            @foreach ($interns as $int)
                                @if($int->coordinator == null)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" value="{{ $int->id }}" name="intern[]">
                                        </td>
                                        </form>
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
                                
                                        <td class="text-center" id="{{ $int->id }}">
                                            <form action="{{ route('view-intern') }}" class="d-inline" method="GET">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>
    </div>
   
  </div>
  
  @endsection
