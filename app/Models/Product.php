<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'product_description',
        'product_price',
        'product_quantity',
        'product_status',
        'product_image',
        'category_id'
    ];

    protected $hidden = [
        'updated_at', 'created_at',
    ];

    public static function generateCode()
    {
        $code = 'PRD' . mt_rand(100000, 999999); // Generate a random 6-digit number

        // Check if the code already exists
        if (self::where('product_code', $code)->exists()) {
            // If it does, generate a new code
            return self::generateCode();
        }
        return $code;
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // Define the "belongsTo" relationship to Category model
    }
    public function updateProduct($product, $input){
        $product->product_name = $input['product_name'];
        $product->product_description = $input['product_description'];
        $product->product_price = $input['product_price'];
        $product->product_quantity = $input['product_quantity'];
        $product->product_status = $input['product_status'];
        $product->product_image = $input['product_image'];
        $product->category_id = $input['category_id'];
        $product->save();
    }


}
