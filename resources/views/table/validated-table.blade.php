<table class="table align-items-center mb-0" id="validated-intern-result">
    <thead>
        <tr>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Student ID
            </th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Name
            </th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Coordinator
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
                    <td class="text-center">
                        @if(!empty($int->Coordinator->name))
                            <p class="text-xs font-weight-bold mb-0">{{ $int->Coordinator->name }}</p>
                        @else
                            <p class="text-xs font-weight-bold mb-0">-</p>
                        @endif
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
                        @if(auth()->user()->role == 2 || auth()->user()->role == 3)
                        @if($int->training_status == 4)
                            <button type="submit" id="terminate-intern" class="btn border-none shadow-none text-lg p-0 mt-3 ms-2" data-bs-toggle="tooltip" title="Pull Out">
                                <i class="fa-solid fa-user-xmark"></i>
                            </button>
                        @endif
                        @endif
                    </td>
                </tr>
            @php $cnt += 1; @endphp
            @endif
        @endforeach
    </tbody>
</table>