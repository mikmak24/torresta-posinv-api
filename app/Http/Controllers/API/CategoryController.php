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
       return $this->sendResponse($categories, 'Categories Retrieved Successfully.');
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
  
        if (!$category) {
            return  $this->sendError('error', 'Category not found.');
        }
   
        return $this->sendResponse(new CategoryResource($category), 'Category Retrieved Successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'category_name' => 'required',
            'category_description' => 'required'
        ]);

        $category = Category::find($id);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if (!$category) {
            return  $this->sendError('error', 'Category not found.');
        }
     
        $category->category_name = $input['category_name'];
        $category->category_description = $input['category_description'];
        $category->save();
     
        return $this->sendResponse(new CategoryResource($category), 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return $this->sendResponse([], 'Category deleted successfully.');
    }

}
