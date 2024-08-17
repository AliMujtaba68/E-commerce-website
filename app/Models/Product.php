<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Category;
use App\Models\Subcategory; // Import Subcategory model
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with Colors
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }

    // Relationship with Subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class); // Assuming 'subcategory_id' is the foreign key
    }
}
