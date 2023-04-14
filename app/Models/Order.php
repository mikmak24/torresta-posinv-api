<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'order_discount',
        'order_date',
        'order_total',
        'process_by'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function orderedItems()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function create($order){
        // Store the record
        $order = new $this([
            "order_no" =>               $this->generateCode(),
            "order_discount" =>         $order['order_discount'],
            "order_date" =>             $order['order_date'],
            "order_total" =>            $order['order_total'],
            "process_by" =>             auth()->user()->name
        ]);
        $order->save(); // Finally, save the record.
        return $order->id;
    }

    public static function generateCode()
    {
        $code = 'ORDER' . mt_rand(100000, 999999); // Generate a random 6-digit number

        // Check if the code already exists
        if (self::where('order_no', $code)->exists()) {
            // If it does, generate a new code
            return self::generateCode();
        }
        return $code;
    }
}
