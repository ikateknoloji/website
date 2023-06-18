<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'company_name',
        'full_name',
        'activity_area',
        'company_motto',
        'phone_number',
        'email',
        'project_information',
    ];
}
