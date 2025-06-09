<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    public function registrations()
{
    return $this->hasMany(Registration::class);
}

public function getDiscountedPriceAttribute()
{
    $regCount = $this->registrations()->count();

    $discounts = [0 => 5, 1 => 10, 2 => 15, 3 => 20, 4 => 25, 5 => 30];
    $discount = $discounts[$regCount] ?? 0;

    return max($this->base_price - $discount, 0);
}

}
