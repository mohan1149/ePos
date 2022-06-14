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
    }

    public function shopMetaData(Request $request){
        try {
            $sliders = $this->sliderController->branchSliders($request['bid']);
            $categories = $this->categoryController->getProductCategoriesByBranchId($request['bid']);
            $latest_products = $this->productController->getLatestProductsByBranchId($request['bid'],20);
            $settings = $this->userController->settings($request['uid']);
            $meta_data = [
                'sliders'=>$sliders,
                'categories'=>$categories,
                'latest_products'=>$latest_products,
                'settings'=>$settings,
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
}