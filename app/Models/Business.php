<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'iban', 'address', 'contact_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
