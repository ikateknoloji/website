<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_package_id',
        'city_id',
        'district_id',
        'name',
        'field',
        'full_name',
        'motto',
        'phone',
        'email',
        'establishment_year',
        'about',
        'project_content',
        'status',
        'offer_price',
    ];
    
    protected $table = 'orders';

    public function district()
    {
        return $this->belongsTo(District::class,'district_id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }



}
