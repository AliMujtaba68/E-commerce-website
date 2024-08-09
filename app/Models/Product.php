<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // has one category

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // has many colors

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');

    }

}

