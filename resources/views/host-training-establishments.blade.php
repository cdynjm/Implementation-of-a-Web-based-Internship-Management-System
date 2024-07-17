@extends('components.modals.hte-modal')
@extends('components.modals.edit.update-hte-modal')

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
                            <h5 class="mb-0 text-sm">Host Training Establishments</h5>
                        </div>
                        @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                        <a href="#" class="btn bg-gradient-info btn-sm mb-0" id="create-hte" type="button">+&nbsp; Add</a>
                        @endif
                    </div>
                    <a href="{{ route('print-all') }}" class="mb-0 text-sm" type="button"><i class="fa-solid fa-print text-sm me-1"></i> Print</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No.
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        HTE/Company Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contact Person
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contact Number
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                         Remaining Slots
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $cnt = 1; @endphp
                                @foreach ($hte as $hte)
                                <tr>
                                    
                                    <td id="{{ $hte->id }}" hidden></td>
                                    <td name="{{ $hte->name }}" hidden></td>
                                    <td contact_person="{{ $hte->contact_person }}" hidden></td>
                                    <td address="{{ $hte->address }}" hidden></td>
                                    <td contact_number="{{ $hte->contact_number }}" hidden></td>
                                    <td email="{{ $hte->User->email }}" hidden></td>
                                    <td status="{{ $hte->status }}" hidden></td>
                                    <td slot="{{ $hte->slot }}" hidden></td>

                                    <td class="text-center"><p>{{ $cnt }}</p></td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('storage/photo/'.$hte->photo) }}" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $hte->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $hte->User->email }}</p>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $hte->contact_person }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $hte->address }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $hte->contact_number }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($hte->status == 1)
                                            @php
                                                $count = 0;
                                                $total = 0;
                                            @endphp
                                            @foreach ($intern as $int)
                                                @if($int->hte == $hte->id)
                                                @php
                                                    $count += 1;
                                                @endphp
                                                @endif
                                            @endforeach
                                            @php
                                                $total = $hte->slot - $count;
                                            @endphp
                                            <p class="text-xs font-weight-bolder mb-0">{{ $total }}</p>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($hte->status == 1)
                                            <p class="text-xs font-weight-bold text-success mb-0">Active</p>
                                        @endif
                                        @if($hte->status == 0)
                                            <p class="text-xs font-weight-bold text-danger mb-0">Inactive</p>
                                        @endif
                                    </td>
                                    @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                    <td class="text-center">
                                        <form action="{{ route('view-hte') }}" class="d-inline" method="GET">
                                            @csrf
                                            <input type="hidden" class="form-control" value="{{ $hte->id }}" name="id">
                                            <button class="me-2" style="border: none; background: transparent;" data-bs-toggle="tooltip" title="View">
                                                <i class="fas fa-eye text-secondary"></i>
                                            </button>
                                        </form>
                                        <a href="{{ url('ims-chatbox/'.$hte->User->id) }}" class="me-2" data-bs-toggle="tooltip" title="Chat">
                                            <i class="fa-solid fa-message text-secondary"></i>
                                        </a>
                                        <a href="#" class="me-2" data-bs-toggle="tooltip" id="edit-hte" title="Edit">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <!--
                                        <a href="#" class="" data-bs-toggle="tooltip" id="delete-hte" title="Delete">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </a> -->
                                    </td>
                                    @endif
                                </tr>
                                    @php $cnt += 1; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  @endsection
