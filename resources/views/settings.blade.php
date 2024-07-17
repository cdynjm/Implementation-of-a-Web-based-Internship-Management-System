@extends('layouts.user_type.auth')

@section('content')

  <div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header pb-0 d-inline">
                    <span class="form-check form-switch ms-auto mt-2">
                        <span class="ms-2 fw-bold text-sm">Intern Registration</span>
                        <input type="checkbox" class="form-check-input mt-1" id="registration"
                        @foreach ($status as $st)
                            @if($st->enable_registration == 1)
                                checked
                            @else

                            @endif
                        @endforeach>
                    </span>
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                  
                </div>
          </div>
        </div>
        </div>
  </div>
  
  @endsection
