@extends('components.modals.coordinator-modal')
@extends('components.modals.edit.update-coordinator-modal')
@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Coordinators</h5>
                        </div>
                        @if(auth()->user()->role == 1)
                        <a href="#" class="btn bg-gradient-info btn-sm mb-0" id="create-coordinator" type="button">+&nbsp; Add</a>
                        @endif
                    </div>
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
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contact Number
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
                                @foreach ($coordinators as $cd)
                                <tr>
                                    
                                    <td id="{{ $cd->id }}" hidden></td>
                                    <td name="{{ $cd->name }}" hidden></td>
                                    <td address="{{ $cd->address }}" hidden></td>
                                    <td status="{{ $cd->status }}" hidden></td>
                                    <td contact_number="{{ $cd->contact_number }}" hidden></td>
                                    <td email="{{ $cd->User->email }}" hidden></td>

                                    <td class="text-center"><p>{{ $cnt }}</p></td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('storage/photo/'.$cd->photo) }}" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $cd->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $cd->User->email }}</p>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $cd->address }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $cd->contact_number }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($cd->status == 1)
                                            <p class="text-xs font-weight-bold text-success mb-0">Active</p>
                                        @endif
                                        @if($cd->status == 0)
                                            <p class="text-xs font-weight-bold text-danger mb-0">Inactive</p>
                                        @endif
                                    </td>
                                   
                                    <td class="text-center">
                                        @if(auth()->user()->role == 1)
                                        <a href="#" class="me-2" data-bs-toggle="tooltip" id="edit-coordinator" title="View">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        @endif
                                        <a href="{{ url('ims-chatbox/'.$cd->User->id) }}" class="me-2" data-bs-toggle="tooltip" title="Chat">
                                            <i class="fa-solid fa-message text-secondary"></i>
                                        </a>
                                        @if(auth()->user()->role == 1)
                                        <!--
                                        <a href="#" class="" data-bs-toggle="tooltip" id="delete-coordinator" title="Delete">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </a> -->
                                        @endif
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
    </div>
</div>
 
@endsection