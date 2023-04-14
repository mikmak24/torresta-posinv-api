<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use Validator;
use Log;

class OrderController extends BaseController
{
    protected $product;
    protected $order;
    protected $orderItem;
    protected $payment;

    public function __construct()
    {
        $this->product = new Product();
        $this->order = new Order();
        $this->orderItem =  new OrderItem();
        $this->payment = new Payment();
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'order_total'          => 'required',
            'order_discount'   => 'required',
            'payment_method'         => 'required',
            'payment_amount'      => 'required',
            'payment_change'        => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $order_id = $this->order->create($input);
        $productsOrdered = $input['products'];

        foreach($productsOrdered as $product){
            $this->orderItem->create($product, $order_id);
        }

        $this->payment->create($input, $order_id);

        $order = $this->order::with('payment')->find($order_id);
        return $this->sendResponse($order, 'Order Created Successfully.');
    }

    public function index()
    {
        $orders = $this->order::with('payment', 'orderedItems')->get();
        return $this->sendResponse($orders, 'Orders Retrieved Successfully.');
    }

    public function show($id)
    {
        $order = $this->order::with('payment', 'orderedItems')->find($id);
  
        if (!$order) {
            return  $this->sendError('error', 'Order not found.');
        }
   
        return $this->sendResponse($order, 'Order Retrieved Successfully.');
    }

    
}
