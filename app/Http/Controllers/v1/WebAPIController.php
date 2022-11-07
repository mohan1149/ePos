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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\ServiceController;
use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\BranchController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\OrderController;
use App\Http\Controllers\v1\SliderController;
use App\Http\Controllers\v1\BookingController;
use App\Http\Controllers\BrandController;

class WebAPIController extends Controller
{
 
    public function __construct(){
        $this->productController = new ProductController();
        $this->serviceController = new ServiceController();
        $this->categoryController = new CategoryController();
        $this->branchController = new BranchController();
        $this->userController = new UserController();
        $this->orderController = new OrderController();
        $this->sliderController = new SliderController();
        $this->bookingController = new BookingController();
        $this->brandController = new BrandController();

    }

    public function shopMetaData(Request $request){
        try {
            $sliders = $this->sliderController->branchSliders($request['bid']);
            $categories = $this->categoryController->getProductCategoriesByBranchId($request['bid']);
            $latest_products = $this->productController->getLatestProductsByBranchId($request['bid'],12);
            $brands = $this->brandController->getBrandsBranchId($request['bid']);
            $settings = $this->userController->settings($request['uid']);
            $branch_data  = $this->branchController->show($request['bid']);
            $meta_data = [
                'sliders'=>$sliders,
                'categories'=>$categories,
                'latest_products'=>$latest_products,
                'brands'=>$brands,
                'settings'=>$settings,
                'branch_data'=>$branch_data,
            ];
            $reponse = [
                'status' => true,
                'meta_data'=> $meta_data,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function productsByCategory(Request $request){
        try {
            $products = $this->productController->productsByCategoryById($request['cid'],$request['bid']);
            $reponse = [
                'status' => true,
                'products'=> $products,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function processOrder(Request $request){
        try {
            $track_id = $this->orderController->processOrderFromOutside($request);
            $reponse = [
                'status' => true,
                'track_id'=>$track_id,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function trackOrder(Request $request){
        try {
            $order_status = $this->orderController->getOrderStatus($request['id']);
            $reponse = [
                'status' => true,
                'order_status'=>$order_status,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    
    public function getBranchProducts(Request $request){
        try {
            $products = $this->productController->productsByBranchId($request['id']);
            $reponse = [
                'status' => true,
                'products'=>$products,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    
    public function getFeaturedBranchProducts(Request $request){
        try {
            $products = $this->productController->featuredProducts($request['id']);
            $reponse = [
                'status' => true,
                'products'=>$products,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function getTopSellingBranchProducts(Request $request){
        try {
            $products = $this->productController->topSellingProducts($request['id']);
            $reponse = [
                'status' => true,
                'products'=>$products,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function getProductDetails(Request $request){
        try {
            $product = $this->productController->getProductByID($request['id']);
            $reponse = [
                'status' => true,
                'product'=>$product,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
                'line'=>$e->getLine(),
            ];
            return response()->json($error, 200);
        }
    }
}