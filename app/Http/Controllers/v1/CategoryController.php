<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{  
    public function create($request){
        try {
            $uid = $request['uid'];
            $name = $request['category'];
            $branch = $request['branch'];
            $cat_type = $request['cat_type'];
            $image = $request->file('cat_image');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $category = new Category();
            $category->created_by = $uid;
            $category->category = $name;
            $category->branch = $branch;
            $category->type = $cat_type; // 0 - product ,1 - service
            $category->category_avatar = $url;
            $category->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function edit($request){
        try {
            $id = $request['id'];
            $name = $request['category'];
            $branch = $request['branch'];
            $cat_type = $request['cat_type'];
            $category = Category::find($id);
            $image = $request->file('cat_image');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $category->category_avatar = $url;
            }
            $category->category = $name;
            $category->branch = $branch;
            $category->type = $cat_type; // 0 - product ,1 - service
            $category->save();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id){
        try {
            $category = Category::find($id);
            $category->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function index($id){
        try {
            return Category::where('created_by',$id)->get();
        } catch (\Exception $e) {
           return [];
        }
    }

    public function getProductCategoriesByBranchId($id){
        try {
            return Category::where('branch',$id)->where('type',0)->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getServiceCategoriesByBranchId($id){
        try {
            return Category::where('branch',$id)->where('type',1)->get();
        } catch (\Exception $e) {
            return [];
        }
    }
}