<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRide extends Model
{
    use HasFactory;
    public function getCostAttribute(){
        return round(($this->distance * $this->rate)/1000,2);
    }

    public function ride(){
        return $this->belongsTo(Ride::class);
    }
}
