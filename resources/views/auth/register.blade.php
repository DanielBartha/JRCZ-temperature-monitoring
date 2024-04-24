@extends('layouts.appwelcome', ['class' => 'register-page', 'page' => __('Register Page'), 'contentClass' => 'register-page', 'pageSlug' => ''])

@section('content')
    @if(Auth::id() === 1)
        <div class="row">
            <div class="col-md-7 ml-auto mr-auto">
                <div class="card card-register" style="background: #27293d">
                    <div class="card-header">
                        <img class="card-img" style="top: 0%; z-index: 0;" src="{{ asset('black') }}/img/card-primary.png" alt="Card image">
                        <h4 class="card-title">{{ __('Register') }}</h4>
                    </div>
                    <form class="form" method="post" action="{{ route('register') }}">
                        @csrf

                        <div class="card-body">
                            <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-single-02 mr-3"></i>
                                    </div>
                                </div>
                                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-email-85 mr-3"></i>
                                    </div>
                                </div>
                                <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-lock-circle mr-3"></i>
                                    </div>
                                </div>
                                <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-lock-circle mr-3"></i>
                                    </div>
                                </div>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Get Started') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-7 ml-auto mr-auto">
                <div class="card card-register card-white">
                    <div class="card-body">
                        <h1 class="text-center" style="color:black;">You are not eligible for registering new users!</h1>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('home')}}"><button class="btn btn-primary btn-round btn-lg">{{ __('Go back') }}</button></a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
