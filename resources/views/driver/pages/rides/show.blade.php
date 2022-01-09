@extends('driver.app')

@section('content')
    <div class="py-2 table-responsive">
        <table class="table table-striped table-sm">
            <tr>
                <th>Name</th>
                <td>{{ $ride->user->name }}</td>
            </tr>
            <tr>
                <th>Contact</th>
                <td>
                    {{ $ride->user->mobile ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>
    <div class="d-flex flex-wrap justify-content-around w-100 py-4 px-2">
        <button class="btn btn-sm btn-primary" id="st_point">Starting Point</button>
        <button class="btn btn-sm btn-primary" id="end_point">Destination</button>
        <button class="btn btn-sm btn-primary" id="location">Your Location</button>
    </div>
    <div id="mapid"></div>
    @if ($ride->is_pending)
        <div class="d-flex flex-wrap justify-content-around w-100 py-4 px-2">

            <form action="{{ route('driver.rides.cancel', $ride->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Reject Ride</button>
            </form>
            <form action="{{ route('driver.rides.accept', $ride->id) }}" method="post">
                @csrf
                <button class="btn btn-sm btn-success" type="submit">Accept Ride</button>
            </form>

        </div>

    @elseif ($ride->is_accepted)
        <div class="container-fluid py-2">
            <div class="py-1">
                Distance Travelled: <span id="distance">0</span> m
            </div>
            <div class="py-1">
                Total Cost: Rs. <span id="cost">0</span>
            </div>
            <button class="btn btn-block btn-primary" id="track">
                Start Tracking
            </button>
            <button class="btn btn-block btn-danger" id="reset">
                Reset
            </button>
        </div>
    @elseif ($ride->is_cancelled)
        cancelled
    @endif
@endsection


@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>

    <script>
        const st_btn = document.getElementById('st_point');
        const end_btn = document.getElementById('end_point');
        const location_btn = document.getElementById('location');

        @if ($ride->is_accepted && !$ride->is_completed)
        
            function getDistance(origin, destination) {
            // return distance in meters
            const lon1 = toRadian(origin[1]);
            const lat1 = toRadian(origin[0]);
            const lon2 = toRadian(destination[1]);
            const lat2 = toRadian(destination[0]);
        
            const deltaLat = lat2 - lat1;
            const deltaLon = lon2 - lon1;
        
            const a = Math.pow(Math.sin(deltaLat/2), 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(deltaLon/2), 2);
            const c = 2 * Math.asin(Math.sqrt(a));
            const EARTH_RADIUS = 6371;
            return c * EARTH_RADIUS * 1000;
            }

            function toRadian(degree) {
            return degree*Math.PI/180;
            }
        
        
            const distanceElem = document.getElementById('distance');
            const costElem = document.getElementById('cost');
        
        
        
            const track_btn = document.getElementById('track');
            const reset = document.getElementById('reset');
            const ride_id = {{ $ride->id }};
            const tracking = localStorage.getItem(`ride-${ride_id}`)?JSON.parse(localStorage.getItem(`ride-${ride_id}`)):
            {
            start_tracking:false,
            hasLastLocation: false,
            last_location: {
            latitude: null,
            longitude: null
            },
            distance: 0,
            unit_cost: {{ auth()->user()->rate ?? 0 }}
            }
        
            distanceElem.innerText = tracking.distance;
            costElem.innerText = tracking.distance * tracking.unit_cost;
           
        
            function track(latitude, longitude){
            let distance = 0;
            if(tracking.hasLastLocation){
            const {last_location} = tracking;
            distance = getDistance([latitude,longitude],[last_location.latitude,last_location.longitude])
            }
            
            tracking.last_location ={
            latitude, longitude
            }
            tracking.distance = parseFloat(distance) + parseFloat(tracking.distance);
            tracking.hasLastLocation= true
            localStorage.setItem(`ride-${ride_id}`, JSON.stringify(tracking));
          
            distanceElem.innerText = parseInt(tracking.distance);
            costElem.innerText = parseInt(tracking.distance * tracking.unit_cost);
            }
            
            track_btn.innerText = tracking.start_tracking?"Stop Tracking":"Start Tracking"

            track_btn.addEventListener('click', function(e){
            tracking.start_tracking = !tracking.start_tracking;
            localStorage.setItem(`ride-${ride_id}`, JSON.stringify(tracking));
            track_btn.innerText = tracking.start_tracking?"Stop Tracking":"Start Tracking"
            })
            
            reset.addEventListener('click', function(e){
                const tracking = localStorage.getItem(`ride-${ride_id}`)?JSON.parse(localStorage.getItem(`ride-${ride_id}`)): 
                tracking.hasLastLocation = false;
                tracking.last_location = {
                latitude: null,
                longitude: null
                }
                tracking.distance =0;
                tracking.unit_cost = {{ auth()->user()->rate ?? 0 }}
                distanceElem.innerText = tracking.distance;
                costElem.innerText = tracking.distance * tracking.unit_cost;
                tracking.start_tracking = false;
                localStorage.setItem(`ride-${ride_id}`, JSON.stringify(tracking));
                track_btn.innerText = "Start Tracking"
            })
        @endif

        const currentLocation = {
            hasLocation: false,
            currentMarker: null
        }


        const startLocation = {};
        startLocation.latitude = {{ $ride->from_latitude }}
        startLocation.longitude = {{ $ride->from_longitude }}

        const finishLocation = {};
        finishLocation.latitude = {{ $ride->to_latitude }}
        finishLocation.longitude = {{ $ride->to_longitude }}


        //Set Current Location As LatLong
        function setCurrentLocationAsLatLong() {
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(
                    // On Success
                    ({
                        coords: {
                            latitude,
                            longitude
                        }
                    }) => {
                        currentLocation.hasLocation = true;
                        currentLocation.latitude = latitude;
                        currentLocation.longitude = longitude;

                        mymap.panTo([currentLocation.latitude, currentLocation.longitude])
                        currentLocation.currentMarker = L.marker([currentLocation.latitude, currentLocation.longitude])
                            .addTo(mymap);
                        currentLocation.currentMarker.bindPopup("Your Location").openPopup();
                    },
                    // On Fail
                    (e) => {
                        alert('Sorry Failed To Locate You')
                    }
                )
            } else {
                alert('Sorry! Your Browser Doesnt Support GeoLocation')
            }
        }


        //Set Current Location As LatLong
        function updateLocation() {
            if ('geolocation' in navigator) {
                navigator.geolocation.watchPosition(
                    // On Success
                    ({
                        coords: {
                            latitude,
                            longitude
                        }
                    }) => {
                        if(currentLocation.latitude == latitude && currentLocation.longitude==longitude) return;
                        if (currentLocation.currentMarker == null) {
                            currentLocation.hasLocation = true;
                            currentLocation.latitude = latitude;
                            currentLocation.longitude = longitude;
                            mymap.panTo([currentLocation.latitude, currentLocation.longitude])
                            currentLocation.currentMarker = L.marker([currentLocation.latitude, currentLocation
                                .longitude
                            ]).addTo(mymap);
                            currentLocation.currentMarker.bindPopup("Your Location").openPopup();
                            return;
                        }
                        @if ($ride->is_accepted && !$ride->is_completed)
                            if(tracking.start_tracking){
                            track(latitude,longitude)
                            }
                        @endif
                        currentLocation.currentMarker.setLatLng([currentLocation.latitude, currentLocation.longitude])


                    },
                    // On Fail
                    (e) => {

                    }, {
                        maximumAge: 1000
                    }
                )
            }
        }


        // Map Instance
        const mymap = L.map('mapid', {
            scrollWheelZoom: false,
            gestureHandling: true,
        }).setView([startLocation.latitude, startLocation.longitude], 13);



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

        // setCurrentLocationAsLatLong();


        const startMarker = L.marker([startLocation.latitude, startLocation.longitude]).addTo(mymap);
        startMarker.bindPopup("Starting Point");

        st_btn.addEventListener('click', function(e) {
            mymap.panTo([startLocation.latitude, startLocation.longitude]);
            startMarker.bindPopup("Starting Point").openPopup();
        })

        const finishMarker = L.marker([finishLocation.latitude, finishLocation.longitude]).addTo(mymap);
        finishMarker.bindPopup("Finish Destination");
        end_btn.addEventListener('click', function(e) {
            mymap.panTo([finishLocation.latitude, finishLocation.longitude]);
            finishMarker.bindPopup("Finish Destination").openPopup();

        })

        updateLocation();
        location_btn.addEventListener('click', function(e) {
            if (currentLocation.hasLocation) {
                mymap.panTo([currentLocation.latitude, currentLocation.longitude]);
            }
        })
    </script>


@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    <style>
        #mapid {
            height: 300px;
        }

    </style>
@endsection
