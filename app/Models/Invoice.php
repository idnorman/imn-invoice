<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function client(){
        return $this->belongsTo(Client::class, 'klien', 'id');
    }

    public function _user(){
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'layanan', 'id');
    }
}
