@extends('components.modals.dean-modal')
@extends('components.modals.edit.update-dean-modal')

@extends('layouts.user_type.auth')

@section('content')

  <div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Dean</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($deans as $dn)
                                <tr>
                                   
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('storage/photo/'.$dn->photo) }}" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $dn->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $dn->email }}</p>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        
                                        <a href="{{ url('ims-chatbox/'.$dn->id) }}" class="me-2" data-bs-toggle="tooltip" title="Chat">
                                            <i class="fa-solid fa-message text-secondary"></i>
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
    </div>
  </div>
  
  @endsection
