@extends('users.app')

@section('content')
    <div class="container-fluid" id="contain">
        <div class="form">
            <div class="card">
                <div class="card-header">Search For Drivers</div>
                <div class="card-body">
                    <form action="{{ route('user.drivers') }}">
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lon">
                        <input type="hidden" name="destination_latitude" id="dlat">
                        <input type="hidden" name="destination_longitude" id="dlon">
                        <button type="submit" class="btn btn-block btn-primary" disabled id="btn">Search</button>
                    </form>
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
        const currentLocation = {
            currentMarker: null,
            latitude: null,
            longitude: null,
            hasLocation: false
        }

        const destinationLocation = {
            currentMarker: null,
            latitude: null,
            longitude: null,
            hasLocation: false
        }

        const latitudeDiv = document.getElementById('lat')
        const longitudeDiv = document.getElementById('lon')
        const dlatitudeDiv = document.getElementById('dlat')
        const dlongitudeDiv = document.getElementById('dlon')

        const btnDiv = document.getElementById('btn')

       
        function fillLocation(lat,lon){
            latitudeDiv.value = lat;
            longitudeDiv.value = lon;
            if(currentLocation.hasLocation && destinationLocation.hasLocation){
                btnDiv.disabled= false;
            }
        }

      
        function fillDestination(lat,lon){
           
            dlatitudeDiv.value = lat;
            dlongitudeDiv.value = lon;
            if(currentLocation.hasLocation && destinationLocation.hasLocation){
                btnDiv.disabled= false;
            }
           
        }

        const mymap = L.map('mapid', {
            scrollWheelZoom: false,
            gestureHandling: true,
        }).setView([0.0, 0.0], 13);

        mymap.on('click', (e)=>{
            const {lat, lng} = e.latlng;
            destinationLocation.latitude = lat;
            destinationLocation.longitude = lng;
            destinationLocation.hasLocation = true;
            if(destinationLocation.currentMarker){
                mymap.removeLayer(destinationLocation.currentMarker)
            }
            destinationLocation.currentMarker =  L.marker([destinationLocation.latitude, destinationLocation.longitude]).addTo(mymap);
            destinationLocation.currentMarker.bindPopup("Destination").openPopup();
            fillDestination(lat,lng)
        });

        function updateLocation() {
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(
                    // On Success
                    ({
                        coords: {
                            latitude,
                            longitude
                        }
                    }) => {
                        currentLocation.latitude = latitude;
                        currentLocation.longitude = longitude;
                        currentLocation.hasLocation = true;

                        fillLocation(latitude,longitude)
                        if (currentLocation.currentMarker == null) {
                            mymap.panTo([currentLocation.latitude, currentLocation.longitude])
                            currentLocation.currentMarker = L.marker([currentLocation.latitude, currentLocation
                                .longitude
                            ]).addTo(mymap);
                            currentLocation.currentMarker.bindPopup("Your Location").openPopup();
                            return;
                        }

                        currentLocation.currentMarker.setLatLng([latitude, longitude])


                    },
                    // On Fail
                    (e) => {

                    }, {
                        maximumAge: 1000
                    }
                )
            }
        }



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

        updateLocation();
    </script>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    <style>
        #mapid {
            height: calc(100vh - 128px);
        }

        #contain{
            position: relative;
        }
        .form{
            position: absolute;
            top: 10%;
            left: 10%;
            transform: translate(-10%, -10%);
            z-index: 100000;
        }
    </style>
@endsection
