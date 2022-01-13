<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Updatelocation extends Component
{
    public $user;

    public function mount(){
        $this->user = Auth::user();
    }

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude'
    ];

    public function setLatitudeLongitude($latitude, $longitude) 
    {
        
            $this->user->latitude = $latitude;
            $this->user->longitude = $longitude;
            $this->user->location_updated_at = Carbon::now();
            $this->user->update();
     
    }

    public function render()
    {
        return view('livewire.updatelocation');
    }
}
