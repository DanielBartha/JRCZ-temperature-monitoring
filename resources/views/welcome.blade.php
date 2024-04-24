@extends('layouts.appwelcome', ['pageSlug' => 'dashboard'])
@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <img src="{{ asset('black') }}/img/jrczlogo.svg" class="img-fluid" style="filter: brightness(10);" alt="JRCZ logo">
                        <h1 class="text-white" style="margin-top: 3vw">{{ __('Welcome to the JRCZ temperature monitor!') }}</h1>
                        <p class="text-lead text-light">
                            {{ __('In this application you can monitor temperatures of JRCZ rooms.') }}
                        </p>
                        <p class="text-lead text-light">
                            {{ __('In order to access the dashboard with additional permissions, you need to login first.') }}
                        </p>
                        <br>
                        <a href="{{ route('home') }}" class="nav-link">
                            <button class="welcome-button">
                                <i class="tim-icons icon-chart-pie-36"></i> {{ __('Go to the dashboard') }}
                            </button>
                        </a>
                        <a href="{{ route('login') }}" class="nav-link">
                            <button class="welcome-button">
                                <i class="tim-icons icon-single-02"></i> {{ __('Login') }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
