@extends('users.app')


@section('content')
    <div class="conatiner-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">
                    Ride Booking
                </h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row p-0">
                        <div class="col-md-6 m-0">
                            <table class="table table-sm table-striped">
                                <tr>
                                    <th>Driver</th>
                                    <td>
                                        {{ $ride->driver->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        {{ $ride->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Booked
                                    </th>
                                    <td>
                                        {{ $ride->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Rate
                                    </th>
                                    <td>
                                        Rs. {{ $ride->track_ride->rate??$ride->driver->rate }} per KM
                                    </td>
                                </tr>

                                @if ($ride->track_ride)
                                <tr>
                                    <th>
                                        Distance
                                    </th>
                                    <td>
                                        {{ number_format($ride->track_ride->distance/1000,2) }} km
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <td>
                                        Rs. {{ $ride->track_ride->cost }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>
                                        Message
                                    </th>
                                    <td>
                                       {{$ride->message}}
                                    </td>
                                </tr>

                                @if ($ride->status == $ride::STATUS_PENDING)
                                    <tr>
                                        {{-- <th>Cancel</th> --}}
                                        <td colspan="2">
                                            <form action="{{ route('user.bookings.cancel', $ride->id) }}" onsubmit="return confirm('Are You Sure?')" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit">Cancel</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="mapid">

        </div>
    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>
<script src="//unpkg.com/leaflet-gesture-handling"></script>

<script>
    const mymap = L.map('mapid', {
            scrollWheelZoom: false,
            gestureHandling: true,
    }).setView([{{ $ride->from_latitude }}, {{ $ride->from_longitude }}], 13);

    mymap.on('focus', function() {
        mymap.scrollWheelZoom.enable();
    });
    mymap.on('blur', function() {
        mymap.scrollWheelZoom.disable();
    });
    //Map Setup
    const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
    const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    const tiles = L.tileLayer(tileUrl, {
        attribution
    });
    tiles.addTo(mymap);

    const fromMarker = L.marker([{{ $ride->from_latitude }}, {{ $ride->from_longitude }}]).addTo(mymap);
    fromMarker.bindPopup(`Start`)
    const toMarker = L.marker([{{ $ride->to_latitude }}, {{ $ride->to_longitude }}]).addTo(mymap);
    toMarker.bindPopup(`End`)
</script>

@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin="" />

<style>
    #mapid{
        height: 400px;
    }

    .cover {
        min-height: calc(100vh - 128px);
    }
</style>
@endsection
