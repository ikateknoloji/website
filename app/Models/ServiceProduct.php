<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProduct extends Model
{
    use HasFactory;
    
    protected $table = 'service_products';

    protected $fillable = ['title', 'description', 'image'];

    public function servicePackages()
    {
        return $this->hasMany(ServicePackage::class, 'service_product_id');
    }
}
