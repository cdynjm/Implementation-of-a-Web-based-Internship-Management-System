@php
    
use Illuminate\Support\Facades\Auth;
use App\Models\ChMessage;

$chat_count = ChMessage::where(['to_id' => Auth::user()->id])->where(['seen' => 0])->count();

@endphp

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">CCSIT - IMS</a></li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar"> 
            
            <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <div class="input-group">
                
            </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
                <a href="{{ url('/logout')}}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                    <span class="d-sm-inline me-2">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->role == 1)
                        <img style="width: 30px; height: 30px; border-radius: 50px;" class="me-2" src="{{ asset('storage/photo/'.Auth::user()->photo) }}" class="ms-4" alt="...">
                    @endif
                    @if(auth()->user()->role == 2)
                        <img style="width: 30px; height: 30px; border-radius: 50px;" class="me-2" src="{{ asset('storage/photo/'.Auth::user()->Coordinator->photo) }}" class="ms-4" alt="...">
                    @endif
                    @if(auth()->user()->role == 3)
                        <img style="width: 30px; height: 30px; border-radius: 50px;" class="me-2" src="{{ asset('storage/photo/'.Auth::user()->HTE->photo) }}" class="ms-4" alt="...">
                    @endif
                    @if(auth()->user()->role == 5)
                        <img style="width: 30px; height: 30px; border-radius: 50px;" class="me-2" src="{{ asset('storage/photo/'.Auth::user()->Intern->photo) }}" class="ms-4" alt="...">
                    @endif
                </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
                </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center ms-3">
                <a href="{{ route('ims-chatbox') }}" class="nav-link text-body p-0" title="Chatbox">
                <i class="fa-solid fa-comment-dots"></i>
                <span class="position-absolute top-8 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $chat_count }}</span>
                </a>
            </li>
            
           
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->