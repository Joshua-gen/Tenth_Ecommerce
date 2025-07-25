<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $size = Attribute::create(['name' => 'Size', 'type' => 'dropdown']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'Small']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'Medium']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'Large']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'XL']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'XXL']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => '30-32']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => '32-34']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => '34-36']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => '36-38']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => '38-40']);
 
    
        $color = Attribute::create(['name' => 'Color', 'type' => 'dropdown']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Red']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Blue']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Green']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Yellow']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Orange']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Purple']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Pink']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Brown']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Black']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'White']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Gray']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Cyan']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Magenta']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Beige']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Lavender']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Turquoise']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Maroon']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Gold']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Silver']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Teal']);

    }
}
