<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Http\Request;

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



    //for CP
    public function getMyCategories(){
        try {
            $categories =  Category::where('categories.created_by',auth()->user()->id)
            ->join('branches as branch','branch.id','=','categories.branch')
            ->select(['categories.*','branch.branch'])
            ->get();
            return view('categories.index',['categories'=>$categories]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createCategory(){
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('categories.create',['branches'=>$branches]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function storeCategory(Request $request){
        try {
            $name = $request['category_name'];
            $branch = $request['category_branch'];
            $cat_type = $request['service_category'] == "on" ? 1 : 0;
            $image = $request->file('category_image');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $category = new Category();
            $category->created_by = auth()->user()->id;
            $category->category = $name;
            $category->branch = $branch;
            $category->type = $cat_type;
            $category->category_avatar = $url;
            $category->save();
            return redirect('/categories');
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }

    public function editCategory(Request $request){
        try {
            $category = Category::find($request['id']);
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            return view('categories.edit',['branches'=>$branches,'category'=>$category]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } 
    public function updateCategory(Request $request){
        try {
            $id = $request['id'];
            $name = $request['category_name'];
            $branch = $request['category_branch'];
            $cat_type = $request['service_category'] == "on" ? 1 : 0;
            $category = Category::find($id);
            $image = $request->file('category_image');
            if($image !=""){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $category->category_avatar = $url;
            }
            $category->category = $name;
            $category->branch = $branch;
            $category->type = $cat_type;
            $category->save();
            return redirect('/categories');
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    } 
    
}