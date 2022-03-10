@extends('layouts.app')

@section('content')
  
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
        </h1>
    </div>
    <form action="/edit/info/{{ $user->id }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xl-6">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <!-- username -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Имя</label>
                                <input type="text" name="name" id="simpleinput" class="form-control" value="{{ ($user->name)?? '' }}">
                            </div>

                            <!-- title -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Место работы</label>
                                <input type="text" name="job" id="simpleinput" class="form-control" value="{{ ($user->profile->job)?? '' }}">
                            </div>

                            <!-- tel -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Номер телефона</label>
                                <input type="text" name="phone" id="simpleinput" class="form-control" value="{{ ($user->profile->phone)?? '' }}">
                            </div>

                            <!-- address -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Адрес</label>
                                <input type="text" name="address" id="simpleinput" class="form-control" value="{{ ($user->profile->address)?? '' }}">
                            </div>

                            <!-- vk -->
                            <div class="form-group">
                                    <label class="form-label" for="simpleinput">VK</label>
                                    <input type="text" name="vk" id="simpleinput" class="form-control" value="{{ ($user->profile->vk)?? '' }}">
                            </div>

                            <!-- Telegram -->
                            <div class="form-group">
                                    <label class="form-label" for="simpleinput">Telegram</label>
                                    <input type="text" name="telegram" id="simpleinput" class="form-control" value="{{ ($user->profile->telegram)?? '' }}">
                            </div>
                            
                            <!-- Instagram -->
                            <div class="form-group">
                                    <label class="form-label" for="simpleinput">Instagram</label>
                                    <input type="text" name="instagram" id="simpleinput" class="form-control" value="{{ ($user->profile->instagram)?? '' }}">
                            </div>

                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Редактировать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection