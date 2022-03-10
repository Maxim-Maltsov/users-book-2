@extends('layouts.app')

@section('content')

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-sun'></i> Установить статус
        </h1>

    </div>
    
    <form action="/edit/status/{{ $user->id }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Установка текущего статуса</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- status -->
                                    <div class="form-group">
                                        <label class="form-label" for="example-select">Выберите статус</label>
                                        <select class="form-control" name="status" id="example-select">
                                            
                                            @foreach ($statuses as $key => $status)
                                                <option {{ $key }}  {{ ($userCurrentStatus == $key)? 'selected' : '' }} value="{{ $key }}" > {{ $status }} </option>
                                            @endforeach

                                        </select>
                                    </div>
  
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Изменить статус</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>

@endsection