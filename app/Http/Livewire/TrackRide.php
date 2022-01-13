<?php

namespace App\Http\Livewire;

use App\Models\Ride;
use App\Models\TrackRide as ModelsTrackRide;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TrackRide extends Component
{
    public $ride;
    public $track;
    public $isTracking=false;

    public function mount($rideId){
        $this->ride = Ride::where('driver_id', Auth::user()->id)->where('id',$rideId)->first();
        $this->track = ModelsTrackRide::where('ride_id', $rideId)->first();
        if($this->track == null){
            $this->track = new ModelsTrackRide();
            $this->track->ride_id = $this->ride->id;
            $this->track->rate = Auth::user()->rate;
            $this->track->save();
            $this->ride->track_ride_id = $this->track->id;
            $this->ride->update();
        }
    }

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
        'resetTrack' => 'resetTrack',
        'startTracking'=>'startTracking',
        'stopTracking' =>'stopTracking'
    ];

    public function startTracking(){
        $this->dispatchBrowserEvent('startTracking');
        $this->isTracking = true;
    }

    public function stopTracking(){
        $this->dispatchBrowserEvent('stopTracking');
        $this->isTracking = false;
    }

    public function resetTrack(){
        $this->dispatchBrowserEvent('resetTrack');

        $this->track->distance = 0;
        $this->track->latitude = null;
        $this->track->longitude = null;
        $this->track->update();
    }

    public function setLatitudeLongitude($latitude, $longitude) 
    {
        
        if($this->track->latitude!=null && $this->track->longitude!=null){
            $this->track->distance += $this->haversineGreatCircleDistance($latitude, $longitude, $this->track->latitude,$this->track->longitude);
        }

        $this->track->latitude = $latitude;
        $this->track->longitude = $longitude;
        $this->track->update();
    }

   

    public function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371e3)
      {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $latDelta = $latTo - $latFrom;

        $a = sin($latDelta/2) * sin($latDelta/2)+
          cos($latFrom) * cos($latTo) *
          sin($lonDelta/2) * sin($lonDelta/2);

        $c =  atan2(sqrt($a),sqrt(1-$a));
        return $c * $earthRadius;

        // $a = pow(cos($latTo) * sin($lonDelta), 2) +
        //     pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        // $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        // $angle = atan2(sqrt($a), $b);
        // return $angle * $earthRadius;
    }

    public function render()
    {
        return view('livewire.track-ride');
    }
}
