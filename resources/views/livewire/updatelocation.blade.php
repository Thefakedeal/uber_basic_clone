<div>
    <script>
     
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
                        

                        // if(@this.user.latitude == latitude && @this.user.longitude == longitude) return;
                        Livewire.emit('set:latitude-longitude', latitude, longitude) 
                    },
                    // On Fail
                    (e) => {

                    }, {
                        maximumAge: 10000
                    }
                )
            }
        }
        updateLocation()
    </script>
</div>
