<link rel="stylesheet" href="{{ asset('css/import.css') }}">
<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a id="room-number-display" class="simple-text logo-normal">{{ __('Room Temperatures') }}</a>
        </div>
        {{--        Translate button--}}
        <div class="d-flex p-2 min-h-screen text-light sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                @include('partials/language_switcher')
            </div>
        </div>
        <div class="d-flex p-2 min-h-screen text-light sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <?php
                    $outsideTemperatures = \App\Models\OutsideTemperature::all()->sortByDesc('time')->first();
                    echo '<span style="color:white"> Middelburg: </span>';
                    echo '<img id="weatherIcon" style="width: 1rem; filter: invert(1); vertical-align: baseline;" src="asset("images")/iconen-weerlive/'.$outsideTemperatures->image.'.svg">';
                    echo '<span style="color: white">'.$outsideTemperatures->temperature.'</span>';
                    echo '<img id="celsiusIcon" style="width: 1rem; filter: invert(1); vertical-align: top" src="asset("images")/iconen-weerlive/celsius.svg">';
                ?>
                <script>
                    document.getElementById('weatherIcon').src = '{{asset("images")}}/iconen-weerlive/{{$outsideTemperatures->image}}.svg';
                    document.getElementById('celsiusIcon').src = '{{asset("images")}}/iconen-weerlive/celsius.svg';
                </script>

            </div>
        </div>
        <ul class="nav">
            @if($pageSlug !== 'import')
                <form style="padding-left: 20px">
                    <input type="date" id="start" name="trip-start" class="btn2">
                    <script>
                        window.onload = function () {
                            document.getElementById('start').valueAsDate = new Date();
                        }
                    </script>
                </form>
                @foreach($roomsToSwitch as $room)
                    @if($room->room_number !== '212')
                            <li class="rooms" id="RC{{$room->room_number}}">
                                <a>
                                    <i class="tim-icons icon-app"></i>
                                    <p>RC {{$room->room_number}}</p>
                                </a>
                            </li>
                    @endif
                @endforeach
            @endif
            @auth()
                <li @if ($pageSlug == 'profile') class="active " @endif>
                    <a href="{{ route('profile.edit')  }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('User Profile') }}</p>
                    </a>
                </li>
                <li @if ($pageSlug == 'notifications') class="active " @endif>
                    <a href="{{ route('import.roomTimes') }}">
                        <i class="tim-icons icon-cloud-upload-94"></i>
                        <p>{{ __('Import room data') }}</p>
                    </a>
                </li>
                    <li @if ($pageSlug == 'notifications') class="active " @endif>
                        <a href="{{ route('import.outsideTemperatureImport') }}">
                            <i class="tim-icons icon-cloud-upload-94"></i>
                            <p>{{ __('Import outside temperatures') }}</p>
                        </a>
                    </li>
            @endauth
        </ul>
    </div>
</div>

<script>
console.log(document.getElementById('start').value);
</script>

<script src="/black/js/room-selector.js"></script>
<script src="/black/js/fetchWeather.js"></script>
