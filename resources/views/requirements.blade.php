@extends('components.modals.requirement-modal')
@extends('components.modals.edit.update-requirement-modal')

@extends('layouts.user_type.auth')

@section('content')

  <div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Pre-Deployment | Paper Requirements</h5>
                        </div>
                        @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                        <a href="#" class="btn bg-gradient-info btn-sm mb-0" id="create-requirements" type="button">+&nbsp; Add</a>
                        @endif
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Requirements
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Type
                                    </th>
                                    @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($requirements as $req)
                                    @if($req->type == 1)
                                        <tr>
                                            <td id="{{ $req->id }}" hidden></td>
                                            <td description="{{ $req->description }}" hidden></td>
                                            <td type="{{ $req->type }}" hidden></td>
                                            <td category="{{ $req->category }}" hidden></td>

                                            <td class="">
                                                <p class="text-xs font-weight-bold mb-0 ms-4"><i class="fa-solid fa-note-sticky text-lg me-2"></i> {{ $req->description }}</p>
                                            </td>
                                            <td class="">
                                                <p class="text-xs font-weight-bold mb-0 ms-4">@if($req->category == 1) Required @endif @if($req->category == 2) Optional @endif</p>
                                            </td>
                                            @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                            <td class="text-center">
                                                <a href="#" class="me-2" data-bs-toggle="tooltip" id="edit-requirements">
                                                    <i class="fa-solid fa-file-pen text-secondary"></i>
                                                </a>
                                                <!--
                                                <a href="#" class="" data-bs-toggle="tooltip" id="delete-requirements">
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </a> -->
                                            </td>
                                            @endif
                                            
                                        </tr>
                                    @endif
                                  
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Post-OJT | Paper Requirements</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Requirements
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Type
                                    </th>
                                    @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($requirements as $req)
                                    @if($req->type == 2)
                                        <tr>
                                            <td id="{{ $req->id }}" hidden></td>
                                            <td description="{{ $req->description }}" hidden></td>
                                            <td type="{{ $req->type }}" hidden></td>
                                            <td category="{{ $req->category }}" hidden></td>

                                            <td class="">
                                                <p class="text-xs font-weight-bold mb-0 ms-4"><i class="fa-solid fa-note-sticky text-lg me-2"></i> {{ $req->description }}</p>
                                            </td>
                                            <td class="">
                                                <p class="text-xs font-weight-bold mb-0 ms-4">@if($req->category == 1) Required @endif @if($req->category == 2) Optional @endif</p>
                                            </td>
                                            @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                            <td class="text-center">
                                                <a href="#" class="me-2" data-bs-toggle="tooltip" id="edit-requirements">
                                                    <i class="fa-solid fa-file-pen text-secondary"></i>
                                                </a>
                                                <!--
                                                <a href="#" class="" data-bs-toggle="tooltip" id="delete-requirements">
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </a> -->
                                            </td>
                                            @endif
                                            
                                        </tr>
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
