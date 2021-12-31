@extends('admin.app')

@section('content')

    <form action="{{ route('admin.users.update', $user->id) }}" method="post">
        @csrf
        @method('put')
        <div class="card">
            <div class="card-header">
                Basic Details
            </div>
            <div class="card-body">
                <div class="form-group">
                  <label for="name">Name <span class="text-danger">*</span></label>
                  <input type="text" value="{{ $user->name }}" 
                    class="form-control" name="name" id="name"  placeholder="Name" required>
                    @error('name')
                        <small  class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email"
                      class="form-control" value="{{ $user->email }}"  name="email" id="email"  placeholder="Email" required>
                      @error('email')
                          <small  class="form-text text-danger">{{ $message }}</small>
                      @enderror
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile No. </label>
                    <input type="tel"
                      class="form-control"  value="{{ $user->mobile }}"  name="mobile" id="mobile" minlength="10" maxlength="10" placeholder="Mobile No.">
                      @error('mobile')
                          <small  class="form-text text-danger">{{ $message }}</small>
                      @enderror
                </div>

                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" name="role" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @if($user->role==$role) selected @endif>{{ $role }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                Driver Details
            </div>
            <div class="card-body">
                <div class="form-group">
                  <label for="rate">Rate Per KM</label>
                  <input type="number"
                    class="form-control" value="{{ $user->rate }}" name="rate" id="rate" placeholder="Rate" min="0">
                    @error('rate')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lat">Latitude</label>
                                <input type="text" value="{{ $user->latitude }}" class="form-control" name="latitude" id="lat"
                                    >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="long">Longitude</label>
                                <input type="text" value="{{ $user->longitude }}" class="form-control" name="longitude" id="long"
                                    >
                            </div>
                        </div>
                    </div>
    
                    <button type="button" class="btn btn-primary mb-2" id="locationbtn">
                        <i class="fa fa-location-arrow" aria-hidden="true"></i>
                        Set As Current Location
                    </button>
                    
                    <div class="mb-4" id="mapid"></div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm ">
            <i class="fas fa-save    "></i> Save Ad
        </button>
    </form>

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

@section('scripts') 
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>


    <script>
        const defatltLat = 26.8114;
        const defaultLong = 87.2850;
        // Lat & Long Divs
        const latDiv = document.getElementById('lat');
        const lonDiv = document.getElementById('long');

        const locationbtn = document.getElementById('locationbtn'); //Btn to Set current location ast lat and long


         // Map Instance
          const mymap = L.map('mapid',{
            scrollWheelZoom: false,
            gestureHandling: true,
         }).setView([defatltLat, defaultLong], 13);
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

        let marker;
        mymap.setView([latDiv.value || defatltLat, lonDiv.value || defaultLong], 15);

        //If Lat And Long Are Given Show Marker
        if (latDiv.value && lonDiv.value) {
            marker = L.marker([latDiv.value, lonDiv.value]).addTo(mymap);
        }

        // Set Lat Long value on Map Click
        mymap.on('click', (e) => {
            lat = e.latlng.lat;
            lon = e.latlng.lng;
            latDiv.value = lat;
            lonDiv.value = lon;
            //If Marker Has Been Set Remove It
            if (marker !== undefined) {
                mymap.removeLayer(marker)
            }
            // Add Clicked Location To Marker
            marker = L.marker([latDiv.value, lonDiv.value]).addTo(mymap);
        });

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
                        latDiv.value = latitude;
                        lonDiv.value = longitude;
                        //If Marker Has Been Set Remove It
                        if (marker !== undefined) {
                            mymap.removeLayer(marker)
                        }
                        // Add Clicked Location To Marker
                        marker = L.marker([latDiv.value, lonDiv.value]).addTo(mymap);
                        mymap.panTo(new L.LatLng(latDiv.value, lonDiv.value));
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

        locationbtn.addEventListener('click', e => {
            setCurrentLocationAsLatLong()
        })

    </script>

@endsection