<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Validator;
use Log;

class ProductController extends BaseController
{

    protected $product;
    public function __construct()
    {
        $this->product = new Product();
    }

    public function store(Request $request)
    {
        $input = $request->all();
    
        $validator = Validator::make($input, [
            'product_name'          => 'required',
            'product_description'   => 'required',
            'product_price'         => 'required',
            'product_quantity'      => 'required',
            'product_status'        => 'required',
            'product_image'         => 'required',
            'category_id'           => 'required'
        ]);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product_code = $this->product::generateCode(); // Generate a new product code
        $input['product_code'] = $product_code; //add request
        $product = $this->product::create($input);
    
        return $this->sendResponse(new ProductResource($product), 'Product Created Successfully.');
    }

    public function index()
    {
        $products = $this->product::with('category')->get();
        return $this->sendResponse($products, 'Products Retrieved Successfully.');
    }

    public function show($id)
    {
        $product = $this->product::find($id);
  
        if (!$product) {
            return  $this->sendError('error', 'Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product Retrieved Successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'product_name'          => 'required',
            'product_description'   => 'required',
            'product_price'         => 'required',
            'product_quantity'      => 'required',
            'product_status'        => 'required',
            'product_image'         => 'required',
            'category_id'           => 'required'
        ]);

        $product = $this->product::find($id);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if (!$product) {
            return  $this->sendError('error', 'Product not found.');
        }

        $this->product->updateProduct($product, $input);
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $category = $this->product::find($id);
        $category->delete();
        return $this->sendResponse([], 'Product deleted successfully.');
    }
 

}
