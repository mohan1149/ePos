<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Setting;
use PDF;
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
            $product->sku = $request['sku'];
            $product->stock_item = $request['stock_item'];
            $product->featured = $request['featured'];
            $product->show_on_website = $request['showonWebsite'];
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
            return Product::where('branch',$id)->orderBy('id','DESC')->get();
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

    public function productsByCategoryById($cid,$bid){
        try {
            return Product::where('branch',$bid)
                ->orderBy('id','DESC')
                ->where('category',$cid)
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function featuredProducts($bid){
        try {
            return Product::where('branch',$bid)
                ->orderBy('id','DESC')
                ->where('featured',1)
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function topSellingProducts($bid){
        try {
            return Product::where('branch',$bid)
                ->orderBy('sale_count','DESC')
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function barcodes(){
        try {
            $products = Product::all();
            //return view('products.barcodes',['products'=>$products])->render();
            $content = view('products.barcodes',['products'=>$products])->render();
                $mpdf = new \Mpdf\Mpdf([
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 10,
                    'margin_bottom' => 10,
                    'margin_header' => 10,
                    'margin_footer' => 10
                ]);
                $mpdf->SetProtection(array('print'));
                // $mpdf->SetTitle("iTenant - Rent Invoice");
                // $mpdf->SetWatermarkText("Sale Invoice");
                // $mpdf->showWatermarkText = true;
                // $mpdf->watermarkTextAlpha = 0.1;
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->WriteHTML($content);
                $mpdf->Output();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getProductByID($id){
        return Product::find($id);
    }



    /// for CP
    public function getMyProducts(){
        try {
            $products =  Product::where('products.created_by',auth()->user()->id)
            ->join('branches as branch','branch.id','=','products.branch')
            ->select(['products.*','branch.branch as product_branch'])
            ->get();
            return view('products.index',['products'=>$products]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function editMyProduct(Request $request){
        try {
            $product = Product::where('id',$request['id'])->where('created_by',auth()->user()->id)->first();
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id');
            $brands = Brand::where('branch',$product->branch)->get()->pluck('name','id');
            $categories = Category::where('branch',$product->branch)->where('type',0)->get()->pluck('category','id');
            return view('products.edit',['product'=>$product,'branches'=>$branches,'brands'=>$brands,'categories'=>$categories]);
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }

    public function getCategoriesAndBrandsByBranch(Request $request){
        try {
            $categories = Category::where('branch',$request['bid'])->where('type',0)->get();
            $brands = Brand::where('branch',$request['bid'])->get();
            return response()->json(['categories'=>$categories,'brands'=>$brands], 200);
        } catch (\Exception $e) {
            return response()->json(['categories'=>[],'brands'=>[]], 200);
        }

    }
    public function updateMyProduct(Request $request){
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
            $product->name = $request['product_name'];
            $product->price = $request['product_price'];
            $product->sku = $request['product_sku'];
            $product->featured = $request['featured'] == 'on' ? 1 : 0;
            $product->stock_item = $request['stock_item'] == 'on' ? 1 : 0;
            $product->stock = $request['stock'];
            $product->branch = $request['product_branch'];
            $product->category = $request['category'];
            $product->product_description = $request['product_description'];
            $product->cost_price = $request['cost_price'];
            $product->brand = $request['brand'];
            $product->save();
            return redirect('/products');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductMedia(Request $request){
        try {
            $product = Product::find($request['id']);
            return view('products.media',['product'=>$product]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateProductMedia(Request $request){
        try {
            $product = Product::find($request['id']);
            $url = [];
            if($request['append'] == 1){
                $url = json_decode($request['existing_media']);
            }
            if($request->hasfile('product_images')){
                foreach($request->file('product_images') as $file){
                    $image_name  = uniqid().'.'.$file->getClientOriginalExtension();
                    $destination = 'storage/products';
                    $file->move($destination, $image_name);
                    $url[] = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                }
            }
            $product->product_images = json_encode($url);
            $product->save();
            return redirect('/products');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function createProduct(){
        try {
            $branches = Branch::where('created_by',auth()->user()->id)->get()->pluck('branch','id')->prepend('Choose Branch','0');
            return view('products.create',['branches'=>$branches,'brands'=>[],'categories'=>[]]);
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }
    public function storeProduct(Request $request){
        try {
            $image = $request->file('product_image');
            $product = new Product();
            if($image != "" && isset($image)){
                $image_name  = uniqid().'.'.$image->getClientOriginalExtension();
                $destination = 'storage/products';
                $image->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/products/'.$image_name;
                $product->product_image = $url;
            }
            $product->created_by = auth()->user()->id;
            $product->name = $request['product_name'];
            $product->price = $request['product_price'];
            $product->sku = $request['product_sku'];
            $product->stock_item = $request['stock_item'] == 'on' ? 1 : 0;
            $product->featured = $request['featured'] == 'on' ? 1 : 0;
            $product->stock = $request['stock'];
            $product->branch = $request['product_branch'];
            $product->category = $request['category'];
            $product->product_description = $request['product_description'];
            $product->cost_price = $request['cost_price'];
            $product->brand = $request['brand'];
            $product->save();
            return redirect('/products');
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }
    
}