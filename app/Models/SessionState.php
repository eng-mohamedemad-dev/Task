<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionState extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'session_id';

    protected $fillable = [
        'session_id', 'restaurant_name', 'current_step', 'temp_product_name',
        'temp_quantity', 'last_chosen_product_id', 'interaction_history', 'last_interaction',
        'user_id',
    ];

    protected $casts = [
        'interaction_history' => 'array',
        'last_interaction' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'session_id', 'session_id');
    }

    public function lastProduct()
    {
        return $this->belongsTo(Product::class, 'last_chosen_product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


