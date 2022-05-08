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
use DB;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
    //

    public function login(Request $request){
        try{
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->fcm = $request['fcm'];
                $user->save();
                $reponse = [
                    'status' => true,
                    'data' => $user,
                ];
            }else{
                $reponse = [
                    'status' => false,
                    'error' => 'invalid_credentials',
                ];
            }
            return response()->json($reponse, 200);
        }catch(\Exception $e){
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function updateAvatar(Request $request){
        try {
            $uid = $request['uid'];
            $user = User::find($uid);
            $avatar = $request->file('avatar');
            $image_name  = uniqid().'.'.$avatar->getClientOriginalExtension();
            $destination = 'storage/avatars';
            $avatar->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/avatars/'.$image_name;
            $user->avatar = $url;
            $user->save();
            $response = [
                'status' => true,
                'data' => $url,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function resetPassword(Request $request){
        try {
            $uid = $request['uid'];
            $password = $request['password'];
            $user = User::find($uid);
            $user->password = Hash::make($password);
            $user->save();
            $reponse = [
                'status' => true,
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

    //Branches
    public function addBranch(Request $request){
        try {
            $uid = $request['uid'];
            $name = $request['branch'];
            $address = $request['address'];
            $branch = new Branch();
            $branch->created_by = $uid;
            $branch->branch = $name;
            $branch->address = $address;
            $branch->save();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function editBranch(Request $request){
        try {
            $id = $request['id'];
            $name = $request['branch'];
            $address = $request['address'];
            $branch = Branch::find($id);
            $branch->branch = $name;
            $branch->address = $address;
            $branch->save();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function deleteBranch(Request $request){
        try {
            $id = $request['id'];
            $branch = Branch::find($id);
            $branch->delete();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function allBranches(Request $request){
        try {
            $uid = $request['uid'];
            $branches = Branch::where('created_by',$uid)->get();
            $response = [
                'status' => true,
                'branches'=>$branches
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function branchByID(Request $request){
        try {
            $id = $request['id'];
            $branch = Branch::find($id);
            $response = [
                'status' => true,
                'branch'=>$branch
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    //Staff
    public function checkEmailExistence(Request $request){
        try {
            $email = $request['email'];
            $count = User::where('email', $email)->count();
            if($count == 0){
                $response = [
                    'status' => true,
                ]; 
            }else{
                $response = [
                    'status' => false,
                ];
            }
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
        
    }

    public function addStaff(Request $request){
        try {
            $uid = $request['uid'];
            $user = new User();
            $avatar = $request->file('avatar');
            $image_name  = uniqid().'.'.$avatar->getClientOriginalExtension();
            $destination = 'storage/avatars';
            $avatar->move($destination, $image_name );
            $url = $request->getSchemeAndHttpHost().'/storage/avatars/'.$image_name;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->role = 0;
            $user->branch = $request['branch'];
            $user->created_by = $uid;
            $user->avatar = $url;
            $user->password = Hash::make($request['password']);
            $user->save();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function editStaff(Request $request){
        try {
            $id = $request['id'];
            $user = User::find($id);
            $avatar = $request->file('avatar');
            if($avatar !== "" && isset($avatar)){
                $image_name  = uniqid().'.'.$avatar->getClientOriginalExtension();
                $destination = 'storage/avatars';
                $avatar->move($destination, $image_name );
                $url = $request->getSchemeAndHttpHost().'/storage/avatars/'.$image_name;
                $user->avatar = $url;
            }
            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->branch = $request['branch'];
            $user->save();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function deleteStaff(Request $request){
        try {
            $id = $request['id'];
            $user = User::find($id);
            $user->delete();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function allStaff(Request $request){
        try {
            $uid = $request['uid'];
            $staff = User::where('created_by',$uid)->get();
            $response = [
                'status' => true,
                'staff'=>$staff
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    
    //Categories
    public function addCategory(Request $request){
        try {
            $uid = $request['uid'];
            $name = $request['category'];
            $branch = $request['branch'];
            $category = new Category();
            $category->created_by = $uid;
            $category->category = $name;
            $category->branch = $branch;
            $category->save();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function editCategory(Request $request){
        try {
            $id = $request['id'];
            $name = $request['category'];
            $branch = $request['branch'];
            $category = Category::find($id);
            $category->category = $name;
            $category->branch = $branch;
            $category->save();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function deleteCategory(Request $request){
        try {
            $id = $request['id'];
            $category = Category::find($id);
            $category->delete();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    
    public function allCategories(Request $request){
        try {
            $uid = $request['uid'];
            $categories = Category::where('created_by',$uid)->get();
            $response = [
                'status' => true,
                'categories'=>$categories
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function categoriesByBranch(Request $request){
        try {
            $id = $request['id'];
            $categories = Category::where('branch',$id)->get();
            $response = [
                'status' => true,
                'categories'=>$categories
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    //Products
    public function addProduct(Request $request){
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
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function editProduct(Request $request){
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
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function deleteProduct(Request $request){
        try {
            $id = $request['id'];
            $product = Product::find($id);
            $product->delete();
            $response = [
                'status' => true,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function allProducts(Request $request){
        try {
            $uid = $request['uid'];
            $products = Product::where('created_by',$uid)->get();
            $response = [
                'status' => true,
                'products'=>$products,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function productsByBranch(Request $request){
        try {
            $id = $request['id'];
            $products = Product::where('branch',$id)->get();
            $response = [
                'status' => true,
                'products'=>$products,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    //Orders
    public function createOrder(Request $request){
        try {
            $order = new Order();
            $order->tsid = $request['order_id'];
            $order->order_for = $request['order_for'];
            $order->branch = $request['branch'];
            $order->staff = $request['staff'];
            $order->order_items = $request['order_items'];
            $order->created_for = $request['created_for'];
            $order->total = $request['total'];
            $order->discount = $request['discount'];
            $order->discount_amount = $request['discount_amount'];
            $order->final_total = $request['final_total'];
            $order->save();
            $order_items = json_decode($request['order_items']);
            foreach ($order_items as $item) {
                if($item->stock_item == 1){
                    DB::table('products')->where('id',$item->id)->update([
                        'stock' => $item->stock - $item->quantity,
                    ]);
                }
            }
            $response = [
                'status' => true,

            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    
    public function allOrders(Request $request){
        try {
            $uid = $request['uid'];
            $date = $request['date'];
            $orders = Order::where('created_for',$uid)
            ->whereDate('created_at',$date)
            ->get();
            $response = [
                'status' => true,
                'orders' =>$orders

            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function ordersByStaff(Request $request){
        try {
            $sid = $request['id'];
            $date = $request['date'];
            $orders = Order::where('staff',$sid)
            ->whereDate('created_at',$date)
            ->get();
            $response = [
                'status' => true,
                'orders' =>$orders

            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
}
