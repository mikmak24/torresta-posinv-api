<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'category_description',
    ];

    protected $hidden = [
        'updated_at', 'created_at',
    ];

    public function items()
    {
        return $this->hasMany(Product::class); // Define the "hasMany" relationship to Item model
    }
}
