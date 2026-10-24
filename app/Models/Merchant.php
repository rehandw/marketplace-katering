<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'phone',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
