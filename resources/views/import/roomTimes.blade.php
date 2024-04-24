
@extends('layouts.app', ['pageSlug' => 'import'])

@section('content')
    <div>
        @auth()
            <form action="{{route('import.roomTimes')}}" method="POST" enctype="multipart/form-data" name="importForm" >
                @csrf
                <div>
                    <h1> {{__('Import file with room temperatures data')}}</h1>
                    <input type="file" name="room_info" required class="btn3">
                    <br><br>
                    <div>
                        <label for="set_room_id" class="lb">{{__('Select room to import data to...')}} </label>
                        <input type="text" id="set_room_id" name="set_room" placeholder="RCXXX" required class="btn1">
                    </div>
                    <br>
                        <button type="submit" class="btn2 welcome-button">{{__('Import')}}</button>
                    <br>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }} <br>
                            <a href="{{route('home')}}">{{__('Go back to the dashboard')}}</a>
                        </div>
                        @endif
                </div>

            </form>
        @endauth
    </div>
@endsection

