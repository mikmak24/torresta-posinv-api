<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use DB;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_code',
        'product_name',
        'product_price',
        'product_discount',
        'product_quantity',
        'total',
    ];


    protected $hidden = [
        'updated_at', 'created_at',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function create($product, $order_id){
        
        // Store the record
        $order = new $this([
            "order_id" =>              $order_id,
            "product_code" =>          $product['product_code'],
            "product_name" =>          $product['product_name'],
            "product_price" =>         $product['product_price'],
            "product_discount" =>      $product['product_discount'],
            "product_quantity" =>      $product['product_quantity'],
            "total" =>                 $product['total'],
        ]);
        $order->save(); // Finally, save the record.
        // $item = new Item();
        // $item->inventoryMovement( $items['item_code'], $items['item_quantity'], 'subtract');
    }
   
}
