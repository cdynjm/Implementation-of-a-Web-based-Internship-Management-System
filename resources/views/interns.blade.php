

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
            <input type="text" class="form-control" id="search-intern" placeholder="Search">
        </div>
        <div class="col-md-4 mb-4">
            
        </div>
    
        @if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4)

        <div class="col-md-3 mb-xl-0 mb-4">
            <a href="{{ route('submit-requirements') }}">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Submit Requirements</p>
                        <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                        @php $count = 0; @endphp
                         @foreach ($interns as $int)
                            @if($int->status == 1)
                                @if($int->training_status == null || $int->training_status == 1) @php $count += 1; @endphp @endif
                            @endif
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
                        Current
                    </p>
                </div>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3 mb-xl-0 mb-4">
            <a href="{{ route('to-apply') }}">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">For Application</p>
                        <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                        @php $count = 0; @endphp
                         @foreach ($interns as $int)
                            @if($int->training_status == 2 || $int->training_status == 3) @php $count += 1; @endphp @endif
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
                        Current
                    </p>
                </div>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3 mb-xl-0 mb-4">
            <a href="{{ route('on-training') }}">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">On Training</p>
                        <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                        @php $count = 0; @endphp
                         @foreach ($interns as $int)
                            @if($int->training_status == 4) @php $count += 1; @endphp @endif
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
                        Current
                    </p>
                </div>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3 mb-xl-0 mb-4">
            <a href="{{ route('completed') }}">
            <div class="card">
                <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed</p>
                        <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                        @php $count = 0; @endphp
                         @foreach ($interns as $int)
                            @if($int->training_status == 5) @php $count += 1; @endphp @endif
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
                        Current
                    </p>
                </div>
                </div>
            </div>
            </a>
        </div>

        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-danger">Pending Accounts</h5>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @include('table.pending-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            @if(auth()->user()->role == 2)
                                <h5 class="mb-2 text-sm text-info">Validated Accounts (Your Interns)</h5>
                            @elseif(auth()->user()->role == 3)
                                <h5 class="mb-2 text-sm text-info">Your Interns</h5>
                            @else
                                <h5 class="mb-2 text-sm text-info">Validated Accounts</h5>
                            @endif
                           
                        </div>
                        
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @include('table.validated-table')
                    </div>
                </div>
            </div>
        </div>
   
  </div>
  
  @endsection
