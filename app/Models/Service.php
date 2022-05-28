<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function service_category(){
        return $this->belongsTo(ServiceCategory::class, 'kategori', 'id');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

}
