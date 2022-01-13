@extends('driver.app')
@section('content')
    <div id="mapid"></div>
    @livewire('updatelocation')
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>
    <script>

        const startLocation = {};
        startLocation.latitude = {{ auth()->user()->latitude??26.8065 }};
        startLocation.longitude = {{ auth()->user()->longitude??87.2846 }};

        const currentLocation = {
        currentMarker: null,
        latitude: null,
        longitude:null
        }
    
        const mymap = L.map('mapid', {
        scrollWheelZoom: false,
        gestureHandling: true,
        }).setView([startLocation.latitude, startLocation.longitude], 13);
    
    
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
        currentLocation.latitude = latitude;
        currentLocation.longitude = longitude;
        if (currentLocation.currentMarker == null) {
        currentLocation.hasLocation = true;
    
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

    </style>
@endsection