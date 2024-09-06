<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id', 'iban', 'address', 'contact_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Bir iş yerinin birçok siparişi olabilir
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
