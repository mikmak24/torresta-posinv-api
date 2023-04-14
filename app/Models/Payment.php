<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_amount',
        'payment_change',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function create($payment, $order_id){
        // Store the record
        $payment = new $this([
            "order_id" =>               $order_id,
            "payment_method" =>         'Cash',
            "payment_amount" =>         $payment['payment_amount'],
            "payment_change" =>         $payment['payment_change'],
            "status" =>                 'processed'
        ]);
        $payment->save(); // Finally, save the record.
        return $payment->id;
    }
}
