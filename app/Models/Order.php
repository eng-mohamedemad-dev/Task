<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasUuids;
    protected $fillable = ['session_id', 'grand_total', 'status'];
    public $incrementing = false;
    protected $keyType = 'string';


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function session()
    {
        return $this->belongsTo(SessionState::class, 'session_id', 'session_id');
    }
}


