@extends('layouts.app')

@section('content')
  
    @if (session('message'))
        <div class="alert alert-{{ session('message-type') }}">
            <strong>Уведомление!</strong>{{ session('message') }}
        </div>
    @endif

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-users'></i> Список пользователей
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">

            @if ( Auth::user()->role == 'admin' )
                <a class="btn btn-success" href="/create-user">Добавить</a>
            @endif

            <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                    <label class="btn btn-default active">
                        <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="js-contacts">
        
        @foreach ($users as $user)
            <div class="col-xl-4">
                <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="oliver kopyov">
                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                        <div class="d-flex flex-row align-items-center">
                            <span class="status status-success mr-3">
                                <span class="rounded-circle profile-image d-block " style="background-image:url({{ ($user->profile->avatar)?? '' }}); background-size: cover;"></span>
                            </span>
                            <div class="info-card-text flex-1">

                                <a href="#" class="fs-xl text-truncate text-truncate-lg text-info"> {{ $user->name }} </a>
                                
                                <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                    
                                @if ( Auth::user()->role == 'admin' || $user->id == Auth::id())
                                    <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                    <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                @endif
                                   
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="edit/info/{{ $user->id }}">
                                        <i class="fa fa-edit"></i>
                                    Редактировать</a>
                                    <a class="dropdown-item" href="edit/security/{{ $user->id }}">
                                        <i class="fa fa-lock"></i>
                                    Безопасность</a>
                                    <a class="dropdown-item" href="edit/status/{{ $user->id }}">
                                        <i class="fa fa-sun"></i>
                                    Установить статус</a>
                                    <a class="dropdown-item" href="edit/avatar/{{ $user->id }}">
                                        <i class="fa fa-camera"></i>
                                        Загрузить аватар
                                    </a>
                                    <a href="edit/delete-user/{{ $user->id }}" class="dropdown-item" onclick="return confirm('Вы уверены?');">
                                        <i class="fa fa-window-close"></i>
                                        Удалить
                                    </a>

                                    {{-- <a href="edit/delete-user/{{ $user->id }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('delete-user-form').submit(); return confirm('Вы уверены?');">
                                        <i class="fa fa-window-close"></i>
                                        Удалить
                                    </a>

                                    <form id="delete-user-form" action="edit/delete-user/{{ $user->id }}" method="POST" style="display: none;">
                                        @csrf
                                    </form> --}}


                                </div>
                                <span class="text-truncate text-truncate-xl"> {{ ($user->profile->job)?? '' }} </span>
                            </div>
                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                <span class="collapsed-hidden">+</span>
                                <span class="collapsed-reveal">-</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 collapse show">
                        <div class="p-3">
                            <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i> {{ ($user->profile->phone)?? '' }} </a>
                            <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i> {{ $user->email }} </a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i> {{ ($user->profile->address)?? '' }} </address>
                            <div class="d-flex flex-row">
                                <a href=" javascript:void(0); {{ ($user->profile->vk)?? '' }} " class="mr-2 fs-xxl" style="color:#4680C2">
                                    <i class="fab fa-vk"></i>
                                </a>
                                <a href="javascript:void(0); {{ ($user->profile->telegram)?? '' }} " class="mr-2 fs-xxl" style="color:#38A1F3">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a href="javascript:void(0); {{ ($user->profile->instagram)?? '' }} " class="mr-2 fs-xxl" style="color:#E1306C">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="my-3">
        {{ $users->links() }}
    </div>

@endsection
