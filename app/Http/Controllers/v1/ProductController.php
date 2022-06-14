<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Setting;

use DB;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    public function create($request){
        try {
            $uid = $request['uid'];
            $product = new Product();
            $image = $request->file('product_image');
            $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
            $destination = 'storage/products';
            $image->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
            $product->created_by = $uid;
            $product->product_image = $url;
            $product->name = $request['name'];
            $product->sku = $request['sku'];
            $product->price = $request['price'];
            $product->stock_item = $request['stock_item'];
            $product->stock = $request['stock'];
            $product->branch = $request['branch'];
            $product->category = $request['category'];
            $product->save();
            return true;
        } catch (\Exception $e) {
           return false;
        }
    }

    public function update($request){
        try {
            $id = $request['id'];
            $image = $request->file('product_image');
            $product = Product::find($id);
            if($image != "" && isset($image)){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $product->product_image = $url;
            }
            $product->name = $request['name'];
            $product->price = $request['price'];
            $product->stock_item = $request['stock_item'];
            $product->stock = $request['stock'];
            $product->branch = $request['branch'];
            $product->category = $request['category'];
            $product->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id){
        try {
            $product = Product::find($id);
            $product->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function index($uid){
        try {
            return Product::where('created_by',$uid)->get();
        } catch (\Exception $e) {
            return [];
        }
    }
    
    public function productsByBranchId($id){
        try {
            return Product::where('branch',$id)->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getLatestProductsByBranchId($id,$limit){
        try {
            return Product::where('branch',$id)->orderBy('id','DESC')->limit($limit)->get();
        } catch (\Exception $e) {
            return [];
        }
    }
}