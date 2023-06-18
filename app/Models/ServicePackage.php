<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;
    
    protected $table = 'service_packages';
    protected $fillable = ['service_product_id', 'name', 'price', 'subheading'];

    public function serviceProduct()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    }

    public function packageFeatures()
    {
        return $this->hasMany(PackageFeature::class, 'service_package_id');
    }

}
