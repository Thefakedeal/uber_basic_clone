<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRide extends Model
{
    use HasFactory;
    public function getCostAttribute(){
        return $this->distance * $this->rate;
    }
}
