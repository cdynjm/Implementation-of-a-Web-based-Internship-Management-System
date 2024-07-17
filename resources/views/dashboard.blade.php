@php
  use App\Models\Documents;
@endphp

@extends('components.modals.upload-pre-requirements')
@extends('components.modals.upload-post-requirements')
@extends('layouts.user_type.auth')

@section('content')
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
  <div class="row">
    @if(auth()->user()->role == 1 || auth()->user()->role == 4)
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('coordinators') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Coordinators</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_coordinators }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end mt-3">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa-solid fa-users-gear text-lg opacity-10"></i>
              </div>
            </div>
            <p class="mb-0 text-xs">
                Total Count
            </p>
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('host-training-establishments') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">HTE/Company</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_hte }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end mt-3">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa-solid fa-building text-lg opacity-10"></i>
              </div>
            </div>
            <p class="mb-0 text-xs">
                Total Count
            </p>
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('interns') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Interns</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_interns }}
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
            <div class="card">
                <div class="card-header pb-0 text-sm">
                  <form action="" id="create-announcements">
                  @csrf
                    <textarea name="news" id="" cols="30" rows="3" placeholder="Post Announcements..." class="form-control" required></textarea>
                    <div class="d-flex float-end">
                        <input type="file" accept=".jpg , .png, .jpeg" class="form-control mt-4 me-2" id="post-photo" name="photo">
                        <input type="submit" class="btn bg-gradient-info btn-sm mt-4 mb-0" value="Post">
                    </div>
                  </form>
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                  
                </div>
          </div>
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

    <div class="col-md-12 mt-4">
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
    @endif

    @if(auth()->user()->role == 2)
    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
      <a href="{{ route('host-training-establishments') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">HTE/Company</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_hte }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end mt-3">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa-solid fa-building text-lg opacity-10"></i>
              </div>
            </div>
            <p class="mb-0 text-xs">
                Total Count
            </p>
          </div>
        </div>
      </div>
      </a>
    </div>
    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('interns') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Interns</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_interns }}
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
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

    <div class="col-md-12 mt-4">
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
    @endif

    @if(auth()->user()->role == 3)

    
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('interns') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending Application</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_application }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end mt-3">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa-solid fa-user-graduate text-lg opacity-10"></i>
              </div>
            </div>
            <p class="mb-0 text-xs">
              Interns
            </p>
          </div>
        </div>
      </div>
      </a>
    </div>

    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('interns') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">On Training</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_training }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end mt-3">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa-solid fa-user-graduate text-lg opacity-10"></i>
              </div>
            </div>
            <p class="mb-0 text-xs">
                Interns
            </p>
          </div>
        </div>
      </div>
      </a>
    </div>

    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <a href="{{ route('interns') }}">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed</p>
                <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                  {{ $count_completed }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end mt-3">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="fa-solid fa-user-graduate text-lg opacity-10"></i>
              </div>
            </div>
            <p class="mb-0 text-xs">
              Interns
            </p>
          </div>
        </div>
      </div>
    </a>
    </div>

    <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header pb-0 text-sm">
                  <form action="" id="create-post">
                  @csrf
                    <textarea name="news" id="" cols="30" rows="3" placeholder="Post news and updates..." class="form-control" required></textarea>
                    <div class="d-flex float-end">
                        <input type="file" accept=".jpg , .png, .jpeg" class="form-control mt-4 me-2" id="post-photo" name="photo">
                        <input type="submit" class="btn bg-gradient-info btn-sm mt-4 mb-0" value="Post">
                    </div>
                  </form>
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                  
                </div>
          </div>
      </div>

    <div class="col-md-12 mt-4">
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
      </div>
    @endif


    @if(auth()->user()->role == 5)

    <h6 class="mt-0 mb-2 ms-1"><span class="fw-light text-sm">HTE: </span><span class="fw-bolder">@if(auth()->user()->Intern->hte != null) {{ auth()->user()->Intern->HTE->name }} @else <span class="text-sm text-danger">Please Select HTE in your profile</span> @endif</span></h6>
    <h6 class="mt-0 mb-2 ms-1"><span class="fw-light text-sm">Coordinator: </span><span class="fw-bolder">@if(auth()->user()->Intern->coordinator != null) {{ auth()->user()->Intern->Coordinator->name }} @else <span class="text-sm text-danger">Please wait for a coordinator to be assigned to you by the dean.</span> @endif</span></h6>
    @if(auth()->user()->Intern->status == 0)
      <p class="text-sm text-danger text-wrap">Notice: Your account is being validated. You will not be able to upload files until the OJT coordinator verifies your account.</p>
    @endif

    <div class="col-md-12 mb-4">
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
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

      <h6 class="mt-0 mb-2 ms-1">Internship Status</h6>

      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card 
          @if(auth()->user()->Intern->status == 1) 
          
            @if(auth()->user()->Intern->training_status == null || auth()->user()->Intern->training_status == 1 || auth()->user()->Intern->training_status == 2 || auth()->user()->Intern->training_status == 3 || auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
              bg-white
              @else
                bg-gray-300
            @endif

            @else
              bg-gray-300
          @endif">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Submit Requirements</p>
                  @if(auth()->user()->Intern->training_status == 2 || auth()->user()->Intern->training_status == 3 || auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-check fs-3 mt-2 text-success"></i>
                    </h5>
                    @else
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-minus fs-3 mt-2 text-danger"></i>
                    </h5>
                  @endif
                </div>
              </div>
              <div class="col-4 text-end mt-3">
                <div class="icon icon-shape bg-info shadow text-center rounded-circle">
                  <i class="fa-solid fa-arrow-right-long fs-3 opacity-10"></i>
                </div>
              </div>
                @if(auth()->user()->Intern->training_status == null)
                  <p class="mb-0 text-xs mt-2">
                    Pending
                  </p>
                @endif
                @if(auth()->user()->Intern->training_status == 1)
                  <p class="mb-0 text-xs mt-2">
                    Submitted for checking
                  </p>
                @endif
                @if(auth()->user()->Intern->training_status == 2 || auth()->user()->Intern->training_status == 3 || auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
                  <p class="mb-0 text-xs mt-2">
                    Done
                  </p>
                @endif
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card 
        @if(auth()->user()->Intern->status == 1) 
          
          @if(auth()->user()->Intern->training_status == 2 || auth()->user()->Intern->training_status == 3 || auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
            bg-white
            @else
            bg-gray-300
          @endif

          @else
            bg-gray-300
        @endif">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">For Application</p>
                  @if(auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-check fs-3 mt-2 text-success"></i>
                    </h5>
                    @else
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-minus fs-3 mt-2 text-danger"></i>
                    </h5>
                  @endif
                </div>
              </div>
              <div class="col-4 text-end mt-3">
                <div class="icon icon-shape bg-info shadow text-center rounded-circle">
                  <i class="fa-solid fa-arrow-right-long fs-3 opacity-10"></i>
                </div>
              </div>
             
              @if(auth()->user()->Intern->training_status == null || auth()->user()->Intern->training_status == 1 || auth()->user()->Intern->training_status == 2)
                  <p class="mb-0 text-xs mt-2">
                    Pending
                  </p>
                @endif
                @if(auth()->user()->Intern->training_status == 3)
                  <p class="mb-0 text-xs mt-2">
                    Application Sent
                  </p>
                @endif
                @if(auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
                  <p class="mb-0 text-xs mt-2">
                    Done
                  </p>
                @endif
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card 
        @if(auth()->user()->Intern->status == 1) 
          
          @if(auth()->user()->Intern->training_status == 4 || auth()->user()->Intern->training_status == 5)
            bg-white
            @else
            bg-gray-300
          @endif

          @else
            bg-gray-300
        @endif">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">On Training</p>
                  @if(auth()->user()->Intern->training_status == 5)
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-check fs-3 mt-2 text-success"></i>
                    </h5>
                    @else
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-minus fs-3 mt-2 text-danger"></i>
                    </h5>
                  @endif
                </div>
              </div>
              <div class="col-4 text-end mt-3">
                <div class="icon icon-shape bg-info shadow text-center rounded-circle">
                  <i class="fa-solid fa-arrow-right-long fs-3 opacity-10"></i>
                </div>
              </div>
              @if(auth()->user()->Intern->training_status == null || auth()->user()->Intern->training_status == 1 || auth()->user()->Intern->training_status == 2 || auth()->user()->Intern->training_status == 3)
                  <p class="mb-0 text-xs mt-2">
                    Pending
                  </p>
                @endif
              @if(auth()->user()->Intern->training_status == 4)
                  <p class="mb-0 text-xs mt-2">
                    On Going
                  </p>
                @endif
                @if(auth()->user()->Intern->training_status == 5)
                  <p class="mb-0 text-xs mt-2">
                    Done
                  </p>
                @endif
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card 
        @if(auth()->user()->Intern->status == 1) 
          
          @if(auth()->user()->Intern->training_status == 5)
            bg-white
          @else
            bg-gray-300
          @endif

          @else
            bg-gray-300
        @endif">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed</p>
                  @if(auth()->user()->Intern->training_status == 5)
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-check fs-3 mt-2 text-success"></i>
                    </h5>
                    @else
                    <h5 class="font-weight-bolder fs-4 mb-0 mt-1">
                      <i class="fa-solid fa-circle-minus fs-3 mt-2 text-danger"></i>
                    </h5>
                  @endif
                </div>
              </div>
              <div class="col-4 text-end mt-3">
                <div class="icon icon-shape bg-success shadow text-center rounded-circle">
                  <i class="fa-solid fa-check fs-3 opacity-10"></i>
                </div>
              </div>
              @if(auth()->user()->Intern->training_status == null || auth()->user()->Intern->training_status == 1 || auth()->user()->Intern->training_status == 2 || auth()->user()->Intern->training_status == 3 || auth()->user()->Intern->training_status == 4)
                  <p class="mb-0 text-xs mt-2">
                    Pending
                  </p>
                @endif
                @if(auth()->user()->Intern->training_status == 5)
                  <p class="mb-0 text-xs mt-2">
                    Done
                  </p>
                @endif
            </div>
          </div>
        </div>
      </div>

      @foreach ($comment as $cm)
      <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header pb-0 text-sm">
                <i class="fa-solid fa-flag text-danger me-2 text-sm"></i> Your submission/application has been declined: {{ $cm->comment }}
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                  
                </div>
          </div>
      </div>
      @endforeach

      @foreach ($termination as $tm)
      <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header pb-0 text-sm">
                <i class="fa-solid fa-flag text-danger me-2 text-sm"></i> You have been terminated from the HTE/company. Please select new HTE to apply for.
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                  
                </div>
          </div>
      </div>
      @endforeach

      <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Upload Pre-Deployment Requirements</h5>
                        </div>
                        @if(auth()->user()->Intern->status == 1 && auth()->user()->Intern->coordinator != null)
                          @if(auth()->user()->Intern->training_status == null)
                              <a href="#" class="btn bg-gradient-info text-capitalize btn-sm mb-0" id="upload-pre-requirements" type="button"><i class="fa-solid fa-cloud-arrow-up text-sm"></i>&nbsp; Upload</a>
                          @endif
                        @endif
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
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $doc)
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
                                        <td class="text-center">
                                            @if($doc->check_document == 1)
                                              <p class="text-xs mb-0 ms-4 text-success"><i class="fa-solid fa-check"></i></p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                        @if($doc->status == 0)
                                            <a href="#" class="" data-bs-toggle="tooltip" id="delete-document">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        @if(auth()->user()->Intern->training_status == null)
                          @if(Documents::where(['intern_id' => auth()->user()->Intern->id])->where(['type' => 1])->exists())
                            <div class="float-end me-4">
                                <button class="btn btn-sm text-capitalize bg-gradient-dark mt-4" id="submit-pre-documents">Submit</button>
                            </div>
                          @endif
                        @endif

                        @if(auth()->user()->Intern->training_status == 2)
                         
                            <div class="float-end me-4">
                                <input type="hidden" value="{{ auth()->user()->Intern->id }}" id="document-id" class="form-control">
                                <input type="hidden" value="dashboard" id="url-path" class="form-control">
                                <button class="btn btn-sm text-capitalize bg-gradient-dark mt-4" id="for-application">Apply</button>
                            </div>
                          
                        @endif
                                
                    </div>
                </div>
            </div>

        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0 text-sm">Upload Post-OJT Requirements</h5>
                        </div>
                        @if(auth()->user()->Intern->status == 1)
                          @if(auth()->user()->Intern->training_status == 4)
                              <a href="#" class="btn bg-gradient-info text-capitalize btn-sm mb-0" id="upload-post-requirements" type="button"><i class="fa-solid fa-cloud-arrow-up text-sm"></i>&nbsp; Upload</a>
                          @endif
                        @endif
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
                                        Action
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
                                        
                                        <td class="text-center">
                                        @if($doc->status == 0)
                                            <a href="#" class="" data-bs-toggle="tooltip" id="delete-document">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </a>
                                          @endif
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                                
                    </div>
                </div>
            </div>

      <div class="col-md-12 mt-4">
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
    @endif
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
    const input = document.querySelector('#post-photo');

    input.addEventListener('change', async (e) => {
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

  <script>
    window.onload = function() {
      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });


      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6

            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>
@endpush

