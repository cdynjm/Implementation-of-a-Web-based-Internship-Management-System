<table class="table align-items-center mb-0" id="pending-intern-result">
    <thead>
        <tr>
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
        @foreach ($pending as $int)
            @if($int->status == 0)
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
        @endforeach
    </tbody>
</table>