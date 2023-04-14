<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Category as CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends BaseController
{
   public function index()
   {
       $categories = Category::all();
       return $this->sendResponse(CategoryResource::collection($categories), 'Categories Retrieved Successfully.');
   }

   public function store(Request $request)
   {
       $input = $request->all();
  
       $validator = Validator::make($input, [
           'category_name' => 'required',
           'category_description' => 'required'
       ]);
  
       if($validator->fails()){
           return $this->sendError('Validation Error.', $validator->errors());       
       }
  
       $category = Category::create($input);
  
       return $this->sendResponse(new CategoryResource($category), 'Category Created Successfully.');
   }

   public function show($id)
    {
        $category = Category::find($id);
  
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
   
        return $this->sendResponse(new CategoryResource($category), 'Category Retrieved Successfully.');
    }

}
