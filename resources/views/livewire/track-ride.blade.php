<div>
    <div class="container-fluid py-2">
        <div class="py-1">
            Distance Travelled: <span id="distance">{{ $track->distance??0 }}</span> m
        </div>
        <div class="py-1">
            Total Cost: Rs. <span id="cost">{{ $track->cost }} </span>
        </div>
        <div class="py-1">
            Total Rate: Rs. <span id="cost">{{ $track->rate??0}} </span>
        </div>
        
        @if (!$ride->is_completed)
            @if (!$isTracking)

                <button class="btn btn-block btn-primary" wire:click="$emitSelf('startTracking')" >
                    Start Tracking
                </button>
                @else
                <button class="btn btn-block btn-warning" wire:click="$emitSelf('stopTracking')">
                    Stop Tracking
                </button>
            @endif

            <button class="btn btn-block btn-danger" id="reset" wire:click="$emitSelf('resetTrack')">
                Reset
            </button>
        
            @livewire('endride',[$ride->id])
        @endif
    </div>
   
        <script>
            let tracking;

            window.addEventListener('startTracking', () => {
                console.log('start')
             

                    tracking = navigator.geolocation.watchPosition(
                        // On Success
                        ({
                            coords: {
                                latitude,
                                longitude
                            }
                        }) => {
                            
                            Livewire.emit('set:latitude-longitude', latitude, longitude) 
                        },
                        // On Fail
                        (e) => {

                        }, {
                            maximumAge: 60000
                        }
                    )


            })

            window.addEventListener('stopTracking',()=>{
               

                navigator.geolocation.clearWatch(tracking);
            })

            window.addEventListener('resetTrack',()=>{
               

                Livewire.emit('stopTracking');
            })

        </script>
    
</div>
