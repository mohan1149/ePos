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
use App\Models\BusinessOrder;
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
use App\Http\Controllers\v1\BusinessClientController;

class APIController extends Controller
{
    //
    private $productController;
    private $serviceController;
    private $categoryController;
    private $branchController;
    private $userController;
    private $orderController;
    private $sliderController;
    private $bookingController;
    private $businessClientController;

    public function __construct(){
        $this->productController = new ProductController();
        $this->serviceController = new ServiceController();
        $this->categoryController = new CategoryController();
        $this->branchController = new BranchController();
        $this->userController = new UserController();
        $this->orderController = new OrderController();
        $this->sliderController = new SliderController();
        $this->bookingController = new BookingController();
        $this->businessClientController = new BusinessClientController();
    }

    /**
     * APIs Releated to Users
     * START
     */
    public function login(Request $request){
        try{
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $setting = [];
                if($user->active){
                    if($user->role == 1){
                        $setting = Setting::where('created_by',$user->id)->first();
                    }
                    else{
                        $setting = Setting::where('created_by',$user->created_by)->first();
                    }
                    $user->fcm = $request['fcm'];
                    $user->save();
                    $reponse = [
                        'status' => true,
                        'data' => $user,
                        'setting'=>$setting,
                    ];
                }else{
                    $reponse = [
                        'status' => false,
                        'error' => 'user_deactivated',
                    ];
                }
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

    public function updateSettings(Request $request){
        try {
            $status =  $this->userController->editSettings($request);
            $reponse = [
                'status' => $status,
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

    public function updateAvatar(Request $request){
        try {
            $url =  $this->userController->editAvatar($request);
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
            $status =  $this->userController->updatePassword($request);
            $reponse = [
                'status' => $status,
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
            $status = $this->userController->create($request);
            $response = [
                'status' => $status,
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
            $status = $this->userController->edit($request);
            $response = [
                'status' => $status,
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
            $status = $this->userController->destroy($id);
            $response = [
                'status' => $status,
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

    public function getStaffById (Request $request){
        try {
            $id = $request['id'];
            $staff = $this->userController->show($id);
            $response = [
                'status'=> true,
                'staff' => $staff,
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

    public function getBranchStaff(Request $request){
        try {
            $id = $request['id'];
            $staff = $this->userController->branchStaff($id);
            $response = [
                'status'=> true,
                'staff' => $staff,
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
    /**
     * END
     */

    /**
     * APIs Releated to Branches
     * START
     */
    public function addBranch(Request $request){
        try {
            $status = $this->branchController->create($request);
            $response = [
                'status' => $status,
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

    public function branchesByUser(Request $request){
        try {
            $uid = $request['uid'];
            $branches = $this->branchController->index($uid);
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

    public function editBranch(Request $request){
        try {
            $status = $this->branchController->update($request);
            $response = [
                'status' => $status,
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
            $status = $this->branchController->destroy($id);
            $response = [
                'status' => $status,
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
            $branch = $this->branchController->show($id);
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

    /**
     * END
     */
    
    /**
     * APIs Releated to Categories
     */
    public function addCategory(Request $request){
        try {
            $status = $this->categoryController->create($request);
            $response = [
                'status' => $status,
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
            $categories = $this->categoryController->index($uid);
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

    public function editCategory(Request $request){
        try {
            $status = $this->categoryController->edit($request);
            $response = [
                'status' => $status,
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
            $status = $this->categoryController->destroy($id);
            $response = [
                'status' => $status,
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
    /**
     * END
     */
    
    /**
     * APIs Releated to Product
     */
    public function addProduct(Request $request){
        try {
            $status = $this->productController->create($request);
            $response = [
                'status' => $status,
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
            $products = $this->productController->index($uid);
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

    public function editProduct(Request $request){
        try {
            $status = $this->productController->update($request);
            $response = [
                'status' => $status,
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
            $status = $this->productController->destroy($id);
            $response = [
                'status' => $status,
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

    public function getProductCategories(Request $request){
        try {
            $bid = $request['id'];
            $categories = $this->categoryController->getProductCategoriesByBranchId($bid);
            $response = [
                'status'=>true,
                'categories'=>$categories,
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
            $products = $this->productController->productsByBranchId($id);
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

    /**
     * END
     */

    /**
     * APIs Releated to Services
     * START
     */
    public function getServiceCategories(Request $request){
        try {
            $bid = $request['bid'];
            $categories = $this->categoryController->getServiceCategoriesByBranchId($bid);
            $response = [
                'status'=>true,
                'categories'=>$categories,
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

    public function createService(Request $request){
        try {
            $status = $this->serviceController->createService($request);
            if($status){
                $response= [
                    'status'=>true,
                ];
            }else{
                $response= [
                    'status'=>false,
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

    public function getServices(Request $request){
        try {
            $id = $request['uid'];
            $services = $this->serviceController->index($id);
            $response = [
                'status'=>true,
                'services'=>$services,
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

    public function updateService(Request $request){
        try {
            $status = $this->serviceController->update($request);
            $response = [
                'status'=>$status,
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

    public function deleteService(Request $request){
        try {
            $id = $request['id'];
            $status = $this->serviceController->destroy($id);
            $response = [
                'status'=>$status,
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

    public function getServicesByCategory(Request $request){
        try {
            $cid = $request['id'];
            $services = $this->serviceController->getServicesByCategoryId($cid);
            $response = [
                'status'=>true,
                'services'=>$services,
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
    /**
    * END
    */

    /**
     * APIs Releated to Booking
     * START
     */
    public function createBooking(Request $request){
        try {
            $data = $this->bookingController->create($request['bid']);
            $response = [
                'status' => true,
                'staff'=> $data['staff'],
                'categories'=>$data['categories'],
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

    public function storeBooking(Request $request){
        try {
            $status = $this->bookingController->store($request);
            $response = [
                'status' => $status,
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

    public function getBookings(Request $request){
        try {
            $bookings = $this->bookingController->allBookings($request['uid'],$request['date']);
            $response = [
                'status' => true,
                'bookings'=>$bookings,
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
    
    public function deleteBooking(Request $request){
        try {
            $status = $this->bookingController->destroy($request['id']);
            $response = [
                'status' => $status,
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

    public function myBookings(Request $request){
        try {
            $bookings = $this->bookingController->bookingsByStaff($request['id'],$request['date']);
            $response = [
                'status' => true,
                'bookings'=>$bookings,
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

    public function updateBookingStatus(Request $request){
        try {
            $status = $this->bookingController->updateStatus($request['id'],$request['status']);
            $response = [
                'status' => $status,
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
    /**
     * END
     */

    /**
     * APIs Releated to Sliders
     * START
     */
    public function createSlider(Request $request){
        try {
            $status = $this->sliderController->create($request);
            $response = [
                'status' => $status,
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

    public function getSliders(Request $request){
        try {
            $id = $request['uid'];
            $sliders = $this->sliderController->index($id);
            $response = [
                'status' => true,
                'sliders'=>$sliders,
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

    public function editSlider(Request $request){
        try {
            $status = $this->sliderController->edit($request);
            $response = [
                'status' => $status,
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

    public function deleteSlider(Request $request){
        try {
            $id = $request['id'];
            $status = $this->sliderController->destroy($id);
            $response = [
                'status' => $status,
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
    /**
     * END
     */

    /**
     * APIs Releated to OutSide - From Website orders
     * STRAT
     */
    public function getOutsideOrders(Request $request){
        try{
            $orders = $this->orderController->outsideOrders($request['uid'],$request['date']);
            $response = [
                'status' => true,
                'orders'=>$orders,
            ];
            return response()->json($response, 200);
        }catch(\Exception $e){
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function deleteOusideOrder(Request $request){
        try {
            $id = $request['id'];
            $status = $this->orderController->destroyOutsideOrder($id);
            $response = [
                'status' => $status,
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

    public function updateOusideOrder(Request $request){
        try {
            $status = $this->orderController->updateOusideOrderStatus($request);
            $response = [
                'status' => $status,
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
    /**
     * END
     */

    /**
     * APIs Releated to Business Clients
     * START
     *  */ 
    public function addBusinessClient(Request $request){
        try {
            $status = $this->businessClientController->store($request);
            $response = [
                'status' => $status,
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
    public function getBusinessClients(Request $request){
        try {
            $clients = $this->businessClientController->index($request['uid']);
            $response = [
                'status' => true,
                'clients'=>$clients,
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

    public function updateBusinessClient(Request $request){
        try {
            $status = $this->businessClientController->update($request);
            $response = [
                'status' => $status,
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

    public function deleteBusinessClient(Request $request){
        try {
            $status = $this->businessClientController->destroy($request['id']);
            $response = [
                'status' => $status,
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

    public function createBusinessOrder(Request $request){
        try {
            $order = $this->orderController->placeBusinessOrder($request);
            $response = [
                'status' => true,
                'order'=> $order,
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

    public function businessOrderByDriver(Request $request){
        try {
            $orders = $this->orderController->businessOrdersByDriverId($request['id'],$request['date']);
            $response = [
                'status' => true,
                'orders'=> $orders,
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

    public function updateBusinessOrder(Request $request){
        try {
            $status = $this->orderController->updateBusinessOrderById($request);
            $response = [
                'status' => $status,

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

    public function businessOrders(Request $request){
        try {
            $orders = $this->orderController->businessOrdersByUser($request['uid'],$request['date']);
            $response = [
                'status' => true,
                'orders'=> $orders,
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

    public function deleteBusinessOrder(Request $request) {
        try {
            $status = $this->orderController->destroyBusinessOrderById($request['id']);
            $response = [
                'status' => $status,

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

    public function monthlyBusinessOrders(Request $request){
        try{
            $orders = $this->orderController->businessOrderByMonth($request);
            $response = [
                'status' => true,
                'orders'=>$orders
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

    public function businessOrderInvoice(Request $request){
        try{
            return $this->orderController->downloadInvoice(base64_decode($request['id']));
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    /**
     * END
     */
      //Orders
    public function createOrder(Request $request){
        try {
            DB::beginTransaction();
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
                        // 'sale_count' => $item->sale_count + 1,
                    ]);
                }
            }
            $setting = Setting::where('created_by',$request['created_for'])->select(['enable_device_linking'])->first();
            if($setting->enable_device_linking == 1){
                $this->sendOrderPushNotifciation($order->id,$request['lang'],$request['staff']);
            }
            $response = [
                'status' => true,
            ];
            DB::commit();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            DB::rollBack();
            return response()->json($error, 200);
        }
    }
    
    public function sendOrderPushNotifciation($id,$lang,$staff){
        $fcm = DB::table('linked_devices')->where('user_id',$staff)->first();
        if($fcm !="" && isset($fcm)){
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'key=AAAA98fPwvk:APA91bGtjTfJZzacP2KB85xfgyzS5qS_L1Y9GO5qXLf9j3H0RQ6mYpB2aOotQSH_FBTKj5kxG-jvhrgGzO_llgJPDBMg3L4A8t86d9rqFpfKMxJpVw0HUuyZDIvcbSk2oTw7XbyXzY1a'
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $fcm->remote_device_token,
                "notification" => [
                    "title" => "Received Order",
                    "body" => "A new order has been reciced from remote device.",
                ],
                "data"=>[
                    "type"=>"print_order",
                    "id"=>$id,
                    "lang"=>$lang
                ]
            ]);
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

    public function deleteOrder(Request $request){
        try {
            $id = $request['id'];
            $order = Order::find($id);
            $order->delete();
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

    public function monthlyOrders(Request $request){
        try {
            $orders = $this->orderController->ordersByMonth($request);
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

    public function reports(Request $request){
        try {
            $uid = $request['id'];
            $branches = Branch::where('created_by',$uid)->count();
            $staff = User::where('created_by',$uid)->count();
            $products = Product::where('created_by',$uid)->count();
            $orders = Order::where('created_for',$uid)->count();
            $orders_sum = Order::where('created_for',$uid)->sum('final_total');
            $out_of_stock_products = Product::where('created_by',$uid)->where('stock_item',1)
                ->where('stock',0)
                ->count();
            $products_by_branch = Branch::where('branches.created_by',$uid)
                ->leftJoin('products','products.branch','=','branches.id')
                ->selectRaw('branches.id,branches.branch,count(products.id) as tp')
                ->groupBy('branches.id')
                ->groupBy('branches.branch')
                ->get();
            $sales_by_branch = Branch::where('branches.created_by',$uid)
                ->leftJoin('orders','orders.branch','=','branches.id')
                ->selectRaw('branches.id,branches.branch,count(orders.id) as ts,sum(orders.final_total) as tv ')
                ->groupBy('branches.id')
                ->groupBy('branches.branch')
                ->get();
            $business_orders = BusinessOrder::where('created_by',$uid)
                ->selectRaw('count(id) as count,sum(final_total) as total')
                ->first();
            $data = [
                'branches'=>$branches,
                'staff'=>$staff,
                'products'=>$products,
                'out_of_stock_products'=>$out_of_stock_products,
                'orders'=>$orders,
                'products_by_branch'=>$products_by_branch,
                'sales_by_branch'=>$sales_by_branch,
                'orders_sum'=>$orders_sum,
                'business_orders'=> $business_orders,
            ];
            $response = [
                'status' => true,
                'data'=>$data,
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
    
    public function linkDevice(Request $request){
        try {
            $uid = $request['user_id'];
            $remote_device_token = $request['remote_device_token'];
            DB::table('linked_devices')
                ->updateOrInsert(
                    ['user_id' => $uid],
                    ['remote_device_token' => $remote_device_token]
            );
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'key=AAAA98fPwvk:APA91bGtjTfJZzacP2KB85xfgyzS5qS_L1Y9GO5qXLf9j3H0RQ6mYpB2aOotQSH_FBTKj5kxG-jvhrgGzO_llgJPDBMg3L4A8t86d9rqFpfKMxJpVw0HUuyZDIvcbSk2oTw7XbyXzY1a'
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $remote_device_token,
                "notification" => [
                    "title" => "Remote Device Linking",
                    "body" => "Your device is connected with other remote device successfully.",
                ],
                "data"=>[
                    "type"=>"device_linking"
                ]
            ]);
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

    public function getOrderForPushNotification(Request $request){
        try {
            $id = $request['id'];
            $order = $this->orderController->orderForPushNotification($id);
            $response = [
                'status' => true,
                'response' => $order
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
