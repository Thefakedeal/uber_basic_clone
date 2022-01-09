<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'Pending';
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_ACCEPTED = 'Accepted';

    const STATUSES = ['Pending','Cancelled', 'Accepted'];

    public function driver(){
        return $this->belongsTo(User::class,'driver_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getIsPendingAttribute(){
        return $this->status == self::STATUS_PENDING;
    }
    public function getIsAcceptedAttribute(){
        return $this->status == self::STATUS_ACCEPTED;
    }
    public function getIsCancelledAttribute(){
        return $this->status == self::STATUS_CANCELLED;
    }
}
