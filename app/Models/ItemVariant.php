<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'size_id', 'color_id', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class);
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
