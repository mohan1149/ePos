<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create( $request){
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
            $user->role =  $request['driver'] == 1 ? 2 : 0;
            $user->branch = $request['branch'];
            $user->created_by = $uid;
            $user->avatar = $url;
            $user->password = Hash::make($request['password']);
            $user->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function edit($request){
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
            $user->role =  $request['driver'] == 1 ? 2 : 0;
            $user->branch = $request['branch'];
            $user->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id){
        try {
            $user = User::find($id);
            $user->delete();
            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function index(Request $request){
        try {
            $staff = User::where('created_by',$uid)->where('active',1)->get();
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

    public function editSettings($request){
        try {
            $uid = $request['uid'];
            $decimal = $request['decimal_points'];
            $bookings = $request['enable_bookings'];
            $home_service  = $request['enable_home_service'];
            $enable_device_linking = $request['enable_device_linking'];
            $enable_home_delivery = $request['enable_home_delivery'];
            $show_outof_stock = $request['show_outof_stock'];
            Setting::where('created_by',$uid)->update([
                'decimal_points'=>$decimal,
                'enable_bookings'=>$bookings,
                'enable_home_service'=>$home_service,
                'enable_device_linking'=>$enable_device_linking,
                'enable_home_delivery'=>$enable_home_delivery,
                'show_out_of_stock_products'=>$show_outof_stock,

            ]
            );
            return true;
        } catch (\Exception $e) {
           return false;
        }
    }

    public function editAvatar($request){
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
            
            return $url;
        } catch (\Exception $e) {
           return "";
        }
    }

    public function updatePassword($request){
        try {
            $uid = $request['uid'];
            $password = $request['password'];
            $user = User::find($uid);
            $user->password = Hash::make($password);
            $user->save();
            return true;
        } catch (\Exception $e) {
           return false;
        }
    }

    public function settings($id){
        try {
            return Setting::where('created_by',$id)->first();
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function show($id){
        try {
            return User::where('id',$id)->where('active',1)->first();
        } catch (\Exception $e) {
          return false;
        }
    }

    public function branchStaff($id){
        try {
            return User::where('branch',$id)->where('active',1)->get();
        } catch (\Exception $e) {
            return false;
        }
    }
}