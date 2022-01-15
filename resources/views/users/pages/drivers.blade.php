@extends('users.app')

@section('content')
    <form action="{{ route('user.bookings.store') }}" method="POST" id="submit">
        @csrf
        <input type="hidden" name="driver_id" id="driver_id">
        <input type="hidden" name="from_latitude" value="{{ request()->get('latitude') }}">
        <input type="hidden" name="from_longitude" value="{{ request()->get('longitude') }}">
        <input type="hidden" name="to_latitude" value="{{ request()->get('destination_latitude') }}">
        <input type="hidden" name="to_longitude" value="{{ request()->get('destination_longitude') }}">
        <input type="hidden" name="message" id="form_msg">
    </form>
    <div class="row cover ">
        <div class="col-md-8 ">
            <div id="mapid" class="sticky-top top-0"></div>
        </div>
        <div class="col-md-4" id="drivers">
            
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>

    <script>
        const form = document.getElementById('submit');
        const driver_id = document.getElementById('driver_id'); 
        const form_msg = document.getElementById('form_msg');

        function submitForm(driverId){
            const msg = prompt("Any Additional Request?");
            if(msg == null) return;
            driver_id.value = driverId;
            form_msg.value = msg;
            form.submit();
        }
        
        const drivers = @json($drivers);
     
        const driverDiv =document.getElementById('drivers');
        const currentLocation = {
            currentMarker: null,
            latitude: null,
            longitude: null,
            hasLocation: false
        }


        const mymap = L.map('mapid', {
            scrollWheelZoom: false,
            gestureHandling: true,
        }).setView([0.0, 0.0], 13);

        drivers.forEach(driver => {
            // <div class="card">
            //     <div class="card-body">
            //         <h6>Driver Name</h6>
            //         <small class="text-muted">30 minutes ago</small> <br>
            //         <button class="btn btn-sm btn-primary mt-1">Book</button>
            //     </div>
            // </div>
            const driverMarker = L.marker([driver.latitude, driver.longitude]).addTo(mymap);
            driverMarker.bindPopup(`${driver.name} <br> Last Seen: ${driver.last_seen}`)


            // Adding Divs 
            const driverElem = document.createElement('div')
            driverElem.classList.add('card');

           
            const body = document.createElement('div');
            body.classList.add('card-body');

            const title = document.createElement('h6');
            title.innerText = driver.name;

            const lastSeen = document.createElement('small');
            lastSeen.innerText = driver.last_seen;
            lastSeen.classList.add('text-muted');

            const btn = document.createElement('button');
            btn.innerText = 'Book';
            btn.classList.add('btn', 'btn-sm', 'btn-primary', 'm-1');

            body.appendChild(title)
            body.appendChild(lastSeen)
            body.appendChild(btn)
            driverElem.appendChild(body)
            driverDiv.appendChild(driverElem)

            driverElem.addEventListener('mouseover', (e)=>{
                driverMarker.openPopup(); 
            });
            
            btn.addEventListener('click', (e)=>{
                submitForm(driver.id)
            })
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
        #mapid{
            height: calc(100vh - 128px);
            min-height: 400px;
            position: sticky !important;
        }

        .cover {
            min-height: calc(100vh - 128px);
        }
    </style>
@endsection