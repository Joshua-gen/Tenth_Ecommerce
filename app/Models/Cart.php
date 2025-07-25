<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id', 'size_id', 'color_id', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function size()
    {
        return $this->belongsTo(AttributeValue::class, 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(AttributeValue::class, 'color_id');
    }

}



