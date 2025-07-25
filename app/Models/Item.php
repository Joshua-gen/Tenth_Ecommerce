<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;


class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'description',
        'image',
        'images',
        'category_id',
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'item_attributes')
        ->withTimestamps();
    }

    public function variants()
    {
        return $this->hasMany(ItemVariant::class);
    }

}

