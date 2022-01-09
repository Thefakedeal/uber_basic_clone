<?php

namespace App\Http\Livewire;

use App\Models\Ride;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Endride extends Component
{ 
    public $ride;

    public function mount($rideId){
        $this->ride = Ride::where('id', $rideId)->where('driver_id',Auth::user()->id)->first();
    }

    public function endRide(){
        $this->ride->is_completed = true;
        $this->ride->update();
        session()->flash('message', 'Ride Complete');
    }

    public function render()
    {
        return view('livewire.endride');
    }
}
