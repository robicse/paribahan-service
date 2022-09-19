<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DriverSalary extends Model
{
    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function payment_type(){
        return $this->belongsTo(PaymentType::class);
    }
}
